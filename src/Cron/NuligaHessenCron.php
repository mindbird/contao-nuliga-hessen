<?php

namespace Mindbird\ContaoNuligaHessen\Cron;

use Contao\CoreBundle\Cron\Cron;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCronJob;

#[AsCronJob('*/5 * * * *')]
class NuligaHessenCron
{
    public function __invoke()
    {

    }

}