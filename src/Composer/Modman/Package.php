<?php
/**
 * @author vovikha@gmail.com
 */
namespace Composer\Modman;

class Package
{
    protected $_name;

    protected $_packageDir;

    protected $_filesMap;

    protected $_applicationDir;

    protected $_filesmapName = 'filesmap.json';

    protected $_fsUtil;

    public function __construct($name, $applicationDir,
                                $packageDir, $filesystem)
    {
        $this->setApplicationDir($applicationDir);
        $this->setPackageDir($packageDir);
        $this->setName($name);
        $this->setFsUtil($filesystem);
    }

    /**
     * @param \Symfony\Component\Filesystem\Filesystem $fsUtil
     */
    public function setFsUtil($fsUtil)
    {
        $this->_fsUtil = $fsUtil;
    }

    /**
     * @return \Symfony\Component\Filesystem\Filesystem
     */
    public function getFsUtil()
    {
        return $this->_fsUtil;
    }


    public function setFilesmapName($filesmapName)
    {
        $this->_filesmapName = $filesmapName;
    }

    public function getFilesmapName()
    {
        return $this->_filesmapName;
    }

    public function setApplicationDir($applicationDir)
    {
        if (empty($applicationDir)) {
            throw new \Exception('Application Directory could not be empty');
        }

        $this->_applicationDir = $applicationDir;
    }

    public function getApplicationDir()
    {
        return $this->_applicationDir;
    }

    public function setPackageDir($packageDir)
    {
        if (empty($packageDir)) {
            throw new \Exception('Package Directory could not be empty');
        }

        $this->_packageDir = $packageDir;
    }

    public function getPackageDir()
    {
        return $this->_packageDir;
    }

    public function setFilesMap($filesMap)
    {
        $this->_filesMap = $filesMap;
    }

    public function getFilesMap()
    {
        if (empty($this->_filesMap)) {
            $this->loadFilesMap(
                $this->getPackageDir() . '/' . $this->getFilesmapName()
            );
        }

        return $this->_filesMap;
    }

    public function install()
    {
        $fs = $this->getFsUtil();
        foreach ($this->getFilesMap() as $src => $dest) {
            $fs->copy(
                $this->getPackageDir() . "/$src",
                $this->getApplicationDir() . "/$dest", true
            );
        }
    }

    public function commit()
    {
        $fs = $this->getFsUtil();
        foreach (array_flip($this->getFilesMap()) as $src => $dest) {
            $fs->copy(
                $this->getApplicationDir() . "/$src",
                $this->getPackageDir() . "/$dest", true
            );
        }
    }

    public function setName($name)
    {
        $this->_name = $name;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function loadFilesMap($mapFilename)
    {
        $content  = file_get_contents($mapFilename);
        $filesMap = json_decode($content, true);

        if (empty($filesMap)) {
            throw new \Exception('There is nothing to install');
        }

        $this->setFilesMap($filesMap);
    }
}
