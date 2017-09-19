<?php

namespace Ekyna\Component\GlsUniBox\Api;

use Ekyna\Component\GlsUniBox\Exception\InvalidArgumentException;

/**
 * Class Product
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
abstract class Product
{
    /**
     * Business Parcel
     */
    const BP  = 'BP';  // Business Parcel

    /**
     * Euro Business Parcel
     */
    const EBP = 'EBP';

    /**
     * Global Business Parcel
     */
    const GBP = 'GBP';

    /**
     * Express Parcel Guaranteed
     */
    const EP  = 'EP';

    /**
     * Shop Delivery Service
     */
    const SHD = 'SHD';

    /**
     * Flex Delivery Service
     */
    const FDF = 'FDF';


    /**
     * Returns the available product codes.
     *
     * @return array|string[]
     */
    static public function getCodes()
    {
        return [
            static::BP,
            static::EBP,
            static::GBP,
            static::EP,
            static::SHD,
            static::FDF,
        ];
    }

    /**
     * Returns whether or not the given code is valid.
     *
     * @param string $code
     * @param bool   $throw
     *
     * @return bool
     */
    static public function isValid($code, $throw = true)
    {
        if (in_array($code, static::getCodes())) {
            return true;
        }

        if ($throw) {
            throw new InvalidArgumentException("Unexpected product code.");
        }

        return false;
    }

    /**
     * Returns the label for the given product code.
     *
     * @param string $code
     *
     * @return string
     */
    static public function getLabel($code)
    {
        static::isValid($code);

        switch ($code) {
            case static::EBP :
                return 'Euro Business Parcel';
            case static::GBP :
                return 'Global Business Parcel';
            case static::EP :
                return 'Express Parcel Guaranteed';
            case static::SHD :
                return 'Shop Delivery Service';
            case static::FDF :
                return 'Flex Delivery Service';
            case static::BP :
            default:
                return 'Business Parcel';
        }
    }

    /**
     * Returns the numerical equivalent product code.
     *
     * @param string $code
     *
     * @return string
     */
    static function getNumerical($code)
    {
        static::isValid($code);

        switch ($code) {
            case static::EBP :
                return '01';
            case static::GBP :
                return '01';
            case static::EP :
                return '16';
            case static::SHD :
                return '17';
            case static::FDF :
                return '18';
            case static::BP :
            default:
                return '02';
        }
    }

    /**
     * Returns the "UNI Ship" equivalent product code.
     *
     * @param string $code
     *
     * @return string
     */
    static function getUniShip($code)
    {
        static::isValid($code);

        switch ($code) {
            case static::EBP :
                return 'CC';
            case static::GBP :
                return 'FF';
            case static::EP :
            case static::SHD :
            case static::FDF :
                return null;
            case static::BP :
            default:
                return 'AA';
        }
    }
}
