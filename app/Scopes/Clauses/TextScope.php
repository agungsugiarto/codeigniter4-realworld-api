<?php

namespace App\Scopes\Clauses;

use Fluent\Repository\Scopes\ScopeAbstract;

class TextScope extends ScopeAbstract
{
    /**
     * {@inheritdoc}
     */
    public function scope($builder, $value, $scope)
    {
        return $builder->like('articles.body', $value);
    }
}
