<?php
/**
 * Created by PhpStorm.
 * User: cjpa
 * Date: 27/06/2017
 * Time: 02:14
 */

namespace AppBundle\Command;


use AppBundle\Entity\Balance;
use AppBundle\Type\MyDateTime;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportBalancesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cryptofunds:import:balances')
            ->setDescription('Import a balances CSV file')
            ->setDefinition(array(
                new InputArgument('csvfile', InputArgument::REQUIRED, 'The CSV file to import'),
                new InputOption('lines', null, InputOption::VALUE_REQUIRED, 'Only import the last <LINES> lines', 0),
            ));

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $csvfile = $input->getArgument('csvfile');
        $lines = $input->getOption('lines');

        if ($lines) {
            $data = preg_split("/\r\n|\n|\r/", `tail -n $lines $csvfile`);
        } else {
            $data = file($csvfile);
        }

        if ($data) {
            foreach ($data as $row) {
                if (trim($row)) {
                    $yo = str_getcsv(trim($row), ';', '');
                    $this->makeBalance($yo);
                }
            }
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();

            $now = new \DateTime();
            $output->writeln($now->format('Y-m-d H:i:s') . "- Imported balances: $csvfile");
        } else {
            $output->writeln("Failed to import from $csvfile");
        }
    }

    private function makeBalance($yo)
    {
        $date = new MyDateTime($yo[0]);
        if ($date instanceof MyDateTime) {
            $balance = new Balance();
            $balance->setDate($date);
            $balance->setBtc($yo[1]);
            $balance->setEth($yo[2]);
            $balance->setXmr($yo[3]);
            $balance->setZec($yo[4]);
            $balance->setLtc($yo[5]);
            $balance->setTotalEuro($yo[6]);

            $query = $this->getContainer()->get('doctrine.orm.default_entity_manager')
                ->createQueryBuilder()
                ->select('b')->from('AppBundle:Balance', 'b')
                ->where('b.balanceDate = :date')
                ->setParameter('date', $date)
                ->getQuery();

            $existing = $query->getResult();

            if (count($existing) == 0) {
                $this->getContainer()->get('doctrine.orm.default_entity_manager')->persist($balance);
            }
        }
    }
}