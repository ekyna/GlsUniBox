<?php

declare(strict_types=1);

namespace Ekyna\Component\GlsUniBox\Api;

use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * Class Client
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Client
{
    public const URL_PROD        = 'www.gls-france.com/cgi-bin/glsboxGI.cgi';
    public const URL_CONSIGNMENT = 'www.gls-france.com/cgi-bin/glsboxGIWA.cgi';
    public const URL_TEST        = 'www.gls-france.com/cgi-bin/glsboxGITest.cgi';

    public const MODE_PROD        = 'prod';
    public const MODE_CONSIGNMENT = 'consignment';
    public const MODE_TEST        = 'test';

    private array  $config;
    private string $mode;
    private bool   $secured;

    private ?ClientInterface         $httpClient     = null;
    private ?RequestFactoryInterface $requestFactory = null;
    private ?StreamFactoryInterface  $streamFactory  = null;

    public function __construct(array $config, string $mode = self::MODE_PROD, bool $secured = true)
    {
        Config::validateClientConfig($config);

        $this->config = $config;
        $this->mode = $mode;
        $this->secured = $secured;
    }

    public function getHttpClient(): ClientInterface
    {
        if ($this->httpClient) {
            return $this->httpClient;
        }

        return $this->httpClient = HttpClientDiscovery::find();
    }

    public function setHttpClient(ClientInterface $httpClient): Client
    {
        $this->httpClient = $httpClient;

        return $this;
    }

    public function getRequestFactory(): RequestFactoryInterface
    {
        if ($this->requestFactory) {
            return $this->requestFactory;
        }

        return $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
    }

    public function setRequestFactory(RequestFactoryInterface $requestFactory): Client
    {
        $this->requestFactory = $requestFactory;

        return $this;
    }

    public function getStreamFactory(): StreamFactoryInterface
    {
        if ($this->streamFactory) {
            return $this->streamFactory;
        }

        return $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
    }

    public function setStreamFactory(StreamFactoryInterface $streamFactory): Client
    {
        $this->streamFactory = $streamFactory;

        return $this;
    }

    /**
     * Sends the request.
     */
    public function send(Request $request): Response
    {
        $request->configure($this->config);

        $body = $this
            ->getStreamFactory()
            ->createStream($request->build());

        $httpRequest = $this
            ->getRequestFactory()
            ->createRequest('POST', $this->getUrl())
            ->withBody($body);

        $httpResponse = $this
            ->getHttpClient()
            ->sendRequest($httpRequest);

        return Response::create($httpResponse->getBody()->getContents());
    }

    /**
     * Returns the endpoint url.
     */
    private function getUrl(): string
    {
        if ($this->mode === static::MODE_PROD) {
            $url = static::URL_PROD;
        } elseif ($this->mode === static::MODE_CONSIGNMENT) {
            $url = static::URL_CONSIGNMENT;
        } else {
            $url = static::URL_TEST;
        }

        return 'http' . ($this->secured ? 's' : '') . '://' . $url;
    }
}
