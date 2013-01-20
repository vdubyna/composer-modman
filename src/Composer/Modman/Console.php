<?php

namespace Composer\Modman;

use Symfony\Component\Console\Application;
use Composer\Modman\Command;

class Console extends Application
{
    public function __construct() {
        parent::__construct('Welcome to Composer Modman', '0.1.0');

        $this->addCommands(array(
            new Command\Install(), // Install package
            new Command\Commit(), // Back changes to repository (vendor dir)
        ));
    }
}