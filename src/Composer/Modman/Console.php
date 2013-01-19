<?php

namespace Composer\Modman;

use Symfony\Component\Console\Application;
use Composer\Modman\Command;

class Console extends Application
{
    public function __construct() {
        parent::__construct('Welcome to Composer Modman', '1.0');

        $this->addCommands(array(
            new Command\Install(), // Install module
//            new Command\Commit(), // Back changes to repository (vendor dir)
//            new Command\Status(), // Check repository Status
//            new Command\Update(), // Update module from repository
        ));
    }
}