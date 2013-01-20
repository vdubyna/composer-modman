<?php
/**
 * @author vovikha@gmail.com
 */

namespace Composer\Modman\Test\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Composer\Modman\Command\Commit;
use Composer\Modman\Package;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Install module into application
 *
 * - Set Package (source) directory and Application (destenation) directory
 * - Load Files map of the Package
 * - Copy files to application Folder, based on map
 *
 */
class CommitTest extends \PHPUnit_Framework_TestCase
{

    public function getApplicationDir()
    {
        return __DIR__ . '/fixtures';
    }

    public function getPackageDir()
    {
        return __DIR__ . '/fixtures/vendor/vdubyna/package';
    }

    /**
     * @return \Composer\Modman\Package
     */
    public function getPackage()
    {
        $package = new Package('vdubyna/package', $this->getApplicationDir(), $this->getPackageDir(), new Filesystem());
        $package->setFilesmapName('commitfilesmap.json');

        return $package;
    }


    public function testWhenExecute_ShouldReturnSuccessMessage()
    {
        return $this->markTestIncomplete('Not implemented yet');
        // Arrange | Given
        $application = new Application();
        $application->add(new Commit());

        $command       = $application->find('commit');
        $commandTester = new CommandTester($command);

        // Act     | When
        $commandTester->execute(
            array(
                'command'           => $command->getName(),
                'package'           => 'vdubyna/package',
                '--application-dir' => $this->getApplicationDir(),
                '--package-dir'     => $this->getPackageDir(),
            )
        );

        // Assert  | Then
        $this->assertRegExp('/Package commited/', $commandTester->getDisplay());
    }

    public function testWhenCommitPackageFiles_ShouldFilesBeCoppiedFromApplicationToPackage()
    {
        // Arrange | Given
        $package = $this->getPackage();
        // Act     | When
        $package->commit();
        // Assert  | Then
        $this->assertTrue(file_exists(__DIR__ . '/fixtures/vendor/vdubyna/package/src/file2.txt'));
        $this->assertTrue(file_exists(__DIR__ . '/fixtures/vendor/vdubyna/package/src/app/file2.txt'));
    }

    public function tearDown()
    {
        parent::tearDown();

        //@todo mock filesystem
        if (file_exists(__DIR__ . '/fixtures/vendor/vdubyna/package/src/file2.txt')) {
            unlink(__DIR__ . '/fixtures/vendor/vdubyna/package/src/file2.txt');
        }
        if (is_dir(__DIR__ . '/fixtures/app/vendor/vdubyna/package/src/app/file2.txt')) {
            unlink(__DIR__ . '/fixtures/app/vendor/vdubyna/package/src/app/file2.txt');
        }
    }

}