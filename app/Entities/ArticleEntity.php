<?php

namespace App\Entities;

use App\Models\DB;
use CodeIgniter\Entity;
use Config\Services;

class ArticleEntity extends Entity
{
    /**
     * Is favorited by user.
     *
     * @return bool
     */
    public function isFavoritedByUser()
    {
        return DB::table('favorites')
            ->selectCount('article_id', 'count')
            ->where('user_id', Services::auth()->user()->id ?? 0)
            ->where('article_id', $this->id)
            ->get()
            ->getRow()
            ->count != 0;
    }

    /**
     * Get count favorites by article.
     *
     * @return object
     */
    public function favorites()
    {
        return DB::table('favorites')
            ->selectCount('article_id', 'count')
            ->where('article_id', $this->id)
            ->get()
            ->getRow();
    }
}
