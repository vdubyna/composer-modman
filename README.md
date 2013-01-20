Composer helper
===============

It is created to extend composer functionality. 

 * Install modules into existed applications
 * Back the changes from the modules to repository

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

Planned features
----------------

 * Support masks for file names in filesmap
 * Default locations (application|package) for most used applications