<?php

namespace App\Criteria;

use CodeIgniter\Model;
use Fluent\Repository\Contracts\CriterionInterface;

class ArticleCriteria implements CriterionInterface
{
    /**
     * {@inheritdoc}
     */
    public function apply(Model $entity)
    {
        return $entity
            ->join('users', 'articles.user_id = users.id')
            ->join('article_tag', 'article_tag.article_id = articles.id', 'left')
            ->join('tags', 'article_tag.tag_id = tags.id', 'left')
            ->groupBy([
                'articles.id',
                'users.username',
                'users.bio',
                'users.image'
            ]);
    }
}
