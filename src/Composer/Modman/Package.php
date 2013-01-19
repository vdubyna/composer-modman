<?php
/**
 * @author vovikha@gmail.com
 */
namespace Composer\Modman;

class Package
{
    protected $name;

    protected $sourceDirectory;

    protected $filesMap;

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
            $this->sourceDirectory = $this->findComposerDirectory(__DIR__) . '/vendor/' . $this->getName();
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
