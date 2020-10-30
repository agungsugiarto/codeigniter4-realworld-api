<?php

namespace App\Transformers;

use App\Entities\TagEntity;
use App\Entities\UserEntity;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    /**
     * {@inheritdo}
     */
    public function transform(TagEntity $tags)
    {
        return [
            'id'        => $tags->id,
            'title'     => $tags->title,
            'createdAt' => $tags->created_at,
            'updatedAt' => $tags->updated_at,
        ];
    }
}
