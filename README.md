PLANET PHP
==========

This is planet-php, a web interface with feed aggregation functionalities.


PREREQUISITES
-------------

PHP Dependencies

* PHP 5
* A database (only tested with mysql, but should work with others, too)

PEAR Packages

* Auth
* HTML_Template_IT
* MDB2
* Cache
* Net_URL_Mapper

Others

* Zend Framework (Zend/Filter/StripTags.php)


INSTALLATION
------------

Get the latest code from GitHub

    $ git clone git://github.com/ifeghali/planet-php.git

Adjust the DSN parameter (and other config options if you want)

    $ cp config/config.inc.php-dist config/config.inc.php

Make tmp directory writeable for the webserver

Import the DB from config/database.sql (this is a dump from mysql)

    $ mysql < config/database.sql

Add a privileged user (for database authentication only)

    $ echo 'insert into auth values ("admin", md5("pwd"));' | mysql planet


ADMINISTRATION
--------------

Create the admin config file

    $ cp config/config-admin.inc.php-dist config/config-admin.inc.php

If you want to authenticate via database, adjust the DSN

If you want to authenticate via PEAR, comment out the second block
    of code. Uncomment the first block of code.

If everything went fine, you can now login to PLANET-URL/admin/

Create new feeds using the admin interface

To load contents

    $ ./scripts/aggregate.php

Or you can automate the import proccess with a cronjob

    */5 * * * * /path/to/php-cli /path/to/planet-code/scripts/aggregate.php

