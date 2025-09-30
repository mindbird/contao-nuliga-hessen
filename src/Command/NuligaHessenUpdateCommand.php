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
        $groupIds = $this->nuligaHessenService->getUsedGroupIds();
        foreach ($groupIds as $data) {
            $symfonyStyle->writeln('Working on group ID: ' . $data['group_id']);
            try {
                $response = $this->nuligaHessenService->fetchGroupDataFromApi($data['group_id']);
                file_put_contents(__DIR__ . '/../../json/' . $data['group_id'] . '.json', $response);
                $symfonyStyle->success('Successfully updated group ID: ' . $data['group_id']);
            } catch (\Exception $e) {
                $symfonyStyle->error('Error updating group ID ' . $data['group_id'] . ': ' . $e->getMessage());
            }
        }
        return Command::SUCCESS;
    }

}