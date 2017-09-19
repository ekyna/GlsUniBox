<?php

namespace Ekyna\Component\GlsUniBox\Api;

/**
 * Class Client
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Client
{
    const URL_PROD        = 'www.gls-france.com/cgi-bin/glsboxGI.cgi';
    const URL_CONSIGNMENT = 'www.gls-france.com/cgi-bin/glsboxGIWA.cgi';
    const URL_TEST        = 'www.gls-france.com/cgi-bin/glsboxGITest.cgi';

    const MODE_PROD        = 'prod';
    const MODE_CONSIGNMENT = 'consignment';
    const MODE_TEST        = 'test';


    /**
     * @var array
     */
    private $config;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var string
     */
    private $secured;

    /**
     * @var string
     */
    private $debug;


    /**
     * Constructor.
     *
     * @param array $config
     * @param string $mode
     * @param bool   $secured
     * @param bool   $debug
     */
    public function __construct(array $config, $mode = self::MODE_TEST, $secured = true, $debug = false)
    {
        Config::validateClientConfig($config);

        $this->config = $config;
        $this->mode = $mode;
        $this->secured = $secured;
        $this->debug = $debug;
    }

    /**
     * Sends the request.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function send(Request $request)
    {
        $request->configure($this->config);

        $httpClient = new \GuzzleHttp\Client();

        $r = $httpClient->request('POST', $this->getUrl(), [
            'body' => \GuzzleHttp\Psr7\stream_for((string) $request),
        ]);

        return Response::create($r->getBody()->getContents());
    }

    /**
     * Returns the endpoint url.
     *
     * @return string
     */
    private function getUrl()
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
