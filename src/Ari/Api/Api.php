<?php

namespace Ari\Api;

use Ari\Exception\ConflictException;
use Ari\Exception\InvalidParameterException;
use Ari\Exception\ForbiddenException;
use Ari\Exception\NotFoundException;
use Ari\Exception\ServerException;
use Ari\Exception\UnprocessableEntityException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class Api
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create and send an HTTP request.
     *
     * @param string $method
     * @param string $uri
     * @param array  $pramas
     * @return \GuzzleHttp\Psr7\Response
     */
    public function request($method, $uri, array $pramas = [])
    {
        try {
            return $this->client->request($method, $uri, [
                'form_params' => $pramas
            ]);
        } catch (RequestException $e) {
            $this->processRequestException($e);
        }
    }

    /**
     * @param RequestException $e
     * @throws ConflictException
     * @throws ForbiddenException
     * @throws InvalidParameterException
     * @throws NotFoundException
     * @throws UnprocessableEntityException
     * @throws ServerException
     */
    protected function processRequestException(RequestException $e) {
        switch ($e->getCode()) {
            case 400:
                throw new InvalidParameterException($e);
            case 403:
                throw new ForbiddenException($e);
            case 404:
                throw new NotFoundException($e);
            case 409:
                throw new ConflictException($e);
            case 422:
                throw new UnprocessableEntityException($e);
            case 500:
                throw new ServerException($e);
            default:
                throw $e;
        }
    }

    /**
     * Get a new data model object, set given response on it 
     *
     * @param ResponseInterface $response
     * @param string $className
     * @return \Ari\Models\Model
     */
    protected function build(ResponseInterface $response, $className)
    {
        $data = \GuzzleHttp\json_decode($response->getBody());
        if (is_array($data)) {
            $list = [];
            foreach ($data as $object) {
                $list[] = new $className($object);
            }
 
            return $list;
        }

        return new $className($data);
    }
}
