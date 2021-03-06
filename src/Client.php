<?php

declare(strict_types=1);

namespace Jmleroux\CircleCi;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;

class Client
{
    /** @var HttpClient */
    private $client;
    /** @var string */
    private $token;

    public function __construct(string $token, ?string $version = 'v1.1')
    {
        $baseUri = sprintf('https://circleci.com/api/%s/', $version);
        $this->client = new HttpClient(['base_uri' => $baseUri]);
        $this->token = $token;
    }

    public function getVersion(): string
    {
        $baseUri = (string)$this->client->getConfig('base_uri');
        preg_match('#circleci.com/api/(v[\d\.]+)/#', $baseUri, $result);

        return $result[1];
    }

    public function get(string $url, array $params = []): ResponseInterface
    {
        $uri = Uri::withQueryValues(new Uri($url), $params);

        return $this->client->get($uri, [
            'headers' => [
                'Accept' => 'application/json',
                'Circle-Token' => $this->token,
            ],
        ]);
    }

    public function post(string $url, array $params = []): ResponseInterface
    {
        $uri = Uri::withQueryValues(new Uri($url), $params);

        return $this->client->post($uri, [
            'headers' => [
                'Accept' => 'application/json',
                'Circle-Token' => $this->token,
            ],
        ]);
    }

    public function delete(string $url, array $params = []): ResponseInterface
    {
        $uri = Uri::withQueryValues(new Uri($url), $params);

        return $this->client->delete($uri, [
            'headers' => [
                'Accept' => 'application/json',
                'Circle-Token' => $this->token,
            ],
        ]);
    }
}
