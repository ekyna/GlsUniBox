<?php

namespace Ekyna\Component\GlsUniBox\Api;

use Ekyna\Component\GlsUniBox\Exception\InvalidArgumentException;

/**
 * Class Response
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Response extends AbstractData
{
    const E_CODE = 'E_CODE';
    const E_FIELD = 'E_FIELD';

    const SUCCESS = 'E000';


    /**
     * Creates a response from the given http response body.
     *
     * @param string $body
     *
     * @return Response
     */
    public static function create($body)
    {
        if (0 !== strpos($body, static::START_TOKEN)) {
            throw new InvalidArgumentException("Unexpected response body.");
        }
        if (static::END_TOKEN !== substr($body, -strlen(static::END_TOKEN))) {
            throw new InvalidArgumentException("Unexpected response body.");
        }

        $body = substr($body, strlen(static::START_TOKEN), -strlen(static::END_TOKEN));

        $parts = explode('|', trim($body, '|'));
        if (empty($parts)) {
            throw new InvalidArgumentException("Unexpected response body.");
        }

        $response = new static();

        for ($i = 0; $i < count($parts); $i++) {
            list($key, $value) = explode(':', $parts[$i], 2);

            if ($key === Config::RESULT) {
                if (0 < strpos($value, ':')) {
                    list($code, $field) = explode(':', $value, 2);
                } else {
                    $code = $value;
                    $field = 'unknown';
                }
                $response->set(Config::RESULT, $code);
                $response->set(Config::FIELD, $field);
            } else {
                $response->set($key, $value);
            }
        }

        return $response;
    }

    /**
     * Returns whether the response is successful.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getErrorCode() === static::SUCCESS;
    }

    /**
     * Returns the error code (RESULT).
     *
     * @return string
     */
    public function getErrorCode()
    {
        return $this->get(Config::RESULT);
    }

    /**
     * Returns the shipment key (T110).
     *
     * @return string
     */
    public function getShipmentKey()
    {
        return $this->get(Config::T110);
    }

    /**
     * Returns the delivery key (T310).
     *
     * @return string
     */
    public function getDeliveryKey()
    {
        return $this->get(Config::T310);
    }

    /**
     * Returns the GLS delivery deposit key (T101).
     *
     * @return string
     */
    public function getGLSDeliveryDeposit()
    {
        return $this->get(Config::T101);
    }

    /**
     * Returns the delivery round number (T320).
     *
     * @return string
     */
    public function getDeliveryRoundNumber()
    {
        return $this->get(Config::T320);
    }

    /**
     * Returns the tracking number (T8913).
     *
     * @return string
     */
    public function getTrackingNumber()
    {
        return $this->get(Config::T8913);
    }

    /**
     * Returns the primary datamatrix (T8902).
     *
     * @return string
     */
    public function getPrimaryDatamatrix()
    {
        return $this->get(Config::T8902);
    }

    /**
     * Returns the secondary datamatrix (T8903).
     *
     * @return string
     */
    public function getSecondaryDatamatrix()
    {
        return $this->get(Config::T8903);
    }
}
