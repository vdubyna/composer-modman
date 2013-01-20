<?php
/**
 * @author vovikha@gmail.com
 */
namespace Composer\Modman;

use Symfony\Component\Filesystem\Filesystem;

class Package
{
    protected $name;

    protected $packageDir;

    protected $filesMap;

    protected $applicationDir;

    public function __construct($name, $applicationDir, $packageDir)
    {
        $this->setApplicationDir($applicationDir);
        $this->setPackageDir($packageDir);
        $this->setName($name);
    }

    public function setApplicationDir($applicationDir)
    {
        if (empty($applicationDir)) {
            throw new \Exception('Application Directory could not be empty');
        }

        $this->applicationDir = $applicationDir;
    }

    public function getApplicationDir()
    {
        return $this->applicationDir;
    }

    public function setPackageDir($packageDir)
    {
        if (empty($packageDir)) {
            throw new \Exception('Package Directory could not be empty');
        }

        $this->packageDir = $packageDir;
    }

    public function getPackageDir()
    {
        return $this->packageDir;
    }

    public function setFilesMap($filesMap)
    {
        $this->filesMap = $filesMap;
    }

    public function getFilesMap()
    {
        if (empty($this->filesMap)) {
            $this->loadFilesMap($this->getPackageDir() . '/filesmap.json');
        }

        return $this->filesMap;
    }

    public function install()
    {
        $fs = new Filesystem();
        foreach ($this->getFilesMap() as $src => $dest) {
            $fs->copy(
                $this->getPackageDir() . "/$src",
                $this->getApplicationDir() . "/$dest", true);
        }
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function loadFilesMap($mapFilename)
    {
        $content = file_get_contents($mapFilename);
        $filesMap = json_decode($content, true);

        if (empty($filesMap)) {
            throw new \Exception('There is nothing to install');
        }

        $this->setFilesMap($filesMap);
    }
}
