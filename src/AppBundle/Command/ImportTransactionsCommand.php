<?php
/**
 * Created by PhpStorm.
 * User: cjpa
 * Date: 27/06/2017
 * Time: 02:14
 */

namespace AppBundle\Command;


use AppBundle\Entity\TransactionHistory;
use AppBundle\Type\MyDateTime;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportTransactionsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cryptofunds:import:transactions')
            ->setDescription('Import a transactions CSV file')
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
                    $this->makeTransaction($yo);
                }
            }
            $this->getContainer()->get('doctrine.orm.default_entity_manager')->flush();

            $now = new \DateTime();
            $output->writeln($now->format('c') . "- Imported balances: $csvfile");
        } else {
            $now = new \DateTime();
            $output->writeln($now->format('c') . " - Failed to import from $csvfile");
        }
    }

    private function makeTransaction($yo)
    {
        $date = new MyDateTime($yo[0]);
        if ($date instanceof MyDateTime) {
            $transaction = new TransactionHistory();
            $transaction->setDate($date)
                ->setFromCurrency($yo[1])
                ->setFromAmount($yo[2])
                ->setToCurrency($yo[3])
                ->setToAmount($yo[4]);

            $query = $this->getContainer()->get('doctrine.orm.default_entity_manager')
                ->createQueryBuilder()
                ->select('t')->from('AppBundle:TransactionHistory', 't')
                ->where('t.transactionDate = :date')
                ->setParameter('date', $date)
                ->getQuery();

            $existing = $query->getResult();

            if (count($existing) == 0) {
                $this->getContainer()->get('doctrine.orm.default_entity_manager')->persist($transaction);
            }
        }
    }
}