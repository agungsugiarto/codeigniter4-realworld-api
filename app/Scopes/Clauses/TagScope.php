<?php

namespace App\Scopes\Clauses;

use Fluent\Repository\Scopes\ScopeAbstract;

class TagScope extends ScopeAbstract
{
    /**
     * {@inheritdoc}
     */
    public function scope($builder, $value, $scope)
    {
        return $builder->whereIn('tags.title', explode(',', $value));
    }
}
