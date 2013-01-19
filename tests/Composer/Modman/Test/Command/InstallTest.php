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
 * - Find module source dir
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
                '--composer-dir' => __DIR__ . '/fixtures'
            )
        );

        // Assert  | Then
        $this->assertRegExp('/Package installed/', $commandTester->getDisplay());
    }

    public function testInitPackageObjectToManipulate_ShouldReturnPackageObject()
    {
        // Arrange | Given
        $package = new Package('vdubyna/package');

        // Act     | When
        // Assert  | Then
        $this->assertInstanceOf('\\Composer\\Modman\\Package', $package);
    }

    public function testGetPackageNameToInstall_ShouldReturnPackageName()
    {
        // Arrange | Given
        $package = new Package('vdubyna/package');

        // Act     | When
        // Assert  | Then
        $this->assertEquals('vdubyna/package', $package->getName());
    }

    public function testFindModuleSource_ShouldReturnDirectoryPathToTheModule()
    {
        // Arrange | Given
        $package = new Package('vdubyna/package');

        // Act     | When
        // Assert  | Then
        $this->assertRegExp('/vendor\/vdubyna\/package/', $package->getSourceDirectory());
    }

    public function testFindComposerRootDirectory_ShouldReturnComposerRootDirectory()
    {
        // Arrange | Given
        $package = new Package('vdubyna/package');
        $startDir = __DIR__ . '/fixtures/vendor/composer/modman/src/Composer/Modman/Command';

        // Act     | When
        // Assert  | Then
        $this->assertEquals(__DIR__ . '/fixtures', $package->findComposerDirectory($startDir));
    }

    public function testGetFilesMapToCopy_ShouldReturnFilesMap()
    {
        // Arrange | Given
        $package = new Package('vdubyna/package');
        $package->setSourceDirectory(__DIR__ . '/fixtures/vendor/vdubyna/package');
        $expected = array(
            'src/file1.txt' => 'file1.txt',
            'src/app/file1.txt' => 'app/file1.txt',
        );

        // Act     | When
        // Assert  | Then
        $this->assertEquals($expected, $package->getFilesMap());
    }


    public function testLoadFilesMapToCopy_ShouldReturnFilesMapAsArray()
    {
        // Arrange | Given
        $package = new Package('vdubyna/package');
        $expected = array(
            'src/file1.txt' => 'file1.txt',
            'src/app/file1.txt' => 'app/file1.txt',
        );
        $mapFileName = __DIR__ . '/fixtures/vendor/vdubyna/package/filesmap.json';
        $package->loadFilesMap($mapFileName);
        // Act     | When
        // Assert  | Then
        $this->assertEquals($expected, $package->getFilesMap());

    }

    public function testCopyFilesToApplication_ShouldReturnTrue()
    {
        // Arrange | Given
        $package = new Package('vdubyna/package');
        $package->setSourceDirectory(__DIR__ . '/fixtures/vendor/vdubyna/package');
        $appDir = __DIR__ . '/fixtures';
        // Act     | When
        $package->install($appDir);
        // Assert  | Then
        $this->assertTrue(file_exists($appDir . '/file1.txt'));
        $this->assertTrue(file_exists($appDir . '/app/file1.txt'));
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