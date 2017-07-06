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
                new InputArgument('ethAddress', InputArgument::REQUIRED, 'The user\'s ETH Address'),
                new InputArgument('initialFunds', InputArgument::REQUIRED, 'The funds the user contributes'),
                new InputArgument('password', InputArgument::OPTIONAL, 'The password', $this->randomPassword(10, true, 'lud')),
                new InputOption('super-admin', null, InputOption::VALUE_NONE, 'Set the user as super admin'),
                new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
            ));
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
        $user->setEnabled((bool)!$inactive);
        $user->setSuperAdmin((bool)$superadmin);
        $user->setPercentage(0);

        if ($initialFunds > 0) {
            $user->addRole('ROLE_PARTICIPANT');
        }

        $userManager->updateUser($user);

        $now = new \DateTime();
        $output->writeln($now->format('Y-m-d H:i:s') . "- Generated new user: $username with password $password");
    }

    // Generates a strong password of N length containing at least one lower case letter,
    // one uppercase letter, one digit, and one special character. The remaining characters
    // in the password are chosen at random from those four sets.
    //
    // The available characters in each set are user friendly - there are no ambiguous
    // characters such as i, l, 1, o, 0, etc. This, coupled with the $add_dashes option,
    // makes it much easier for users to manually type or speak their passwords.
    //
    // Note: the $add_dashes option will increase the length of the password by
    // floor(sqrt(N)) characters.
    private function randomPassword($length = 9, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if (strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if (strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if (strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach ($sets as $set) {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if (!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while (strlen($password) > $dash_len) {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;
        return $dash_str;
    }
}