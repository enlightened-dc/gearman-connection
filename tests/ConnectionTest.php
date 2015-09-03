<?php

namespace EnlightenedDC\Gearman\Tests;

use EnlightenedDC\Gearman\Connection;
use EnlightenedDC\Gearman\Request;
use EnlightenedDC\Gearman\Exception\GearmanConnectionException;
use EnlightenedDC\Gearman\Exception\NoGearmanConnectionException;

/**
 * Class ConnectionTest
 *
 * @coversDefaultClass \EnlightenedDC\Gearman\Connection
 */
class ConnectionTest extends \PHPUnit_Framework_TestCase
{
    public function testParametersAreCorrectSet()
    {
        $parameters = [
            'host' => '127.0.0.1',
            'port' => 4730
        ];

        $connection = new Connection($parameters, false);

        $this->assertEquals(serialize($parameters), serialize($connection->getParameters()));
        $this->assertEquals('127.0.0.1', $connection->getHost());
        $this->assertEquals(4730, $connection->getPort());
    }

    public function testConnectionCanBeEstablishedAndCanBeClosed()
    {
        try {
            $connection = new Connection();
            $this->assertTrue($connection->isConnected());
            $connection->close();
            $this->assertFalse($connection->isConnected());
        } catch (NoGearmanConnectionException $exception) {
            $this->markTestSkipped(
                'You need a running gearmand instance with default parameters for this test!
            ');
        }
    }

    public function testCanSendACommandAndGetResponse()
    {
        try {
            $connection = new Connection();
            $response = $connection->send(new Request('status'));
            $this->assertInstanceOf('EnlightenedDC\Gearman\Response', $response);
        } catch (GearmanConnectionException $exception) {
            $this->markTestSkipped(
                'You need a running gearmand instance with default parameters for this test!
            ');
        }
    }
}
