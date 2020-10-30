<?php

namespace App\Transformers;

use App\Entities\CommentEntity;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    /**
     * {@inheritdo}
     */
    public function transform(CommentEntity $comment)
    {
        return [
            'id'        => $comment->id,
            'body'      => $comment->body,
            'author'    => [
                'username'  => $comment->username,
                'bio'       => $comment->bio,
                'image'     => $comment->image,
                'following' => $comment->isFollowing(),
            ],
            'createdAt' => $comment->created_at,
            'updatedAt' => $comment->updated_at,
        ];
    }
}
