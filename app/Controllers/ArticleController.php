<?php

namespace App\Controllers;

use App\Criteria\ArticleCriteria;
use App\Criteria\FeedArticleCriteria;
use App\Models\ArticleModel;
use App\Models\DB;
use App\Models\TagModel;
use App\Repository\ArticleRepository;
use App\Transformers\ArticleTransformer;
use App\Validations\ArticleValidation;
use CodeIgniter\I18n\Time;
use Config\Services;

class ArticleController extends Controller
{
    /** @var \App\Repository\ArticleRepository */
    protected $repository;

    /** @var \App\Models\ArticleModel */
    protected $article;

    /** @var \App\Models\TagModel */
    protected $tag;

    /**
     * ArticleController constructor.
     */
    public function __construct()
    {
        $this->repository = new ArticleRepository();
        $this->article = new ArticleModel();
        $this->tag = new TagModel();
    }

    /**
     * Get all the articles.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function index()
    {
        $resources = $this->repository
            ->scope($this->request)
            ->withCriteria([new ArticleCriteria()])
            ->paginate(null, $this->repository->select());

        return $this->fractalCollection($resources, new ArticleTransformer(), 'articles');
    }

    /**
     * Create a new article and return the article if successfull.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function store()
    {
        $request = (object) $this->request->getPost();

        if (! $this->validate(ArticleValidation::insert())) {
            return $this->fail(
                $this->parseError($this->validator->getErrors())
            );
        }

        DB::transBegin();

        try {
            $tags = array_map(function ($title) {
                return $this->tag->firstOrCreate(['title' => $title]);
            }, $request->tagList);

            $tagID = $this->article->insertArticle($request);
            $this->article->insertArticleTags($tags, $tagID);

            DB::transCommit();
        } catch (\Exception $e) {
            DB::transRollback();

            return $this->fail($e->getMessage());
        }

        return $this->show($this->repository->find($tagID)->slug);
    }

    /**
     * Feed articles created by user followed.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function feed()
    {
        $resource = $this->repository
            ->scope($this->request)
            ->withCriteria([
                new ArticleCriteria(),
                new FeedArticleCriteria(),
            ])
            ->orderBy('articles.created_at')
            ->paginate(null, $this->repository->select());

        return $this->fractalCollection($resource, new ArticleTransformer(), 'articles');
    }

    /**
     * Get the article given by its slug.
     *
     * @param string $slug
     * @return \CodeIgniter\HTTP\Response
     */
    public function show(string $slug)
    {
        $resources = $this->repository
            ->withCriteria([new ArticleCriteria()])
            ->findWhere(['slug' => $slug])
            ->first($this->repository->select());

        if (is_null($resources)) {
            return $this->fail("Article with slug {$slug} not found!", 404);
        }
            
        return $this->fractalItem($resources, new ArticleTransformer(), 'article');
    }

    /**
     * Update the article given its slug and return if successfull.
     *
     * @param string $slug
     * @return \CodeIgniter\HTTP\Response
     */
    public function update(string $slug)
    {
        $request = (object) $this->request->getRawInput();
        $ignore = implode('.', $request->tagList);
        
        if (is_null($article = $this->getArticle($slug))) {
            return $this->fail("Article with slug {$slug} not found!", 404);
        }

        if (! $this->validate(ArticleValidation::update($article->title, $ignore))) {
            return $this->fail(
                $this->parseError($this->validator->getErrors())
            );
        }

        DB::transBegin();

        try {
            $tags = array_map(function ($title) {
                return $this->tag->firstOrCreate(['title' => $title]);
            }, $request->tagList);
            
            $this->article->updateArticle($request, $slug);
            $this->article->updateArticleTags($tags, $slug);

            DB::transCommit();
        } catch (\Exception $e) {
            DB::transRollback();

            return $this->fail($e->getMessage());
        }

        return $this->show($article->slug);
    }

    /**
     * Delete the article given by its slug.
     *
     * @param string $slug
     * @return \CodeIgniter\HTTP\Response
     */
    public function destroy(string $slug)
    {
        if (is_null($this->getArticle($slug))) {
            return $this->fail("Article with slug {$slug} not found!", 404);
        }

        $this->article
            ->where('user_id', auth('token')->user()->id)
            ->where('slug', $slug)
            ->delete();
        
        if (! DB::affectedRows()) {
            return $this->fail("Article with $slug error deleted");
        }

        return $this->deleteResponse("Article $slug success deleted");
    }

    /**
     * Add favorited article.
     *
     * @param string $slug
     * @return \CodeIgniter\HTTP\Response
     */
    public function addFavorite(string $slug)
    {
        if (is_null($article = $this->getArticle($slug))) {
            return $this->fail("Article with slug {$slug} not found!", 404);
        }

        $this->article->createFavorites(['article_id' => $article->id]);

        return $this->show($slug);
    }

    /**
     * Delete favorited article.
     *
     * @param string $slug
     * @return \CodeIgniter\HTTP\Response
     */
    public function unFavorite(string $slug)
    {
        if (is_null($article = $this->getArticle($slug))) {
            return $this->fail("Article with slug {$slug} not found!", 404);
        }

        $this->article->deleteFavorites(['article_id' => $article->id]);

        return $this->show($slug);
    }

    /**
     * Get the article by given a slug.
     *
     * @param string $slug
     * @return \App\Entities\ArticleEntity|null
     */
    protected function getArticle(string $slug)
    {
        return $this->repository
            ->findWhere(['slug' => $slug])
            ->first();
    }
}
