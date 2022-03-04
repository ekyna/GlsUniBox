<?php

declare(strict_types=1);

namespace Ekyna\Component\GlsUniBox\Api;

/**
 * Class AbstractData
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
abstract class AbstractData
{
    public const START_TOKEN = '\\\\\\\\\\GLS\\\\\\\\\\';
    public const END_TOKEN   = '/////GLS/////';

    private array $data = [];


    /**
     * Returns the data.
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Sets the value for the given tag.
     */
    protected function set(string $tag, string $value): self
    {
        $this->data[$tag] = $value;

        return $this;
    }

    /**
     * Returns the value for the given tag.
     */
    protected function get(string $tag): ?string
    {
        if (isset($this->data[$tag])) {
            return $this->data[$tag];
        }

        return null;
    }

    /**
     * Removes keys with empty value.
     */
    public function clean(): self
    {
        foreach ($this->data as $key => $data) {
            if (empty($data)) {
                unset($this->data[$key]);
            }
        }

        return $this;
    }
}
