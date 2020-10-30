<?php

namespace App\Scopes\Clauses;

use Fluent\Repository\Scopes\ScopeAbstract;

class AuthorScope extends ScopeAbstract
{
    /**
     * {@inheritdoc}
     */
    public function scope($builder, $value, $scope)
    {
        return $builder->like('users.username', $value);
    }
}
