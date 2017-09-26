<?php

namespace Ekyna\Component\GlsUniBox\Api;

/**
 * Class AbstractData
 * @package Ekyna\Component\GlsUniBox\Api
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
abstract class AbstractData
{
    const START_TOKEN = '\\\\\\\\\\GLS\\\\\\\\\\';
    const END_TOKEN   = '/////GLS/////';


    /**
     * @var array
     */
    private $data = [];


    /**
     * Returns the data.
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Sets the value for the given tag.
     *
     * @param string $tag
     * @param string $value
     *
     * @return $this
     */
    protected function set($tag, $value)
    {
        $this->data[$tag] = $value;

        return $this;
    }

    /**
     * Returns the value for the given tag.
     *
     * @param string $tag
     *
     * @return string|null
     */
    protected function get($tag)
    {
        if (isset($this->data[$tag])) {
            return $this->data[$tag];
        }

        return null;
    }

    /**
     * Removes keys with empty value.
     *
     * @return $this
     */
    public function clean()
    {
        foreach ($this->data as $key => $data) {
            if (empty($data)) {
                unset($this->data[$key]);
            }
        }

        return $this;
    }
}
