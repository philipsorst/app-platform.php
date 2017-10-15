<?php

namespace IntegrationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * @author Philip Washington Sorst <philip@sorst.net>
 */
class BuildAngularCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app-platform:build-angular')
            ->addOption('force-prod', null, InputOption::VALUE_NONE)
            ->addOption('skip-npm', null, InputOption::VALUE_NONE);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $prod = $input->getOption('force-prod');
        if (false === $prod) {
            $environment = $this->getContainer()->get('kernel')->getEnvironment();
            $prod = $prod || 'prod' === $environment;
        }

        if (!$input->getOption('skip-npm')) {
            $output->writeln('Installing Node Packages');
            $npmInstallProcess = new Process('npm install');
            $npmInstallProcess->setWorkingDirectory(
                $this->getContainer()->get('kernel')->getRootDir() . '/../angular/'
            );
            try {
                $npmInstallProcess->mustRun(
                    function ($type, $buffer) {
                        if (Process::ERR === $type) {
                            echo 'ERR > ' . $buffer;
                        } else {
                            echo 'OUT > ' . $buffer;
                        }
                    }
                );
            } catch (ProcessFailedException $e) {
                $output->writeln($e->getMessage());

                return -1;
            }
        }

        $output->writeln('Building Angular');
        $angularBuildCommandLine = 'ng build';
        $baseHref = $this->getContainer()->get('app_platform.service.url')->getAngularBaseHref();
        $angularBuildCommandLine .= ' -bh ' . $baseHref;
        if ($prod) {
            $angularBuildCommandLine .= ' -prod -aot';
        }
        $angularBuildProcess = new Process($angularBuildCommandLine);
        $angularBuildProcess->setWorkingDirectory($this->getContainer()->get('kernel')->getRootDir() . '/../angular/');
        try {
//            $angularBuildProcess->mustRun(
//                function ($type, $buffer) {
//                    if (Process::ERR === $type) {
//                        echo 'ERR > ' . $buffer;
//                    } else {
//                        echo 'OUT > ' . $buffer;
//                    }
//                }
//            );
            $output->writeln('Executing: ' . $angularBuildProcess->getCommandLine());
            $angularBuildProcess->mustRun();
        } catch (ProcessFailedException $e) {
            $output->writeln($e->getMessage());

            return -1;
        }

        return 0;
    }
}