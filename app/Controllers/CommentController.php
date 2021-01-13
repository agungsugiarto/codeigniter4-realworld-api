<?php

namespace App\Controllers;

use App\Criteria\CommentCriteria;
use App\Models\DB;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Transformers\CommentTransformer;
use Config\Services;

class CommentController extends Controller
{
    /** @var \App\Repository\ArticleRepository */
    protected $article;
    
    /** @var \App\Repository\CommentRepository */
    protected $repository;

    /**
     * Comment controller constructor.
     */
    public function __construct()
    {
        $this->article = new ArticleRepository();
        $this->repository = new CommentRepository();
    }

    /**
     * Get all the comments of the articles given by slug.
     *
     * @param string $slug
     * @return \CodeIgniter\HTTP\Response
     */
    public function index(string $slug)
    {
        $article = $this->article->findWhere(['slug' => $slug])->first();

        if (is_null($article)) {
            return $this->fail("Article with slug {$slug} not found!");
        }

        $resources = $this->repository
            ->scope($this->request)
            ->withCriteria([new CommentCriteria()])
            ->findWhere(['article_id' => $article->id])
            ->paginate();

        return $this->fractalCollection($resources, new CommentTransformer(), 'comments');
    }

    /**
     * Add comment to the article given its slug and return comment if successfull.
     *
     * @param string $slug
     * @return \CodeIgniter\HTTP\Response
     */
    public function store(string $slug)
    {
        $request = (object) $this->request->getPost();
        $article = $this->article->findWhere(['slug' => $slug])->first();

        if (is_null($article)) {
            return $this->fail("Article with slug {$slug} not found!");
        }

        if (! $this->validate(['body' => 'required'])) {
            return $this->fail(
                $this->parseError($this->validator->getErrors())
            );
        }

        $commentID = $this->repository->create([
            'user_id'    => auth('token')->user()->id,
            'article_id' => $article->id,
            'body'       => $request->body
        ]);

        $resources = $this->repository->find($commentID);

        return $this->fractalItem($resources, new CommentTransformer(), 'comment');
    }

    /**
     * Delete the comment given by id.
     *
     * @param string $slug
     * @param int $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function destroy(string $slug, int $id)
    {
        $article = $this->article->findWhere(['slug' => $slug])->first();
        $comment = $this->repository->find($id);

        if (is_null($article)) {
            return $this->fail("Article with slug {$slug} not found!");
        }

        if (is_null($comment)) {
            return $this->fail("Comment with id {$id} not found!");
        }

        $this->repository
            ->findWhere([
                'user_id'    => auth('token')->user()->id,
                'article_id' => $article->id
            ])
            ->destroy($id);

        if (! DB::affectedRows()) {
            return $this->fail("Failed delete comment article $slug");
        }

        return $this->respondDeleted("Comment with id {$id} success deleted!");
    }
}
