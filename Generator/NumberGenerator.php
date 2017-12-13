<?php

namespace Ekyna\Component\GlsUniBox\Generator;

use Ekyna\Component\GlsUniBox\Exception\RuntimeException;

/**
 * Class NumberGenerator
 * @package Ekyna\Component\GlsUniBox\Generator
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class NumberGenerator
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var resource
     */
    private $handle;


    /**
     * Constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Generates the number.
     */
    public function generate()
    {
        $number = $this->readNumber();

        $number++;

        $this->writeNumber((string)$number);

        return $number;
    }

    /**
     * Reads the previous number.
     *
     * @return int
     */
    private function readNumber()
    {
        $doRead = file_exists($this->path) && date('Ym') === date('Ym', filemtime($this->path));

        // Open
        if (false === $this->handle = fopen($this->path, 'c+')) {
            throw new RuntimeException("Failed to open file {$this->path}.");
        }
        // Exclusive lock
        if (!flock($this->handle, LOCK_EX)) {
            throw new RuntimeException("Failed to lock file {$this->path}.");
        }

        if ($doRead && false !== $number = fread($this->handle, 10)) {
            return intval($number);
        }

        return 0;
    }

    /**
     * Writes the new number.
     *
     * @param string $number
     */
    private function writeNumber($number)
    {
        // Truncate
        if (!ftruncate($this->handle, 0)) {
            throw new RuntimeException("Failed to truncate file {$this->path}.");
        }
        // Reset
        if (0 > fseek($this->handle, 0)) {
            throw new RuntimeException("Failed to move pointer at the beginning of the file {$this->path}.");
        }
        // Write
        if (!fwrite($this->handle, $number)) {
            throw new RuntimeException("Failed to write file {$this->path}.");
        }
        // Flush
        if (!fflush($this->handle)) {
            throw new RuntimeException("Failed to flush file {$this->path}.");
        }
        // Unlock
        if (!flock($this->handle, LOCK_UN)) {
            throw new RuntimeException("Failed to unlock file {$this->path}.");
        }
        // Close
        fclose($this->handle);
    }
}
