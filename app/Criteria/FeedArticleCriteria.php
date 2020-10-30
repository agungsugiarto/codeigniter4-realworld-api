<?php

namespace App\Criteria;

use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;
use Config\Services;
use Fluent\Repository\Contracts\CriterionInterface;

class FeedArticleCriteria implements CriterionInterface
{
    /**
     * {@inheritdoc}
     */
    public function apply(Model $entity)
    {
        return $entity
            ->whereIn('articles.user_id', function (BaseBuilder $builder) {
                return $builder
                    ->select('followed_id')
                    ->from('follows')
                    ->where('follower_id', Services::auth()->user()->id);
            });
    }
}
