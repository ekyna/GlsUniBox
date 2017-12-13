<?php

namespace Ekyna\Component\GlsUniBox\Tests\Api;

use Ekyna\Component\GlsUniBox\Api\Client;
use Ekyna\Component\GlsUniBox\Api\Config;
use Ekyna\Component\GlsUniBox\Api\Request;

/**
 * Class ClientTest
 * @package Ekyna\Component\GlsUniBox\Tests\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    private function createClient()
    {
        return new Client([
            Config::T8700 => 'FR0031',
            Config::T8915 => '2500011329',
            Config::T8914 => '2501369229',
        ]);
    }

    public function test_simple_request()
    {
        $request = new Request(1);
        $request
            ->setDate(new \DateTime())
            ->setReceiverReference('TEST01')
            ->setReceiverCompany('GLS Bordeaux')
            ->setOriginReference('0200000000050000FR')
            ->setWeight(12.32)
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
