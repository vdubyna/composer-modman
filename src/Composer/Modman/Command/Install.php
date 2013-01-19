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
            )
            ->setDescription('Install package into application');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Hello</info>");
    }
}