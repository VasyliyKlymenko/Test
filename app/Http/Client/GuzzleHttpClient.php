<?php

namespace App\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;

/**
 * HTTP client for use with the API using Guzzle
 * @package App\Http\Client
 */
class GuzzleHttpClient implements HttpClientInterface
{
    /**
     * The GuzzleHttp client
     * @var Client $client
     */
    private $guzzle;

    /**
     * @param array|null $config // Guzzle HTTP configuration options
     */
    public function __construct(?array $config = [])
    {
        $this->guzzle = new Client($config);
    }

    /**
     * @inheritdoc
     */
    public function handleRequest(string $method, ?string $uri = '', ?array $options = [], ?array $parameters = [], ?bool $returnAssoc = false): object
    {
        if (!empty($parameters)) {
            if ($method == 'GET') {
                // Send parameters as query string parameters.
                $options['query'] = $parameters;
            } else {
                // Send parameters as JSON in request body.
                $options['json'] = (object)$parameters;
            }
        }

        try {
            $response = $this->guzzle->request($method, $uri, $options);

            return json_decode($response->getBody(), $returnAssoc);
        } catch (RequestException $e) {
            $response = $e->getResponse();
            if (!empty($response)) {
                $message = $e->getResponse()->getBody();
            } else {
                $message = $e->getMessage();
            }

            throw new Exception($message, $e->getCode(), $e);
        }
    }
}
