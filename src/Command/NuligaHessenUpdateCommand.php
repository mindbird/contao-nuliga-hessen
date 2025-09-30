<?php

namespace Mindbird\ContaoNuligaHessen\Command;

use Mindbird\ContaoNuligaHessen\Service\NuligaHessenService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'nuliga-hessen:update', description: 'Update data from NuLiga Hessen')]
class NuligaHessenUpdateCommand extends Command
{
    public function __construct(private readonly NuligaHessenService $nuligaHessenService)
    {
        parent::__construct();
    }

    public function __invoke(OutputInterface $output, InputInterface $input): int
    {
        $symfonyStyle = new SymfonyStyle($input, $output);
        $symfonyStyle->info('Starting NuLiga Hessen update...');
        /*
         * Gather group IDs from the db
         * Fetch data from NuLiga for each group ID
         * Save data to... wherever
         */
        $groupIds = $this->nuligaHessenService->getUsedGroupIds();
        foreach ($groupIds as $groupId) {
            $symfonyStyle->writeln('Working on group ID: ' . $groupId['group_id']);
            try {
                $data = $this->nuligaHessenService->fetchGroupDataFromApi($groupId);
                $symfonyStyle->success('Successfully updated group ID: ' . $groupId['group_id']);
            } catch (\Exception $e) {
                $symfonyStyle->error('Error updating group ID ' . $groupId['group_id'] . ': ' . $e->getMessage());
            }
        }
        return Command::SUCCESS;
    }

}