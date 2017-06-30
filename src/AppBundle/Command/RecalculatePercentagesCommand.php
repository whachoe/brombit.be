<?php
/**
 * Created by PhpStorm.
 * User: cjpa
 * Date: 27/06/2017
 * Time: 02:14
 */

namespace AppBundle\Command;


use AppBundle\Service\User;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RecalculatePercentagesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cryptofunds:recalculate')
            ->setDescription('Recalculate all the percentages')
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userService = new User($this->getContainer()->get('doctrine.orm.default_entity_manager'));

        $userService->recalculatePercentages();

        $now = new \DateTime();
        $output->writeln($now->format('Y-m-d H:i:s') . "- Recalculated percentages");
    }
}