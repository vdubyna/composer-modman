<?php
/**
 * @author vovikha@gmail.com
 */

namespace Composer\Modman\Test\Command;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Composer\Modman\Command\Install;
use Composer\Modman\Package;


/**
 * Install module into application
 *
 * - Set Package (source) directory and Application (destenation) directory
 * - Load Files map of the Package
 * - Copy files to application Folder, based on map
 *
 */
class InstallTest extends \PHPUnit_Framework_TestCase
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
        return new Package('vdubyna/package', $this->getApplicationDir(), $this->getPackageDir());
    }


    public function testWhenExecute_ShouldReturnSuccessMessage()
    {
        // Arrange | Given
        $application = new Application();
        $application->add(new Install());

        $command = $application->find('install');
        $commandTester = new CommandTester($command);

        // Act     | When
        $commandTester->execute(
            array(
                'command' => $command->getName(),
                'package' => 'vdubyna/package',
                '--application-dir' => $this->getApplicationDir(),
                '--package-dir' => $this->getPackageDir(),
            )
        );

        // Assert  | Then
        $this->assertRegExp('/Package installed/', $commandTester->getDisplay());
    }

    public function testWhenInitPackageObjectToManipulate_ShouldReturnPackageObject()
    {
        // Arrange | Given
        $package = $this->getPackage();

        // Act     | When
        // Assert  | Then
        $this->assertInstanceOf('\\Composer\\Modman\\Package', $package);
    }

    public function testWhenGetPackageNameToInstall_ShouldReturnPackageName()
    {
        // Arrange | Given
        $package = $this->getPackage();

        // Act     | When
        // Assert  | Then
        $this->assertEquals('vdubyna/package', $package->getName());
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Package Directory could not be empty
     */
    public function testWhenGetEmptyPackageSourceDir_ShouldReturnException()
    {
        // Arrange | Given
        // Act     | When
        $package = new Package('vdubyna/package', $this->getApplicationDir(), '');
        // Assert  | Then
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage Application Directory could not be empty
     */
    public function testWhenGetEmptyApplicationDirectory_ShouldThrowException()
    {
        // Arrange | Given
        // Act     | When
        $package = new Package('vdubyna/package', '', $this->getPackageDir());
        // Assert  | Then
    }

    public function testWhenGetFilesMapToCopy_ShouldReturnFilesMap()
    {
        // Arrange | Given
        $package = $this->getPackage();

        $expected = array(
            'src/file1.txt' => 'file1.txt',
            'src/app/file1.txt' => 'app/file1.txt',
        );

        // Act     | When
        // Assert  | Then
        $this->assertEquals($expected, $package->getFilesMap());
    }

    /**
     * @expectedException        \Exception
     * @expectedExceptionMessage There is nothing to install
     */
    public function testWhenGetEmptyFilesMapToCopy_ShouldReturnFilesMap()
    {
        // Arrange | Given
        $package = $this->getPackage();
        // Act     | When
        $package->loadFilesMap(__DIR__ . '/fixtures/vendor/vdubyna/package/emptyfilesmap.json');
        // Assert  | Then
    }


    public function testWhenCopyFilesToApplication_ShouldWork()
    {
        // Arrange | Given
        $package = $this->getPackage();
        // Act     | When
        $package->install();
        // Assert  | Then
        $this->assertTrue(file_exists(__DIR__ . '/fixtures/file1.txt'));
        $this->assertTrue(file_exists(__DIR__ . '/fixtures/app/file1.txt'));
    }

    public function tearDown()
    {
        parent::tearDown();

        //@todo mock filesystem
        if (file_exists(__DIR__ . '/fixtures/file1.txt')) {
            unlink(__DIR__ . '/fixtures/file1.txt');
        }
        if (is_dir(__DIR__ . '/fixtures/app')) {
            unlink(__DIR__ . '/fixtures/app/file1.txt');
            rmdir(__DIR__ . '/fixtures/app');
        }
    }


}