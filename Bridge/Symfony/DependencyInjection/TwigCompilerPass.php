<?php

namespace Ekyna\Component\GlsUniBox\Bridge\Symfony\DependencyInjection;

use Ekyna\Component\GlsUniBox\Bridge\Twig\BarcodeExtension;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class TwigCompilerPass
 * @package Ekyna\Component\GlsUniBox\Bridge\Symfony\DependencyInjection;
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class TwigCompilerPass implements CompilerPassInterface
{
    /**
     * @inheritdoc
     */
    public function process(ContainerBuilder $container)
    {
        // Twig template path namespace
        if ($container->hasDefinition('twig.loader.filesystem')) {
            $loader = $container->getDefinition('twig.loader.filesystem');

            $path = realpath(__DIR__.'/../../../Resources/views');
            $loader->addMethodCall('addPath', [$path, 'GlsUniBox']);
        }

        // Twig barcode extension
        $definition = new Definition(BarcodeExtension::class);
        $definition->addTag('twig.extension');

        $container->setDefinition('ekyna_gls_uni_box.twig.barcode_extension', $definition);
    }
}
