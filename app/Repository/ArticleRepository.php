<?php

namespace App\Repository;

use App\Models\ArticleModel;
use App\Scopes\FilterScope;
use CodeIgniter\HTTP\IncomingRequest;
use Config\Database;
use Fluent\Repository\Eloquent\BaseRepository;

class ArticleRepository extends BaseRepository
{
    /**
     * {@inheritdoc}
     */
    protected $searchable = [
        'description' => 'like',
        'bio'         => 'like',
    ];

    /**
     * {@inheritdoc}
     */
    public function scope(IncomingRequest $request)
    {
        parent::scope($request);

        $this->entity = (new FilterScope($request))->scope($this->entity);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function entity()
    {
        return ArticleModel::class;
    }

    /**
     * Select actually needed query.
     *
     * @return array
     */
    public function select()
    {
        if (Database::connect()->DBDriver === 'MySQLi') {
            return $this->selectMySQLi();
        }

        return $this->selectPosgre();
    }

    /**
     * Select database by driver MySQLi.
     *
     * @return array
     */
    protected function selectMySQLi()
    {
        return [
            "articles.id",
            "articles.slug",
            "articles.title",
            "articles.description",
            "articles.body",
            "articles.created_at",
            "articles.updated_at",
            "users.username",
            "users.bio",
            "users.image",
            "GROUP_CONCAT(tags.title SEPARATOR ',') AS tags",
        ];
    }

    /**
     * Select database by driver Posgre.
     *
     * @return array
     */
    protected function selectPosgre()
    {
        return [
            "articles.id",
            "articles.slug",
            "articles.title",
            "articles.description",
            "articles.body",
            "articles.created_at",
            "articles.updated_at",
            "users.username",
            "users.bio",
            "users.image",
            "array_to_string(array_agg(tags.title), ',') AS tags",
        ];
    }
}
