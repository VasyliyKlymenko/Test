<?php

namespace App\Http\Client;

use Exception;

/**
 * Interface for all HTTP clients
 * @package App\Http\Client
 */
interface HttpClientInterface
{
    /**
     * Makes a request to the API
     *
     * @param string $method
     *   The REST method to use when making the request
     * @param string|null $uri
     *   The API URI to request.
     * @param array|null $options
     *   Request options.
     * @param array|null $parameters
     *   Associative array of parameters to send in the request body
     * @param bool|null $returnAssoc
     *   TRUE to return API response as an associative array
     *
     * @return object
     *
     * @throws Exception
     */
    public function handleRequest(string $method, ?string $uri = '', ?array $options = [], ?array $parameters = [], ?bool $returnAssoc = false);

}
