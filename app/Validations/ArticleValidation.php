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
            'description' => 'required',
            'body'        => 'required',
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
    public static function update(string $title, string $ignore)
    {
        return [
            'title'       => "required|is_unique[articles.title,title,$title]",
            'description' => "required",
            'body'        => "required",
            'tagList'     => "required|unique[tags.title,title,$ignore]",
        ];
    }
}
