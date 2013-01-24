<?php
namespace Dtc\SpriteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader;

class DtcSpriteExtension
    extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $configuration = new Configuration();
        $config = $processor->processConfiguration($configuration, $configs);

        $yamlLoader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $yamlLoader->load('sprite.yml');

        $spriteManagerDef = $container->getDefinition('dtc_sprite.manager');
        foreach ($config['sprites'] as $key => $spriteConfig) {
            $spriteManagerDef->addMethodCall('addSpriteConfig', array($key, $spriteConfig));
        }
    }

    public function getAlias()
    {
        return 'dtc_sprite';
    }
}
