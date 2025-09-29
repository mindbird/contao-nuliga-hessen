<?php

namespace Mindbird\ContaoNuligaHessen\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContaoNuligaHessenExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container)
    {
        new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'))->load('config.yaml');
    }
}