<?php

namespace App\Scopes\Clauses;

use Fluent\Repository\Scopes\ScopeAbstract;

class TitleScope extends ScopeAbstract
{
    /**
     * {@inheritdoc}
     */
    public function scope($builder, $value, $scope)
    {
        return $builder->like('articles.title', $value);
    }
}
