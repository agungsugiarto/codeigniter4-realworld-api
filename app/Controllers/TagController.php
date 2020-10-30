<?php

namespace App\Controllers;

use App\Repository\TagRepository;
use App\Transformers\TagTransformer;

class TagController extends Controller
{
    /** @var \App\Repository\TagRepository */
    protected $repository;

    /**
     * Tag controller constructor.
     */
    public function __construct()
    {
        $this->repository = new TagRepository();
    }

    /**
     * Get all resource tags.
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function index()
    {
        $resources = $this->repository->scope($this->request)->paginate();

        return $this->fractalCollection($resources, new TagTransformer(), 'tags');
    }
}
