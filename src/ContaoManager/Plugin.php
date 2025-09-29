<?php

namespace Mindbird\ContaoNuligaHessen\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Config\ContainerBuilder;
use Mindbird\ContaoNuligaHessen\ContaoNuligaHessenBundle;

class Plugin implements BundlePluginInterface
{

    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoNuligaHessenBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}