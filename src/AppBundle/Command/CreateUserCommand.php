<?php
/**
 * Created by PhpStorm.
 * User: cjpa
 * Date: 27/06/2017
 * Time: 02:14
 */

namespace AppBundle\Command;


use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cryptofunds:user:create')
            ->setDescription('Create a new user')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputArgument('ethAddress', InputArgument::REQUIRED, 'The user\'s ETH Address'),
                new InputArgument('initialFunds', InputArgument::REQUIRED, 'The funds the user contributes'),
                new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the user as super admin'),
                new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
            ))
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /**
         * @var $userManager UserManager
         */
        $userManager = $this->getContainer()->get('fos_user.user_manager');

        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $ethAddress = $input->getArgument('ethAddress');
        $initialFunds = $input->getArgument('initialFunds');
        $inactive = $input->getOption('inactive');
        $superadmin = $input->getOption('super-admin');

        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEthAddress($ethAddress);
        $user->setInitialFunds($initialFunds);
        $user->setEnabled((bool) !$inactive);
        $user->setSuperAdmin((bool) $superadmin);
        $user->setPercentage(0);

        if ($initialFunds > 0) {
            $user->addRole('ROLE_PARTICIPANT');
        }

        $userManager->updateUser($user);

        $now = new \DateTime();
        $output->writeln($now->format('Y-m-d H:i:s') . "- Generated new user: $username");
    }
}