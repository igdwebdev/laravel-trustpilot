<?php
namespace McCaulay\Trustpilot;

use GuzzleHttp\Client;

class Api
{
    /**
     * The Guzzle client.
     *
     * @var GuzzleHttp\Client
     */
    private $client;

    /**
     * The trustpilot configuration.
     *
     * @var array
     */
    private $config;

    /**
     * The api endpoint.
     *
     * @var string
     */
    private $endpoint;

    /**
     * The rest object path.
     *
     * @var string
     */
    private $path;

    /**
     * Initialise the Api
     */
    public function __construct()
    {
        // Initalise the config
        $this->config = config('trustpilot');

        $this->path = '/';
        $this->endpoint = $this->config['endpoints']['default'];

        // Initalise the guzzle client
        $this->client = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'apikey' => $this->config['api']['access_token'],
            ],
        ]);
    }

    /**
     * Dynamically allow static calls of methods.
     *
     * @return self
     */
    public static function __callStatic($name, $arguments)
    {
        $class = get_called_class();
        $instance = new $class();
        return call_user_func_array([$instance, $name], $arguments);
    }

    /**
     * Set the path of the api.
     *
     * @return self
     */
    protected function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Perform a request to the API service.
     *
     * @param string $method
     * @param array $params
     * @return array|object
     */
    protected function request(string $method, string $path, array $query = [], array $params = [])
    {
        $response = $this->client->request($method, $this->endpoint . $this->path . $path, [
            'query' => $query,
            'json' => $params,
        ]);
        $contents = (string) $response->getBody();
        return json_decode($contents);
    }

    /**
     * Perform a GET request to the API service.
     *
     * @param string $path
     * @param array $query
     * @return array|object
     */
    protected function get(string $path, array $query = [])
    {
        return $this->request('GET', $path, $query);
    }

    /**
     * Perform a POST request to the API service.
     *
     * @param string $path
     * @param array $query
     * @param array $params
     * @return array|object
     */
    protected function post(string $path, array $query = [], array $params = [])
    {
        return $this->request('POST', $path, $query, $params);
    }

    /**
     * Perform a PUT request to the API service.
     *
     * @param string $path
     * @param array $query
     * @param array $params
     * @return array|object
     */
    protected function put(string $path, array $query = [], array $params = [])
    {
        return $this->request('PUT', $path, $query, $params);
    }

    /**
     * Perform a DELETE request to the API service.
     *
     * @param string $path
     * @param array $query
     * @param array $params
     * @return array|object
     */
    protected function delete(string $path, array $query = [], array $params = [])
    {
        return $this->request('DELETE', $path, $query, $params);
    }
}
