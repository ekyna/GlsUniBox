<?php

declare(strict_types=1);

namespace Ekyna\Component\GlsUniBox\Generator;

use Ekyna\Component\GlsUniBox\Exception\RuntimeException;

/**
 * Class NumberGenerator
 * @package Ekyna\Component\GlsUniBox\Generator
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class NumberGenerator implements NumberGeneratorInterface
{
    private string $path;
    /** @var resource */
    private $handle;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function generate(): int
    {
        $number = $this->readNumber();

        $number++;

        $this->writeNumber($number);

        return $number;
    }

    /**
     * Reads the previous number.
     */
    private function readNumber(): int
    {
        // Open
        if (false === $this->handle = fopen($this->path, 'c+')) {
            throw new RuntimeException("Failed to open file $this->path.");
        }
        // Exclusive lock
        if (!flock($this->handle, LOCK_EX)) {
            throw new RuntimeException("Failed to lock file $this->path.");
        }

        if (false !== $number = fread($this->handle, 10)) {
            return (int)$number;
        }

        return 0;
    }

    /**
     * Writes the new number.
     */
    private function writeNumber(int $number): void
    {
        // Truncate
        if (!ftruncate($this->handle, 0)) {
            throw new RuntimeException("Failed to truncate file $this->path.");
        }
        // Reset
        if (0 > fseek($this->handle, 0)) {
            throw new RuntimeException("Failed to move pointer at the beginning of the file $this->path.");
        }
        // Write
        if (!fwrite($this->handle, (string)$number)) {
            throw new RuntimeException("Failed to write file $this->path.");
        }
        // Flush
        if (!fflush($this->handle)) {
            throw new RuntimeException("Failed to flush file $this->path.");
        }
        // Unlock
        if (!flock($this->handle, LOCK_UN)) {
            throw new RuntimeException("Failed to unlock file $this->path.");
        }
        // Close
        fclose($this->handle);
    }
}
