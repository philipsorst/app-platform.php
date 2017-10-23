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
    const ARG_SKIP_NPM = 'skip-npm';

    const ARG_SKIP_ENDPOINT = 'skip-endpoint';

    const ARG_SKIP_MANIFEST = 'skip-manifest';

    const ARG_SKIP_INDEX = 'skip-index';

    const ARG_SKIP_BUILD = 'skip-build';

    const ARG_FORCE_PROD = 'force-prod';

    protected function configure()
    {
        $this
            ->setName('app-platform:build-angular')
            ->addOption(self::ARG_FORCE_PROD, null, InputOption::VALUE_NONE)
            ->addOption(self::ARG_SKIP_NPM, null, InputOption::VALUE_NONE)
            ->addOption(self::ARG_SKIP_ENDPOINT, null, InputOption::VALUE_NONE)
            ->addOption(self::ARG_SKIP_MANIFEST, null, InputOption::VALUE_NONE)
            ->addOption(self::ARG_SKIP_INDEX, null, InputOption::VALUE_NONE)
            ->addOption(self::ARG_SKIP_BUILD, null, InputOption::VALUE_NONE);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $urlService = $this->getContainer()->get('app_platform.service.url');
        $environment = $this->getContainer()->get('kernel')->getEnvironment();
        $angularDir = realpath($this->getContainer()->get('kernel')->getRootDir() . '/../angular/');

        $prod = $input->getOption(self::ARG_FORCE_PROD);
        if (false === $prod) {
            $prod = $prod || 'prod' === $environment;
        }

        if (!$input->getOption(self::ARG_SKIP_NPM)) {
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

        $twig = $this->getContainer()->get('twig');

        if (!$input->getOption(self::ARG_SKIP_ENDPOINT)) {
            $output->writeln('Configuring API endpoint');
            $apiConfigTs = $twig->render(
                'IntegrationBundle:Angular:api-config.twig.ts',
                [
                    'baseUrl' => $urlService->getApiBaseUrl($environment)
                ]
            );
            file_put_contents($angularDir . '/src/environments/api-config.ts', $apiConfigTs);
        }

        if (!$input->getOption(self::ARG_SKIP_MANIFEST)) {
            $output->writeln('Writing Manifest');
            $manifestContent = $twig->render(
                'IntegrationBundle:Angular:manifest.twig.json',
                [
                    'startUrl'        => $urlService->getAngularBaseHref(),
                    'name'            => $this->getContainer()->getParameter('display_name'),
                    'shortName'       => $this->getContainer()->getParameter('display_name'),
                    'themeColor'      => $this->getContainer()->getParameter('theme_color'),
                    'backgroundColor' => $this->getContainer()->getParameter('theme_color'),
                ]
            );
            file_put_contents($angularDir . '/src/manifest.json', $manifestContent);
        }

        if (!$input->getOption(self::ARG_SKIP_INDEX)) {
            $output->writeln('Writing Index');
            $manifestContent = $twig->render(
                'IntegrationBundle:Angular:index.html.twig',
                [
                    'startUrl'        => $urlService->getAngularBaseHref(),
                    'name'            => $this->getContainer()->getParameter('display_name'),
                    'shortName'       => $this->getContainer()->getParameter('display_name'),
                    'themeColor'      => $this->getContainer()->getParameter('theme_color'),
                    'backgroundColor' => $this->getContainer()->getParameter('theme_color'),
                ]
            );
            file_put_contents($angularDir . '/src/index.html', $manifestContent);
        }

        if (!$input->getOption(self::ARG_SKIP_BUILD)) {
            $output->writeln('Building Angular');
            $angularBuildCommandLine = 'ng build';
            $baseHref = $urlService->getAngularBaseHref();
            $angularBuildCommandLine .= ' -bh ' . $baseHref;
            if ($prod) {
                $angularBuildCommandLine .= ' -prod -aot';
            }
            $angularBuildProcess = new Process($angularBuildCommandLine);
            $angularBuildProcess->setTimeout(300);
            $angularBuildProcess->setWorkingDirectory($angularDir);
            try {
                $output->writeln('Executing: ' . $angularBuildProcess->getCommandLine());
                $angularBuildProcess->mustRun();
            } catch (ProcessFailedException $e) {
                $output->writeln($e->getMessage());

                return -1;
            }
        }

        return 0;
    }
}
