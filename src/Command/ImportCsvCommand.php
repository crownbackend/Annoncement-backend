<?php

namespace App\Command;

use App\Entity\City;
use App\Entity\Departement;
use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
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
    public function __construct(private EntityManagerInterface $entityManager, string $name = null)
    {
        parent::__construct($name);
    }

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

        $batchSize = 200;
        $i = 0;
        foreach ($this->convert($filename) as $item) {
            $departmentrepo = $this->entityManager->getRepository(Departement::class);
            $department = $departmentrepo->findOneBy(['codeDepartement' => $item['code_departement']]);
            $city = new City();
            $city->setName($item["nom_commune_complet"]);
            $city->setDepartement($department);
            if(strlen($item["code_postal"]) == 4) {
                $city->setCodePostal(0 . $item["code_postal"]);
            } else {
                $city->setCodePostal($item["code_postal"]);
            }
            $city->setLon($item["longitude"]);
            $city->setLat($item['latitude']);
            $city->setCodeDepartment($item['code_departement']);

            $this->entityManager->persist($city);

            ++$i;
            $io->info($i);
            if (($i % $batchSize) === 0) {
                $io->info($i. ' batch size');
                $this->entityManager->flush(); // Executes all updates.
                $this->entityManager->clear(); // Detaches all objects from Doctrine!
            }
        }

        $this->entityManager->flush();

        $io->success('success import');

        return Command::SUCCESS;
    }

    private function convert($filename, $delimiter = ',')
    {
        if(!file_exists($filename) || !is_readable($filename)) {
            return FALSE;
        }

        $header = NULL;
        $data = array();

        if (($handle = fopen($filename, 'r')) !== FALSE) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
                if(!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        return $data;
    }
}
