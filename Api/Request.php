<?php

namespace Ekyna\Component\GlsUniBox\Api;

/**
 * Class Request
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Request extends AbstractData
{
    /**
     * @var string
     */
    private $service;


    /**
     * Constructor.
     *
     * @param string $service
     */
    public function __construct($service = Service::BP)
    {
        $this->setService($service);

        $this->set(Config::T8973, 1);
        $this->set(Config::T8904, 1);
        $this->set(Config::T8702, 1);
        $this->set(Config::T8905, 1);
    }

    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        $parts = [static::START_TOKEN];

        foreach ($this->getData() as $key => $value) {
            $parts[] = $key . ':' . $value;
        }

        if (!isset($parts[Config::T8975])) {
            $parts[Config::T8975] = $this->buildOriginReference();
        }

        if ($this->get(Config::T100) === 'FR') {
            $parts[Config::T082] = 'UNIQUENO';
        }

        $parts[Config::T090] = 'NOSAVE';

        $parts[] = static::END_TOKEN;

        return implode('|', $parts);
    }

    /**
     * Builds the GLS origin reference (T8975)
     *
     * @return string
     */
    private function buildOriginReference()
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
             str_pad($this->get(Config::T859), 10, '0', STR_PAD_LEFT) .
             '0000' .
             $this->get(Config::T100);
    }

    /**
     * Sets the shipment date (T540).
     *
     * @param \DateTime $dateTime
     *
     * @return $this
     */
    public function setDate(\DateTime $dateTime)
    {
        $this->set(Config::T540, $dateTime->format('Ymd'));

        return $this;
    }

    /**
     * Sets the weight (xx.xx kg) (T530).
     *
     * @param float $weight
     *
     * @return $this
     */
    public function setWeight($weight)
    {
        $this->set(Config::T530, (string) round($weight, 2));

        return $this;
    }

    /**
     * Sets the service (T200).
     *
     * @param string $service
     *
     * @return $this
     */
    public function setService($service)
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
     *
     * @param string $name
     *
     * @return $this
     */
    public function setReceiverCompany($name)
    {
        $this->set(Config::T860, (string) $name);

        return $this;
    }

    /**
     * Sets the receiver street (T863).
     *
     * @param string $street
     *
     * @return $this
     */
    public function setReceiverStreet($street)
    {
        $this->set(Config::T863, (string) $street);

        return $this;
    }

    /**
     * Sets the first receiver street supplement (T861).
     *
     * @param string $supplement
     *
     * @return $this
     */
    public function setReceiverSupplement1($supplement)
    {
        $this->set(Config::T861, (string) $supplement);

        return $this;
    }

    /**
     * Sets the first receiver street supplement (T862).
     *
     * @param string $supplement
     *
     * @return $this
     */
    public function setReceiverSupplement2($supplement)
    {
        $this->set(Config::T862, (string) $supplement);

        return $this;
    }

    /**
     * Sets the first receiver street supplement (T330).
     *
     * @param string $postalCode
     *
     * @return $this
     */
    public function setReceiverPostalCode($postalCode)
    {
        $this->set(Config::T330, (string) $postalCode);

        return $this;
    }

    /**
     * Sets the receiver city (T864).
     *
     * @param string $city
     *
     * @return $this
     */
    public function setReceiverCity($city)
    {
        $this->set(Config::T864, (string) $city);

        return $this;
    }

    /**
     * Sets the receiver country code (T100).
     *
     * @param string $code
     *
     * @return $this
     */
    public function setReceiverCountry($code)
    {
        $this->set(Config::T100, strtoupper($code));

        return $this;
    }

    /**
     * Sets the receiver comment (T8906).
     *
     * @param string $comment
     *
     * @return $this
     */
    public function setReceiverComment($comment)
    {
        $this->set(Config::T8906, (string) $comment);

        return $this;
    }

    /**
     * Sets the receiver phone number (T871).
     *
     * @param string $number
     *
     * @return $this
     */
    public function setReceiverPhone($number)
    {
        $this->set(Config::T871, (string) $number);

        return $this;
    }

    /**
     * Sets the receiver mobile phone number (T1230).
     *
     * @param string $number
     *
     * @return $this
     */
    public function setReceiverMobile($number)
    {
        $this->set(Config::T1230, (string) $number);

        return $this;
    }

    /**
     * Sets the receiver email (T1229).
     *
     * @param string $number
     *
     * @return $this
     */
    public function setReceiverEmail($number)
    {
        $this->set(Config::T1229, (string) $number);

        return $this;
    }

    /**
     * Sets the receiver reference (T859).
     *
     * @param string $reference
     *
     * @return $this
     */
    public function setReceiverReference($reference)
    {
        $this->set(Config::T859, (string) $reference);

        return $this;
    }

    /**
     * Sets the secondary receiver reference (T854).
     *
     * @param string $reference
     *
     * @return $this
     */
    public function setReceiverReference2($reference)
    {
        $this->set(Config::T854, (string) $reference);

        return $this;
    }

    /**
     * Sets the tertiary receiver reference (T8908).
     *
     * @param string $reference
     *
     * @return $this
     */
    public function setReceiverReference3($reference)
    {
        $this->set(Config::T8908, (string) $reference);

        return $this;
    }

    /**
     * Sets the sender company (T810).
     *
     * @param string $name
     *
     * @return $this
     */
    public function setSenderCompany($name)
    {
        $this->set(Config::T810, (string) $name);

        return $this;
    }

    /**
     * Sets the sender street (T820).
     *
     * @param string $street
     *
     * @return $this
     */
    public function setSenderStreet($street)
    {
        $this->set(Config::T820, (string) $street);

        return $this;
    }

    /**
     * Sets the sender country code (T821).
     *
     * @param string $country
     *
     * @return $this
     */
    public function setSenderCountry($country)
    {
        $this->set(Config::T821, strtoupper($country));

        return $this;
    }

    /**
     * Sets the sender postal code (T822).
     *
     * @param string $postalCode
     *
     * @return $this
     */
    public function setSenderPostalCode($postalCode)
    {
        $this->set(Config::T822, (string) $postalCode);

        return $this;
    }

    /**
     * Sets the sender city (T823).
     *
     * @param string $city
     *
     * @return $this
     */
    public function setSenderCity($city)
    {
        $this->set(Config::T823, (string) $city);

        return $this;
    }

    /**
     * Sets the GLS shipment deposit (T8700).
     *
     * @param string $deposit
     *
     * @return $this
     */
    public function setGLSShipmentDeposit($deposit)
    {
        $this->set(Config::T8700, (string) $deposit);

        return $this;
    }

    /**
     * Sets the customer code (T8915).
     *
     * @param string $code
     *
     * @return $this
     */
    public function setCustomerCode($code)
    {
        $this->set(Config::T8915, (string) $code);

        return $this;
    }

    /**
     * Sets the contact id (T8914).
     *
     * @param string $id
     *
     * @return $this
     */
    public function setContactId($id)
    {
        $this->set(Config::T8914, (string) $id);

        return $this;
    }

    /**
     * Sets the parcel number (T8904 & T8973).
     *
     * @param string $number
     *
     * @return $this
     */
    public function setParcelNumber($number)
    {
        $this->set(Config::T8904, (string) $number);
        $this->set(Config::T8973, (string) $number);

        return $this;
    }

    /**
     * Sets the parcel count (T8905 & T8702).
     *
     * @param string $count
     *
     * @return $this
     */
    public function setParcelCount($count)
    {
        $this->set(Config::T8905, (string) $count);
        $this->set(Config::T8702, (string) $count);

        return $this;
    }

    /**
     * Sets the origin reference (T8975).
     *
     * @param string $count
     *
     * @return $this
     */
    public function setOriginReference($count)
    {
        $this->set(Config::T8975, (string) $count);

        return $this;
    }

    /**
     * Configures the request (called by the client).
     *
     * @param array $config
     *
     * @return $this
     *
     * @see Client::send()
     */
    public function configure(array $config)
    {
        return $this
            ->setGLSShipmentDeposit($config[Config::T8700])
            ->setCustomerCode($config[Config::T8915])
            ->setContactId($config[Config::T8914])
            ->clean();
    }
}
