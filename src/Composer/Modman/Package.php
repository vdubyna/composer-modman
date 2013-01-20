<?php
/**
 *
 * @author vovikha@gmail.com
 */

namespace Composer\Modman;

/**
 * Manage Package Install|Update
 *
 * @todo Maybe Extract "Package Manager" from the class to follow SOLID principles
 *
 *
 */
class Package
{
    protected $_name;

    protected $_packageDir;

    protected $_filesMap;

    protected $_applicationDir;

    protected $_filesmapName = 'filesmap.json';

    protected $_fsUtil;

    /**
     *
     * @todo Maybe Replace $filesystem with interface
     *
     * @param $name
     * @param $applicationDir
     * @param $packageDir
     * @param \Symfony\Component\Filesystem\Filesystem $filesystem
     */
    public function __construct($name, $applicationDir,
                                $packageDir, $filesystem)
    {
        $this->setApplicationDir($applicationDir);
        $this->setPackageDir($packageDir);
        $this->setName($name);
        $this->setFsUtil($filesystem);
    }

    /**
     * Copy changes from Package to Application
     */
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

    /**
     * Copy changes from Application to Package
     */
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

    /**
     * @param $mapFilename
     * @throws \Exception
     */
    public function loadFilesMap($mapFilename)
    {
        $content  = file_get_contents($mapFilename);
        $filesMap = json_decode($content, true);

        if (empty($filesMap)) {
            throw new \Exception('There is nothing to install');
        }

        $this->setFilesMap($filesMap);
    }

    /**
     * @todo Maybe Replace with interface
     *
     * @param \Symfony\Component\Filesystem\Filesystem $fsUtil
     */
    public function setFsUtil($fsUtil)
    {
        $this->_fsUtil = $fsUtil;
    }

    /**
     * @todo Maybe Replace with interface
     *
     * @return \Symfony\Component\Filesystem\Filesystem
     */
    public function getFsUtil()
    {
        return $this->_fsUtil;
    }

    /**
     * @param $filesmapName
     * @return \Composer\Modman\Package
     */
    public function setFilesmapName($filesmapName)
    {
        $this->_filesmapName = $filesmapName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFilesmapName()
    {
        return $this->_filesmapName;
    }

    /**
     * @todo Replace with own Exception class
     * @todo Maybe move validation to Getter
     *
     * @param $applicationDir
     * @throws \Exception
     * @return \Composer\Modman\Package
     */
    public function setApplicationDir($applicationDir)
    {
        if (empty($applicationDir)) {
            throw new \Exception('Application Directory could not be empty');
        }

        $this->_applicationDir = $applicationDir;

        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationDir()
    {
        return $this->_applicationDir;
    }

    /**
     * @todo Replace with own Exception class
     * @todo Maybe move validation to Getter
     *
     * @param string $packageDir
     * @throws \Exception
     * @return \Composer\Modman\Package
     */
    public function setPackageDir($packageDir)
    {
        if (empty($packageDir)) {
            throw new \Exception('Package Directory could not be empty');
        }

        $this->_packageDir = $packageDir;

        return $this;
    }

    /**
     * @return string
     */
    public function getPackageDir()
    {
        return $this->_packageDir;
    }

    /**
     * Set Files Map
     *
     * @param array $filesMap
     * @return \Composer\Modman\Package
     */
    public function setFilesMap(array $filesMap)
    {
        $this->_filesMap = $filesMap;

        return $this;
    }

    /**
     * Get Files Map
     *
     * @return array
     */
    public function getFilesMap()
    {
        if (empty($this->_filesMap)) {
            $this->loadFilesMap(
                $this->getPackageDir() . '/' . $this->getFilesmapName()
            );
        }

        return $this->_filesMap;
    }

    /**
     * Set Package name
     *
     * @param string $name
     * @return \Composer\Modman\Package
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Get Package name
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
}
