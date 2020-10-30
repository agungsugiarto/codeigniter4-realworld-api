<?php

namespace App\Criteria;

use CodeIgniter\Model;
use Fluent\Repository\Contracts\CriterionInterface;

class CommentCriteria implements CriterionInterface
{
    /**
     * {@inheritdoc}
     */
    public function apply(Model $entity)
    {
        return $entity
            ->join('articles', 'comments.article_id = articles.id')
            ->join('users', 'comments.user_id = users.id');
    }
}
