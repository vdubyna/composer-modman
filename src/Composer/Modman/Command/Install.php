<?php
/**
 * @author vovikha@gmail.com
 */

namespace Composer\Modman\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Composer\Modman\Package;
use Symfony\Component\Filesystem\Filesystem;

class Install extends Command
{
    /**
     * Configure command, set parameters definition and help.
     */
    protected function configure() {
        $this->setName('install')
            ->addArgument(
                'package',
                InputArgument::REQUIRED,
                'Package name to install'
            )->addOption(
                'application-dir',
                null,
                InputOption::VALUE_REQUIRED,
                'Application Directory absolute path'
            )->addOption(
                'package-dir',
                null,
                InputOption::VALUE_REQUIRED,
                'Package source absolute path'
            )
            ->setDescription('Install package into application');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $package = new Package(
                $input->getArgument('package'),
                $input->getOption('application-dir'),
                $input->getOption('package-dir'),
                new Filesystem()
            );

            $package->install();

            $output->writeln("<info>Package installed</info>");
        } catch (\Exception $e) {
            $output->writeln("<error>Error</error>");
            $output->write($e->getMessage());
        }
    }
}