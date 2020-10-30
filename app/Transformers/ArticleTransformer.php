<?php

namespace App\Transformers;

use App\Entities\ArticleEntity;
use League\Fractal\TransformerAbstract;

class ArticleTransformer extends TransformerAbstract
{
    /**
     * {@inheritdoc}
     */
    public function transform(ArticleEntity $article)
    {
        return [
            'id'             => $article->id,
            'slug'           => $article->slug,
            'title'          => $article->title,
            'description'    => $article->description,
            'body'           => $article->body,
            'tagList'        => explode(',', $article->tags),
            'favorited'      => $article->isFavoritedByUser(),
            'favoritesCount' => $article->favorites()->count,
            'author' => [
                'username' => $article->username,
                'bio'      => $article->bio,
                'image'    => $article->image,
            ],
            'createdAt'      => $article->created_at,
            'updatedAt'      => $article->updated_at,
        ];
    }
}
