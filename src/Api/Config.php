<?php

declare(strict_types=1);

namespace Ekyna\Component\GlsUniBox\Api;
use Ekyna\Component\GlsUniBox\Exception\InvalidArgumentException;

/**
 * Class Config
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Config
{
    /* ------------------------------ REQUEST ------------------------------ */

    /**
     * Date expédition format AAAAMMJJ (max. 8) [mandatory]
     */
    public const T540 = 'T540';

    /**
     * Heure expédition format HHII (max. 8) [mandatory]
     */
    public const T541 = 'T541';

    /**
     * Poids format xx.xx (max. 5) [mandatory]
     */
    public const T530 = 'T530';

    /**
     * Raison sociale destinataire (max. 35) [mandatory]
     */
    public const T860 = 'T860';

    /**
     * Rue destinataire (max. 35) [mandatory]
     */
    public const T863 = 'T863';

    /**
     * Complément 1 adresse destinataire (max. 35)
     */
    public const T861 = 'T861';

    /**
     * Complément 2 adresse destinataire (max. 35)
     */
    public const T862 = 'T862';

    /**
     * Code postal destinataire (max. 10) [mandatory]
     */
    public const T330 = 'T330';

    /**
     * Ville Destinataire (max. 35) [mandatory]
     */
    public const T864 = 'T864';

    /**
     * Pays Destinataire Euro express (max. 2) [mandatory]
     */
    public const T100 = 'T100';

    /**
     * Pays Destinataire Business express (max. 2) [mandatory]
     */
    public const T105 = 'T105';

    /**
     * Commentaires (max. 35)
     */
    public const T8906 = 'T8906';

    /**
     * Téléphone Destinataire (max. 20)
     */
    public const T871 = 'T871';

    /**
     * Portable (max. 20)
     */
    public const T1230 = 'T1230';

    /**
     * Email destinataire (max. 100)
     */
    public const T1229 = 'T1229';

    /**
     * Votre référence destinataire (max. 20)
     */
    public const T859 = 'T859';

    /**
     * Référence supplémentaire 1 (max. 20)
     */
    public const T854 = 'T854';

    /**
     * Référence supplémentaire 2 (max. 20)
     */
    public const T8908 = 'T8908';

    /**
     * Raison sociale Expéditeur (max. 35) [mandatory]
     */
    public const T810 = 'T810';

    /**
     * Adresse expéditeur (max. 35) [mandatory]
     */
    public const T820 = 'T820';

    /**
     * Pays Expéditeur (max. 2) [mandatory]
     */
    public const T821 = 'T821';

    /**
     * Code postal Expéditeur (max. 10) [mandatory]
     */
    public const T822 = 'T822';

    /**
     * Ville Expéditeur (max. 35) [mandatory]
     */
    public const T823 = 'T823';

    /**
     * Dépôt GLS Expéditeur (max. 6) [mandatory]
     */
    public const T8700 = 'T8700';

    /**
     * Code client GLS (max. 10) [mandatory]
     */
    public const T8915 = 'T8915';

    /**
     * Contact Id (compte sur lequel va être affecté le colis) (max. 10) [mandatory]
     */
    public const T8914 = 'T8914';

    /**
     * Quantième colis dans Expédition (présent sur l’étiquette physiquement) (max. 3) [mandatory]
     */
    public const T8904 = 'T8904';

    /**
     * Quantième colis dans Expédition (présent dans le code barre datamatrix) (max. 3) [mandatory]
     */
    public const T8973 = 'T8973';

    /**
     * Nombre total colis Expédition (présent sur l’étiquette physiquement) (max. 3) [mandatory]
     */
    public const T8905 = 'T8905';

    /**
     * Nombre total colis Expédition (présent dans le code barre datamatrix) (max. 3) [mandatory]
     */
    public const T8702 = 'T8702';

    /**
     * Référence Origine GLS [mandatory]
     */
    public const T8975 = 'T8975';

    /**
     * Constante : UNIQUENO Transmettre cette valeur que si le destinataire est en France [mandatory]
     */
    public const T082 = 'T082';

    /**
     * Constante : NOSAVE  [mandatory]
     */
    public const T090 = 'T090';

    /**
     * Code service (ex: "SHD") (max. 3) [mandatory]
     */
    public const T200 = 'T200';

    /**
     * Libellé service (ex: "ShopDelivery-Service") [mandatory]
     */
    public const T750 = 'T750';

    /**
     * Destinataire 1
     */
    public const T751 = 'T751';

    /**
     * Destinataire 2
     */
    public const T752 = 'T752';

    /**
     * Identifiant Point relais (max. 10) [mandatory]
     */
    public const T8237 = 'T8237';

    /**
     * Produit Express Parcel Guaranteed ("EP") [mandatory]
     */
    public const T206 = 'T206';

    /* ------------------------------ RESPONSE ------------------------------ */

    /**
     * Clé de tri en Expédition/Transit (max. 3)
     */
    public const T110 = 'T110';

    /**
     * Clé de tri en réception (max. 1)
     */
    public const T310 = 'T310';

    /**
     * Dépôt GLS de livraison (max. 4)
     */
    public const T101 = 'T101';

    /**
     * Tournée de livraison (max. 4)
     */
    public const T320 = 'T320';

    /**
     * Dépôts GLS expédition (max. 4)
     */
    public const T500 = 'T500';

    /**
     * GLS TrackId (max. 8)
     */
    public const T8913 = 'T8913';

    /**
     * Datamatrix Principal (max. 123)
     */
    public const T8902 = 'T8902';

    /**
     * Datamatrix secondaire (max. 106)
     */
    public const T8903 = 'T8903';

    /**
     * "Your GLS track ID"
     */
    public const T8951 = 'T8951';

    /**
     * "ZipCode"
     */
    public const T8952 = 'T8952';

    /**
     * Resultat (code erreur)
     */
    public const RESULT = 'RESULT';

    /**
     * Champ erreur
     */
    public const FIELD = 'FIELD';


    /**
     * Returns the request configuration for the given product code.
     */
    public static function getRequestConfig(string $code = Service::BP): array
    {
        Service::isValid($code);

        $config = [
            static::T540  => ['Date expédition format AAAAMMJJ', true, 8],
            static::T530  => ['Poids format xx.xx', true, 5],
            static::T860  => ['Raison sociale destinataire', true, 35],
            static::T863  => ['Rue destinataire', true, 35],
            static::T861  => ['Complément 1 adresse destinataire', false, 35],
            static::T862  => ['Complément 2 adresse destinataire', false, 35],
            static::T330  => ['Code postal destinataire', true, 10],
            static::T864  => ['Ville Destinataire', true, 35],
            static::T100  => ['Pays Destinataire', true, 2],
            static::T8906 => ['Commentaires', false, 35],
            static::T871  => ['Téléphone Destinataire', false, 20],
            static::T859  => ['Votre référence destinataire', false, 20],
            static::T854  => ['Référence supplémentaire 1', false, 20],
            static::T8908 => ['Référence supplémentaire 2', false, 20],
            static::T1229 => ['Email destinataire', false, 100],
            static::T1230 => ['Portable', false, 20],
            static::T810  => ['Raison sociale Expéditeur', true, 35],
            static::T820  => ['Adresse expéditeur', true, 35],
            static::T821  => ['Pays Expéditeur', true, 2],
            static::T822  => ['Code postal Expéditeur', true, 10],
            static::T823  => ['Ville Expéditeur', true, 35],
            static::T8700 => ['Dépôt GLS Expéditeur', true, 6],
            static::T8915 => ['Code client GLS', true, 10],
            static::T8914 => ['Contact Id (compte sur lequel va être affecté le colis)', true, 10],
            static::T8904 => ['Quantième colis dans Expédition (présent sur l’étiquette physiquement)', true, 3],
            static::T8973 => ['Quantième colis dans Expédition (présent dans le code barre datamatrix)', true, 3],
            static::T8905 => ['Nombre total colis Expédition (présent sur l’étiquette physiquement)', true, 3],
            static::T8702 => ['Nombre total colis Expédition (présent dans le code barre datamatrix)', true, 3],
            static::T8975 => ['Référence Origine GLS', true, 1024],
            static::T082  => ['Constante : UNIQUENO Transmettre cette valeur que si le destinataire est en France', true, 1042],
            static::T090  => ['Constante : NOSAVE ', true, 1042],
        ];

        // Spécificités livraisons Shop Delivery Service
        if ($code === Service::EBP) {
            return array_replace($config, [
                static::T200  => ['Service Shod Delivery ("SHD")', true, 3],
                static::T750  => ['Libellé service ("ShopDelivery-Service")', true, 1024],
                static::T1229 => ['Adresse Email Destinataire', true, 100],
                static::T1230 => ['Tél mobile Destinataire', true, 20],
                static::T8237 => ['Identifiant Point relais', true, 10],
                static::T8904 => ['Quantième colis dans Expédition ("1")', true, 3],
                static::T8973 => ['Quantième colis dans Expédition ("1")', true, 3],
                static::T8905 => ['Nombre total colis Expédition ("1")', true, 3],
                static::T8702 => ['Nombre total colis Expédition ("1")', true, 3],
            ]);
        }

        // Spécificités livraison Express Parcel Guaranteed
        if ($code === Service::EP) {
            return array_replace($config, [
                static::T200  => ['13:00 service ("T13")', true, 3],
                static::T206  => ['Produit Express Parcel Guaranteed ("EP")', true, 1024],
                static::T8904 => ['Quantième colis dans Expédition ("1")', true, 3],
                static::T8973 => ['Quantième colis dans Expédition ("1")', true, 3],
                static::T8905 => ['Nombre total colis Expédition ("1")', true, 3],
                static::T8702 => ['Nombre total colis Expédition ("1")', true, 3],
            ]);
        }

        // Spécificités livraison Flex Delivery Service
        if ($code === Service::FDF) {
            return array_replace($config, [
                static::T200  => ['Service Flex Delivery Service ("FDF")', true, 3],
                static::T750  => ['Libellé service  ("Flex Delivery Service")', true, 1024],
                static::T1229 => ['Adresse Email Destinataire', true, 100],
                static::T1230 => ['Tél mobile Destinataire', true, 20],
            ]);
        }

        return $config;
    }

    /**
     * Returns the response configuration.
     */
    public static function getResponseConfig(): array
    {
        return [
            static::T110  => ['Clé de tri en Expédition/Transit', 3],
            static::T310  => ['Clé de tri en réception', 1],
            static::T100  => ['Pays Destination', 2],
            static::T101  => ['Dépôt GLS de livraison', 4],
            static::T320  => ['Tournée de livraison', 4],
            static::T330  => ['Code postal destinataire', 10],
            static::T8913 => ['GLS TrackId', 8],
            static::T8902 => ['Datamatrix Principal', 123],
            static::T8903 => ['Datamatrix secondaire', 106],
        ];
    }

    /**
     * Validates the client configuration.
     */
    public static function validateClientConfig(array $config)
    {
        foreach ([static::T8700, static::T8915, static::T8914] as $tag) {
            if (!array_key_exists($tag, $config) || empty($config[$tag])) {
                throw new InvalidArgumentException('Please configure value for tag ' . $tag);
            }
        }
    }
}
