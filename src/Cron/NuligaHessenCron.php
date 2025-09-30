<?php

namespace Mindbird\ContaoNuligaHessen\Cron;

use Contao\CoreBundle\Cron\Cron;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCronJob;
use Contao\CoreBundle\Exception\CronExecutionSkippedException;
use Contao\CoreBundle\Util\ProcessUtil;
use GuzzleHttp\Promise\PromiseInterface;

#[AsCronJob('*/5 * * * *')]
class NuligaHessenCron
{
    public function __construct(private ProcessUtil $processUtil) {}

    public function __invoke(string $scope): PromiseInterface
    {
        if (Cron::SCOPE_WEB === $scope) {
            throw new CronExecutionSkippedException();
        }

        return $this->processUtil->createPromise(
            $this->processUtil->createSymfonyConsoleProcess('nuliga-hessen:update')
        );
    }

}