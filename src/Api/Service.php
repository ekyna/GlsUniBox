<?php /** @noinspection PhpConstantNamingConventionInspection */

declare(strict_types=1);

namespace Ekyna\Component\GlsUniBox\Api;

use Ekyna\Component\GlsUniBox\Exception\InvalidArgumentException;

/**
 * Class Service
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
abstract class Service
{
    /**
     * Business Parcel
     */
    public const BP = 'BP';  // Business Parcel

    /**
     * Euro Business Parcel
     */
    public const EBP = 'EBP';

    /**
     * Global Business Parcel
     */
    public const GBP = 'GBP';

    /**
     * Express Parcel Guaranteed
     */
    public const EP = 'EP';

    /**
     * Shop Delivery Service
     */
    public const SHD = 'SHD';

    /**
     * Flex Delivery Service
     */
    public const FDF = 'FDF';


    /**
     * Returns the available product codes.
     *
     * @return array<string>
     */
    public static function getCodes(): array
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
     * Returns whether the given code is valid.
     *
     * @param string $code
     * @param bool   $throw
     *
     * @return bool
     */
    public static function isValid(string $code, bool $throw = true): bool
    {
        if (in_array($code, static::getCodes())) {
            return true;
        }

        if ($throw) {
            throw new InvalidArgumentException('Unexpected product code.');
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
    public static function getLabel(string $code): string
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
     * Returns the choices.
     *
     * @return array<string, string>
     */
    public static function getChoices(): array
    {
        $choices = [];

        foreach (static::getCodes() as $code) {
            $choices[static::getLabel($code)] = $code;
        }

        return $choices;
    }

    /**
     * Returns the numerical equivalent product code.
     */
    public static function getNumerical(string $code): string
    {
        static::isValid($code);

        switch ($code) {
            case static::EBP :
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
     */
    public static function getUniShip(string $code): ?string
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
