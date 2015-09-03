<?php

namespace EnlightenedDC\Gearman;

/**
 * Class Response
 *
 * @package EnlightenedDC\Gearman
 */
class Response
{
    /**
     * @var array
     */
    private $lines = [];

    /**
     * @param string $line
     */
    public function addLine($line)
    {
        $this->lines[] = $line;
    }

    /**
     * @return array
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(PHP_EOL, $this->lines);
    }
}
