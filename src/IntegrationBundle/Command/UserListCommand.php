<?php

namespace IntegrationBundle\Command;

use DomainBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class UserListCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('app-platform:users:list');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userRepository = $this->getContainer()->get('doctrine')->getRepository(User::class);
        /** @var User[] $users */
        $users = $userRepository->findAll();

        $table = new Table($output);
        $table->setHeaders(['username', 'email', 'roles', 'active']);
        foreach ($users as $user) {
            $table->addRow(
                [
                    $user->getUsername(),
                    $user->getEmail(),
                    implode(',', $user->getRoles()),
                    $user->isEnabled() ? 'x' : ''
                ]
            );
        }
        $table->render();
    }
}
