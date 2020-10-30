<?php

namespace App\Scopes;

use App\Scopes\Clauses\AuthorScope;
use App\Scopes\Clauses\FavoriteScope;
use App\Scopes\Clauses\TagScope;
use App\Scopes\Clauses\TextScope;
use App\Scopes\Clauses\TitleScope;
use Fluent\Repository\Scopes\ScopesAbstract;

class FilterScope extends ScopesAbstract
{
    protected $scopes = [
        'author'    => AuthorScope::class,
        'text'      => TextScope::class,
        'title'     => TitleScope::class,
        'tag'       => TagScope::class,
        'favorited' => FavoriteScope::class,
    ];
}
