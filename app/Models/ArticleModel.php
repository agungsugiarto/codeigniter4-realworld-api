<?php

namespace App\Models;

use App\Entities\ArticleEntity;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use Faker\Generator;

class ArticleModel extends Model
{
    protected $table          = 'articles';
    protected $primaryKey     = 'id';
    protected $returnType     = ArticleEntity::class;
    protected $allowedFields  = ['user_id', 'slug', 'title', 'description', 'body'];
    protected $useTimestamps  = true;
    protected $skipValidation = true;

    /**
     * Generate fake data.
     *
     * @param Generator $faker
     * @return array
     */
    public function fake($faker)
    {
        return [
            'user_id'     => $faker->numberBetween(1, 50),
            'title'       => $title = $faker->sentence,
            'slug'        => url_title($title, '-', true),
            'description' => $faker->sentence(10),
            'body'        => $faker->paragraphs($faker->numberBetween(1, 3), true),
        ];
    }

    /**
     * Insert article.
     *
     * @return mixed
     */
    public function insertArticle(object $request)
    {
        return $this->insert([
            'user_id'     => auth('token')->user()->id,
            'title'       => $request->title,
            'slug'        => url_title($request->title, '-', true),
            'body'        => $request->body,
            'description' => $request->description,
        ]);
    }

    /**
     * Update article.
     *
     * @return mixed
     */
    public function updateArticle(object $request, string $slug)
    {
        return $this->where('slug', $slug)->set([
            'body'        => $request->body,
            'description' => $request->description,
        ])->update();
    }

    /**
     * Insert article tag id.
     *
     * @param array $tags
     * @param string $slug
     * @return int
     */
    public function insertArticleTags(array $tags, int $tagID)
    {
        foreach ($tags as $tag) {
            $tagsKey[] = [
                'article_id' => $tagID,
                'tag_id'     => is_object($tag) ? $tag->id : $tag,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
        }

        return $this->db->table('article_tag')->insertBatch($tagsKey);
    }

    /**
     * Update article tag id.
     *
     * @param array tags
     * @return mixed
     */
    public function updateArticleTags(array $tags, string $slug)
    {
        $tagID = $this->where('slug', $slug)->first()->id;
        $this->db->table('article_tag')->where('article_id', $tagID)->delete();

        return $this->insertArticleTags($tags, $tagID);
    }

    /**
     * Create favorites.
     *
     * @param array $attributes
     * @return mixed
     */
    public function createFavorites(array $attributes)
    {
        $instance = $this->db->table('favorites')
            ->where([
                'user_id'    => auth('token')->user()->id,
                'article_id' => $attributes['article_id'],
            ])
            ->get()
            ->getFirstRow();

        if (is_null($instance)) {
            return $this->db->table('favorites')
                ->insert([
                    'user_id'    => auth('token')->user()->id,
                    'article_id' => $attributes['article_id'],
                    'created_at' => Time::now(),
                    'updated_at' => Time::now(),
                ]);
        }

        return $instance;
    }

    /**
     * Delete favorites.
     *
     * @param array $attributes
     * @return mixed
     */
    public function deleteFavorites(array $attributes)
    {
        return $this->db->table('favorites')
            ->where([
                'user_id'    => auth('token')->user()->id,
                'article_id' => $attributes['article_id'],
            ])
            ->delete();
    }
}
