<?php

namespace EnlightenedDC\Gearman;

use EnlightenedDC\Gearman\Exception\GearmanConnectionException;
use EnlightenedDC\Gearman\Exception\NoGearmanConnectionException;

/**
 * Class Connection
 *
 * @package EnlightenedDC\Gearman
 */
class Connection
{
    /**
     * @var array
     */
    private $parameters = [
        'host' => '127.0.0.1',
        'port' => 4730
    ];

    /**
     * @var resource
     */
    private $connection;

    /**
     * @param array $parameters
     * @param bool  $autoConnect
     *
     * @throws NoGearmanConnectionException
     */
    public function __construct(array $parameters =[], $autoConnect = true)
    {
        $this->parameters = array_merge($this->parameters, $parameters);

        if (true === $autoConnect) {
            $this->connect();
        }
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @return string|null
     */
    public function getHost()
    {
        if (true === isset($this->parameters['host'])) {
            return $this->parameters['host'];
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getPort()
    {
        if (true === isset($this->parameters['port'])) {
            return $this->parameters['port'];
        }

        return null;
    }

    /**
     * @param float $timeout
     *
     * @return bool
     * @throws NoGearmanConnectionException
     */
    public function connect($timeout = 5.0)
    {
        if (true === $this->isConnected()) {
            return false;
        }

        $errorNumber = 0;
        $errorMessage = '';

        $this->connection = @fsockopen(
            $this->parameters['host'],
            $this->parameters['port'],
            $errorNumber,
            $errorMessage,
            $timeout
        );

        if (false === $this->isConnected()) {
            throw new NoGearmanConnectionException($errorMessage, $errorNumber);
        }

        return true;
    }

    /**
     * @return bool
     */
    public function close()
    {
        if (false === $this->isConnected()) {
            return false;
        }

        fclose($this->connection);

        return true;
    }

    /**
     * @return bool
     */
    public function isConnected()
    {
        return is_resource($this->connection);
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws GearmanConnectionException
     * @throws NoGearmanConnectionException
     */
    public function send(Request $request)
    {
        if (false === $this->isConnected()) {
            throw new NoGearmanConnectionException();
        }

        $isWritten = fwrite(
            $this->connection,
            $request->getCommand(),
            $request->getLength()
        );

        if (false === $isWritten) {
            throw new GearmanConnectionException();
        }

        $response = new Response();

        while(!feof($this->connection)) {
            $line = trim(fgets($this->connection));

            if ($line === '.') {
                break;
            }

            $response->addLine($line);
        }

        return $response;
    }

    /**
     * Closes the connection.
     */
    public function __destruct()
    {
        $this->close();
    }
}
