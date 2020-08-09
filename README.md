AACRG
------------

[African amphibian conservation group](http://natural-sciences.nwu.ac.za/african-amphibian-conservation-research-group/aacrg-about) developed this application for managing parasitological collection for its own needs. The [demo site](http://syrota.info/wormbase/) is available:

    [http://syrota.info/wormbase/](http://syrota.info/wormbase/)

Requirements
------------

The application tested on Apache 2.4 server with PHP 7.2 and MariaDB 10.0.

Instalation
-----------
1. Download the code
2. Run <i>composer update</i> in <path to folder with site files>/yii
3.  Import database from <path to the folder with site files>/yii/sql/data_base.sql
4.Configure access of the application to your database:  <path to the folder with site files>/yii/common/config

            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=<...>',
            'username' => '<...>',
            'password' => '<...>',
            'charset' => 'utf8',
        
5. Login in application (username = root, password = 111111)


Disclaimer
------------
THE CODE OF THIS APPLICATION IS DISTRIBUTING AS IS, WITHOUT ANY WARRANTY OF ANY KIND.
