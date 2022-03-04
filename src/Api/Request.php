<?php

declare(strict_types=1);

namespace Ekyna\Component\GlsUniBox\Api;

use DateTimeInterface;
use Ekyna\Component\GlsUniBox\Exception\InvalidArgumentException;

use function implode;

/**
 * Class Request
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Request extends AbstractData
{
    private int $number;
    private string $service;

    public function __construct(int $number, string $service = Service::BP)
    {
        $this->number = $number;
        $this->setService($service);

        $this->set(Config::T8973, '1');
        $this->set(Config::T8904, '1');
        $this->set(Config::T8702, '1');
        $this->set(Config::T8905, '1');
    }

    /**
     * @return string
     *
     * @deprecated Use the build() method.
     */
    public function __toString()
    {
        return $this->build();
    }

    public function build(): string
    {
        $parts = [static::START_TOKEN];

        $data = $this->getData();

        foreach ($this->getData() as $key => $value) {
            $parts[] = $key . ':' . $value;
        }

        if (!isset($data[Config::T8975]) || empty($data[Config::T8975])) {
            $parts[] = Config::T8975 . ':' . $this->buildOriginReference();
        }

        if ($this->get(Config::T100) === 'FR') {
            $parts[] = Config::T082 . ':UNIQUENO';
        }

        $parts[] = Config::T090 . ':NOSAVE';

        $parts[] = static::END_TOKEN;

        return implode('|', $parts);
    }

    /**
     * Builds the GLS origin reference (T8975)
     */
    private function buildOriginReference(): string
    {
        /* - Code produit (2 positions numériques) : voir annexe 12.2
         * - Numéro de colis (10 positions numériques) : ce numéro doit être unique. Vous le composez à votre
         *   guise suivant la logique qui vous convient (chrono, numéro commande…) Il pourra également vous
         *   servir pour le suivi colis
         * - Constante : 0000
         * - Pays de destination (2 positions alpha.) : idem T100
         *
         * Exemple : T8975:0200000000800000FR */

        return Service::getNumerical($this->service) .
            str_pad((string)$this->number, 10, '0', STR_PAD_LEFT) .
            '0000' .
            $this->get(Config::T100);
    }

    /**
     * Sets the shipment date (T540).
     */
    public function setDate(DateTimeInterface $dateTime): Request
    {
        $this->set(Config::T540, $dateTime->format('Ymd'));

        return $this;
    }

    /**
     * Sets the weight (xx.xx kg) (T530).
     */
    public function setWeight(string $weight): Request
    {
        if ($weight < 0.1) {
            throw new InvalidArgumentException('Expected weight greater than 100g.');
        }

        $this->set(Config::T530, $weight);

        return $this;
    }

    /**
     * Sets the service (T200).
     */
    public function setService(string $service): Request
    {
        Service::isValid($service);

        $this->service = $service;

        if ($service === Service::EP) {
            $this->set(Config::T200, 'T13');
            $this->set(Config::T206, $service);
        } elseif ($service === Service::SHD || $service === Service::FDF) {
            $this->set(Config::T200, $service);
            $this->set(Config::T750, Service::getLabel($service));
        }

        return $this;
    }

    /**
     * Sets the receiver company name (T860).
     */
    public function setReceiverCompany(string $name): Request
    {
        $this->set(Config::T860, $name);

        return $this;
    }

    /**
     * Sets the receiver street (T863).
     */
    public function setReceiverStreet(string $street): Request
    {
        $this->set(Config::T863, $street);

        return $this;
    }

    /**
     * Sets the first receiver street supplement (T861).
     */
    public function setReceiverSupplement1(string $supplement): Request
    {
        $this->set(Config::T861, $supplement);

        return $this;
    }

    /**
     * Sets the first receiver street supplement (T862).
     */
    public function setReceiverSupplement2(string $supplement): Request
    {
        $this->set(Config::T862, $supplement);

        return $this;
    }

    /**
     * Sets the first receiver street supplement (T330).
     */
    public function setReceiverPostalCode(string $postalCode): Request
    {
        $this->set(Config::T330, $postalCode);

        return $this;
    }

    /**
     * Sets the receiver city (T864).
     */
    public function setReceiverCity(string $city): Request
    {
        $this->set(Config::T864, $city);

        return $this;
    }

    /**
     * Sets the receiver country code (T100).
     */
    public function setReceiverCountry(string $code): Request
    {
        $this->set(Config::T100, strtoupper($code));

        return $this;
    }

    /**
     * Sets the receiver comment (T8906).
     */
    public function setReceiverComment(string $comment): Request
    {
        $this->set(Config::T8906, $comment);

        return $this;
    }

    /**
     * Sets the receiver phone number (T871).
     */
    public function setReceiverPhone(string $number): Request
    {
        $this->set(Config::T871, $number);

        return $this;
    }

    /**
     * Sets the receiver mobile phone number (T1230).
     */
    public function setReceiverMobile(string $number): Request
    {
        $this->set(Config::T1230, $number);

        return $this;
    }

    /**
     * Sets the receiver email (T1229).
     */
    public function setReceiverEmail(string $number): Request
    {
        $this->set(Config::T1229, $number);

        return $this;
    }

    /**
     * Sets the receiver reference (T859).
     */
    public function setReceiverReference(string $reference): Request
    {
        $this->set(Config::T859, $reference);

        return $this;
    }

    /**
     * Sets the secondary receiver reference (T854).
     */
    public function setReceiverReference2(string $reference): Request
    {
        $this->set(Config::T854, $reference);

        return $this;
    }

    /**
     * Sets the tertiary receiver reference (T8908).
     */
    public function setReceiverReference3(string $reference): Request
    {
        $this->set(Config::T8908, $reference);

        return $this;
    }

    /**
     * Sets the sender company (T810).
     */
    public function setSenderCompany(string $name): Request
    {
        $this->set(Config::T810, $name);

        return $this;
    }

    /**
     * Sets the sender street (T820).
     */
    public function setSenderStreet(string $street): Request
    {
        $this->set(Config::T820, $street);

        return $this;
    }

    /**
     * Sets the sender country code (T821).
     */
    public function setSenderCountry(string $country): Request
    {
        $this->set(Config::T821, strtoupper($country));

        return $this;
    }

    /**
     * Sets the sender postal code (T822).
     */
    public function setSenderPostalCode(string $postalCode): Request
    {
        $this->set(Config::T822, $postalCode);

        return $this;
    }

    /**
     * Sets the sender city (T823).
     */
    public function setSenderCity(string $city): Request
    {
        $this->set(Config::T823, $city);

        return $this;
    }

    /**
     * Sets the GLS shipment deposit (T8700).
     */
    public function setGLSShipmentDeposit(string $deposit): Request
    {
        $this->set(Config::T8700, $deposit);

        return $this;
    }

    /**
     * Sets the customer code (T8915).
     */
    public function setCustomerCode(string $code): Request
    {
        $this->set(Config::T8915, $code);

        return $this;
    }

    /**
     * Sets the contact id (T8914).
     */
    public function setContactId(string $id): Request
    {
        $this->set(Config::T8914, $id);

        return $this;
    }

    /**
     * Sets the parcel number (T8904 & T8973).
     */
    public function setParcelNumber(string $number): Request
    {
        $this->set(Config::T8904, $number);
        $this->set(Config::T8973, $number);

        return $this;
    }

    /**
     * Sets the parcel count (T8905 & T8702).
     */
    public function setParcelCount(string $count): Request
    {
        $this->set(Config::T8905, $count);
        $this->set(Config::T8702, $count);

        return $this;
    }

    /**
     * Sets the origin reference (T8975).
     */
    public function setOriginReference(string $count): Request
    {
        $this->set(Config::T8975, $count);

        return $this;
    }

    /**
     * Configures the request (called by the client).
     *
     * @see Client::send()
     */
    public function configure(array $config): Request
    {
        return $this
            ->setGLSShipmentDeposit($config[Config::T8700])
            ->setCustomerCode($config[Config::T8915])
            ->setContactId($config[Config::T8914])
            ->clean();
    }
}
