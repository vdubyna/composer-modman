<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vovikha
 * Date: 18.01.13
 * Time: 21:38
 * To change this template use File | Settings | File Templates.
 */


namespace Composer\Modman\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Composer\Modman\Package;
use Symfony\Component\Filesystem\Filesystem;

class Commit extends Command
{
    /**
     * Configure command, set parameters definition and help.
     */
    protected function configure()
    {
        $this->setName('commit')
            ->addArgument(
                'package',
                InputArgument::REQUIRED,
                'Package name to commit'
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
            )->setDescription(
                'Commit package changes from application into package'
            );
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

            $package->commit();

            $output->writeln("<info>Package commited</info>");
        } catch (\Exception $e) {
            $output->writeln("<error>Error</error>");
            $output->write($e->getMessage());
        }
    }
}