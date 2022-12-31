<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'ImportCsvCommand',
    description: 'Add a short description for your command',
)]
class ImportCsvCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setDescription('Import a CSV file')
            ->addArgument('filename', InputArgument::REQUIRED, 'The CSV file to import');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $filename = $input->getArgument('filename');

        $handle = fopen($filename, 'r');

        while (($data = fgetcsv($handle)) !== false) {
            // Traitement des données lues à partir du fichier CSV
            dump($data);
        }

        fclose($handle);

        $io->success('success import');

        return Command::SUCCESS;
    }
}
