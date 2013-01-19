<?php
namespace Speroteck\MagentoCli\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Speroteck\MagentoCli\Console\Command\Command;

class Install extends Command
{
    /**
     * Configure command, set parameters definition and help.
     */
    protected function configure() {
        $this
            ->setName('mage:install')
            ->setDescription('Install magento in a true way')
            ->addOption(
            'db-name',
            null,
            InputOption::VALUE_REQUIRED,
            'Database name'
        )
            ->addOption(
            'db-pass',
            null,
            InputOption::VALUE_OPTIONAL,
            'Database password'
        )
            ->addOption(
            'db-user',
            null,
            InputOption::VALUE_REQUIRED,
            'Database user'
        )
            ->addOption(
            'host',
            null,
            InputOption::VALUE_REQUIRED,
            'Host name'
        )
            ->addOption(
            'admin-pass',
            null,
            InputOption::VALUE_REQUIRED,
            'Admin password'
        )
            ->setHelp(sprintf(
            '%sInstall magento.%s',
            PHP_EOL,
            PHP_EOL
        ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dbName = $input->getOption('db-name');
        $dbPass = $input->getOption('db-pass');
        $dbUser = $input->getOption('db-user');
        $host = $input->getOption('host');
        $adminPass = $input->getOption('admin-pass');

        $baseDir = $this->getMagentoBaseDir(__DIR__);

        $cmd = "php -f {$baseDir}/install.php -- --license_agreement_accepted yes \\
            --locale en_US --timezone Europe/Kiev --default_currency USD \\
            --db_host 127.0.0.1 --db_name {$dbName} --db_user {$dbUser} --db_pass '{$dbPass}' \\
            --url '{$host}' --use_rewrites yes --skip_url_validation yes \\
            --use_secure no --use_secure_admin no \\
            --secure_base_url '{$host}' \\
            --admin_lastname Owner --admin_firstname Store \\
            --admin_email vovikha@gmail.com --admin_username admin \\
            --admin_password {$adminPass}";

        $ex = passthru($cmd);
        $output->writeln("<info>{$ex}</info>");
    }
}