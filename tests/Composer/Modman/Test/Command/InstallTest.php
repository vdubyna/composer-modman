<?php
/**
 * @author vovikha@gmail.com
 */

namespace Composer\Modman\Test\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Composer\Modman\Command\Install;


/**
 * Install module into application
 *
 * - Find composer.json
 * - Find module name
 * - Find Application root dir (optional)
 * - Load Files map of the module (find module config)
 * - Copy files to application Folder, based on map
 *
 *
 */
class InstallTest extends \PHPUnit_Framework_TestCase
{


    public function testExecute()
    {
        $application = new Application();
        $application->add(new Install());

        $command = $application->find('install');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array('command' => $command->getName()));

        $this->assertRegExp('/Hello/', $commandTester->getDisplay());
    }

    public function testGetComposerConfiguration()
    {
        $this->markTestIncomplete("Not implemented yet");
    }


}