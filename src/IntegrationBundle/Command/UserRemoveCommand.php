<?php

namespace IntegrationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class UserRemoveCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app-platform:users:remove')
            ->addArgument('username', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userManager = $this->getContainer()->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($input->getArgument('username'));
        if (null === $user) {
            $output->writeln('User not found.');

            return;
        }

        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Are you sure you want to delete the user?');
        if ($helper->ask($input, $output, $question)) {
            $userManager->deleteUser($user);
        }
    }
}
