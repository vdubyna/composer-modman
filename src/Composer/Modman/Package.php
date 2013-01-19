<?php
/**
 * @author vovikha@gmail.com
 */
namespace Composer\Modman;

use Symfony\Component\Filesystem\Filesystem;

class Package
{
    protected $name;

    protected $sourceDirectory;

    protected $filesMap;

    protected $composerDir;

    public function setComposerDir($composerDir)
    {
        $this->composerDir = $composerDir;
    }

    public function getComposerDir()
    {
        return $this->composerDir;
    }

    public function setFilesMap($filesMap)
    {
        $this->filesMap = $filesMap;
    }

    public function getFilesMap()
    {
        if (empty($this->filesMap)) {
            $this->loadFilesMap($this->getSourceDirectory() . '/filesmap.json');
        }

        return $this->filesMap;
    }

    public function setSourceDirectory($sourceDirectory)
    {
        $this->sourceDirectory = $sourceDirectory;
    }

    public function getSourceDirectory()
    {
        if (empty($this->sourceDirectory)) {
            $this->sourceDirectory = $this->getComposerDir() . '/vendor/' . $this->getName();
        }

        return $this->sourceDirectory;
    }

    public function findComposerDirectory($startDir)
    {
        while ($startDir != '/') {
            if (file_exists($startDir . '/composer.json') && basename($startDir) != 'modman') {
                return $startDir;
            } else {
                $startDir = dirname($startDir);
            }
        }
    }

    public function install($applicationDirectory)
    {
        $fs = new Filesystem();
        foreach ($this->getFilesMap() as $src => $dest) {
            $fs->copy($this->getSourceDirectory() . "/$src", "$applicationDirectory/$dest", true);
        }

        return true;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }


    public function __construct($name)
    {
        $this->name = $name;
    }

    public function loadFilesMap($mapFilename)
    {
        $content = file_get_contents($mapFilename);

        $this->setFilesMap(json_decode($content, true));
    }
}
