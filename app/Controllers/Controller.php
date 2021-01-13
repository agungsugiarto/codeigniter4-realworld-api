<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use App\Transformers\CodeIgniterPaginatorAdapter;
use App\Transformers\CustomSerializer;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller as BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;
use League\Fractal\TransformerAbstract;
use Psr\Log\LoggerInterface;

class Controller extends BaseController
{
    use ResponseTrait;

    /** @var \League\Fractal\Manager */
    protected $fractal;

    public function __construct()
    {
        $this->fractal = new Manager();
    }

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['auth'];
    
    /**
     * {@inheritdoc}
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    /**
     * Build resource item data using fractal.
     *
     * @param array $data
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param string $key
     * @return \CodeIgniter\HTTP\Response
     */
    public function fractalItem($data, TransformerAbstract $transformer, $key = 'data')
    {
        return $this->respond(
            (new Manager())
                ->setSerializer(new CustomSerializer())
                ->createData(new Item($data, $transformer, $key))
                ->toArray()
        );
    }

    /**
     * Build resource collection data using fractal.
     *
     * @param array $data
     * @param \League\Fractal\TransformerAbstract $transformer
     * @param string $key
     * @return \CodeIgniter\HTTP\Response
     */
    public function fractalCollection($data, TransformerAbstract $transformer, $key = 'data')
    {
        return $this->respond(
            (new Manager())
                ->setSerializer(new JsonApiSerializer())
                ->createData((new Collection($data['data'], $transformer, $key))
                ->setPaginator(new CodeIgniterPaginatorAdapter($data['paginate'])))
                ->toArray()
        );
    }

    /**
     * Used for generic success response delete.
     *
     * @param string|array $messages
     * @param integer|null $status        HTTP status code
     * @param string|null  $code          Custom, API-specific, error code
     * @param string       $customMessage
     *
     * @return mixed
     */
    protected function deleteResponse($messages, int $status = 200, string $code = null, string $customMessage = '')
    {
        if (! is_array($messages)) {
            $messages = ['success' => $messages];
        }

        $response = [
            'status'   => $status,
            'error'    => $code === null ? $status : $code,
            'messages' => $messages,
        ];

        return $this->respond($response, $status, $customMessage);
    }
    
    /**
     * Generate response error with spesification conduit.
     *
     * @param array $errors
     * @return array
     */
    protected function parseError(array $errors)
    {
        foreach ($errors as $key => $error) {
            $parser['errors'][$key] = [$error];
        }

        return $parser;
    }
}
