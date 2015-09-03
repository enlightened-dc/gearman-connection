<?php

namespace EnlightenedDC\Gearman;

/**
 * Class Request
 *
 * @package EnlightenedDC\Gearman
 */
class Request
{
    /**
     * @var string
     */
    private $command;

    /**
     * @param string $command
     */
    public function __construct($command)
    {
        $this->command = $command . PHP_EOL;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return strlen($this->command);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->command;
    }
}
