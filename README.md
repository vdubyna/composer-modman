Composer Modman
===============

It was inspired by modman utility written on PHP and adolpted to use as composer package.

 * Install modules into existed applications
 * Back the changes from the modules to repository
 * It can work with any source while files map exists

Installation
------------

 1. Install `composer` 
 2. Add `vdubyna/composer-modman` package as required, version dev-master
 3. Run tests `phpunit`

CI status
---------

[See more info on Travis CI](https://travis-ci.org/vdubyna/composer-modman)

[![Build Status](https://travis-ci.org/vdubyna/composer-modman.png?branch=master)](undefined)

Usage
-----

See full list of commands

    ./vendor/bin/composer-modman list

Install `package` into `application`

    ./vendor/bin/composer-modman install vdubyna/package
     --application-dir=/absolute/path/to/application
     --package-dir=/absolute/path/to/package

Update `package` from `application`

    ./vendor/bin/composer-modman commit vdubyna/package
     --application-dir=/absolute/path/to/application
     --package-dir=/absolute/path/to/package

Filesmap
--------

Describes how to map files of the `package` into `application`. It should be written in `json` format
and named `filesmap.json`.

Example:

```json
    {
        "src/file1.txt": "file1.txt",
        "src/app/file1.txt": "app/file1.txt"
    }
```


Planned features
----------------

 * Support masks for file names in filesmap
 * Default locations (application|package) for most used applications
 * Validate `filesmap.json`
 * Uninstall package