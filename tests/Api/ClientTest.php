<?php

declare(strict_types=1);

namespace Ekyna\Component\GlsUniBox\Tests\Api;

use DateTime;
use Ekyna\Component\GlsUniBox\Api\Client;
use Ekyna\Component\GlsUniBox\Api\Config;
use Ekyna\Component\GlsUniBox\Api\Request;
use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 * @package Ekyna\Component\GlsUniBox\Tests\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ClientTest extends TestCase
{
    private function createClient(): Client
    {
        return new Client([
            Config::T8700 => $_ENV['T8700'],
            Config::T8915 => $_ENV['T8915'],
            Config::T8914 => $_ENV['T8914'],
        ]);
    }

    public function testSimpleRequest(): void
    {
        $request = new Request(123);
        $request
            ->setDate(new DateTime())
            ->setReceiverReference('TEST01')
            ->setReceiverCompany('GLS Bordeaux')
            ->setOriginReference('0200000000050000FR')
            ->setWeight('12.32')
            ->setReceiverStreet('ALLEE DE GASCOGNE')
            ->setReceiverSupplement2('LOT. FEYDEAU OUEST')
            ->setReceiverCountry('FR')
            ->setReceiverPostalCode('33370')
            ->setReceiverCity('ARTIGUES PRES BORDEAUX')
            ->setSenderCompany('IT - RESERVE TEST INTERNET')
            ->setSenderStreet('14, RUE MICHEL LABROUSSE')
            ->setSenderCountry('FR')
            ->setSenderPostalCode('31037')
            ->setSenderCity('TOULOUSE CEDEX 1');

        $client = $this->createClient();

        $response = $client->send($request);

        $this->assertTrue($response->isSuccessful());
    }
}
