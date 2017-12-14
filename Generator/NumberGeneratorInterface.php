<?php

namespace Ekyna\Component\GlsUniBox\Generator;

/**
 * Interface NumberGeneratorInterface
 * @package Ekyna\Component\GlsUniBox\Generator
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface NumberGeneratorInterface
{
    /**
     * Generates the number.
     *
     * @return int
     */
    public function generate();
}
