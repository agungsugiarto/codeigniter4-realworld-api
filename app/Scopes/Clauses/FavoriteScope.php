<?php

namespace App\Scopes\Clauses;

use App\Models\UserModel;
use CodeIgniter\Database\BaseBuilder;
use Fluent\Repository\Scopes\ScopeAbstract;

class FavoriteScope extends ScopeAbstract
{
    /**
     * {@inheritdoc}
     */
    public function scope($builder, $value, $scope)
    {
        $user = (new UserModel())->where('username', $value)->first();

        // Result to the null query when user is not found.
        if (is_null($user)) {
            return $builder->where('users.username', null);
        }

        // Articles favorited by user.
        return $builder->whereIn('articles.id', function (BaseBuilder $query) use ($user) {
            return $query->select('article_id')
                ->from('favorites')
                ->where('user_id', $user->id);
        });
    }
}
