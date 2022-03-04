<?php

declare(strict_types=1);

namespace Ekyna\Component\GlsUniBox\Api;

use Ekyna\Component\GlsUniBox\Exception\InvalidArgumentException;

/**
 * Class Response
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Response extends AbstractData
{
    public const SUCCESS = 'E000';

    /**
     * Creates a response from the given http response body.
     *
     * @param string $body
     *
     * @return Response
     */
    public static function create(string $body): Response
    {
        if (0 !== strpos($body, static::START_TOKEN)) {
            throw new InvalidArgumentException('Unexpected response body.');
        }

        if (static::END_TOKEN !== substr($body, -strlen(static::END_TOKEN))) {
            throw new InvalidArgumentException('Unexpected response body.');
        }

        $body = substr($body, strlen(static::START_TOKEN), -strlen(static::END_TOKEN));

        $parts = explode('|', trim($body, '|'));
        if (empty($parts)) {
            throw new InvalidArgumentException('Unexpected response body.');
        }

        $response = new static();

        for ($i = 0; $i < count($parts); $i++) {
            [$key, $value] = explode(':', $parts[$i], 2);

            if ($key === Config::RESULT) {
                if (0 < strpos($value, ':')) {
                    [$code, $field] = explode(':', $value, 2);
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
     */
    public function isSuccessful(): bool
    {
        return $this->getErrorCode() === static::SUCCESS;
    }

    /**
     * Returns the error code (RESULT).
     */
    public function getErrorCode(): string
    {
        return $this->get(Config::RESULT);
    }

    /**
     * Returns the shipment key (T110).
     */
    public function getShipmentKey(): string
    {
        return $this->get(Config::T110);
    }

    /**
     * Returns the delivery key (T310).
     */
    public function getDeliveryKey(): string
    {
        return $this->get(Config::T310);
    }

    /**
     * Returns the GLS delivery deposit key (T101).
     */
    public function getGLSDeliveryDeposit(): string
    {
        return $this->get(Config::T101);
    }

    /**
     * Returns the delivery round number (T320).
     */
    public function getDeliveryRoundNumber(): string
    {
        return $this->get(Config::T320);
    }

    /**
     * Returns the tracking number (T8913).
     */
    public function getTrackingNumber(): string
    {
        return $this->get(Config::T8913);
    }

    /**
     * Returns the primary datamatrix (T8902).
     */
    public function getPrimaryDatamatrix(): string
    {
        return $this->get(Config::T8902);
    }

    /**
     * Returns the secondary datamatrix (T8903).
     */
    public function getSecondaryDatamatrix(): string
    {
        return $this->get(Config::T8903);
    }
}
