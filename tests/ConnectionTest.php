<?php

namespace TM\Gearman\Tests;

use TM\Gearman\Connection;
use TM\Gearman\Request;
use TM\Gearman\Exception\GearmanConnectionException;
use TM\Gearman\Response;

/**
 * @coversDefaultClass \TM\Gearman\Connection
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
        } catch (GearmanConnectionException $exception) {
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
            $this->assertInstanceOf(Response::class, $response);
        } catch (GearmanConnectionException $exception) {
            $this->markTestSkipped(
                'You need a running gearmand instance with default parameters for this test!
            ');
        }
    }
}
