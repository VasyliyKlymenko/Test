<?php

namespace App\Services;

use App\Components\Config;
use App\Http\Client\HttpClientInterface;
use Exception;

/**
 * Methods for working with ipStack API
 * @package App\Services
 */
class IpStackService implements IpContinentServiceInterface
{
    /**
     * @var HttpClientInterface $httpClient
     */
    private HttpClientInterface $httpClient;

    /**
     * Request parameters
     * @var array
     */
    private array $requestParameters;

    /**
     * IpStackService constructor.
     * @param HttpClientInterface $httpClient
     * @param array|null $requestParameters // additional request parameters
     * @throws Exception
     */
    public function __construct(HttpClientInterface $httpClient, ?array $requestParameters = [])
    {
        $this->httpClient = $httpClient;

        $this->setBaseRequestParameters($requestParameters);
    }

    /**
     * @inheritdoc
     */
    public function getContinentCode(string $ip): ?string
    {
        try {
            $requestParameters = [
                'fields' => 'continent_code'
            ];

            return $this->handleRequest($ip, $requestParameters)->continent_code;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param array|null $requestParameters
     * @throws Exception
     */
    private function setBaseRequestParameters(?array $requestParameters = []): void
    {
        $apiAccessKey = Config::get('IPSTACK_ACCESS_KEY');

        if (!$apiAccessKey) {
            throw new Exception('The ipstack access key must be specified in config.');
        }

        $this->requestParameters = array_merge([
            'access_key' => $apiAccessKey,
        ], $requestParameters);
    }

    /**
     * Makes a request to the ipStack API
     * @param string $ip
     * @param array|null $requestParameters
     * @return object // API response
     * @throws Exception
     */
    private function handleRequest(string $ip, ?array $requestParameters = []): object
    {
        return $this->httpClient->handleRequest('GET', 'http://api.ipstack.com/' . $ip, null, array_merge($this->requestParameters, $requestParameters));
    }
}