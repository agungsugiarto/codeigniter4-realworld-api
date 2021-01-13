<?php

namespace App\Validations;

class ArticleValidation
{
    /**
     * Store validation article.
     *
     * @return array
     */
    public static function insert()
    {
        return [
            'title'       => 'required|is_unique[articles.title]',
            'description' => 'required|min_length[5]',
            'body'        => 'required|min_length[5]',
            'tagList'     => 'required|unique[tags.title]',
        ];
    }

    /**
     * Update validation article.
     *
     * @param string $title
     * @param string $ignore
     * @return array
     */
    public static function update(string $ignore)
    {
        return [
            'description' => "required|min_length[5]",
            'body'        => "required|min_length[5]",
            'tagList'     => "required|unique[tags.title,title,$ignore]",
        ];
    }
}
