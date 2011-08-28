<?php
/**
 * PEAR karma
 */
/*$ADMIN_config['auth_container'] = 'PEAR';
$ADMIN_config['auth'] = array(
    'url'   => 'https://pear.php.net/rest-login.php',
    'karma' => 'pear.planet.admin',
    'karma' => 'pear.dev'
);*/ 

/**
 * Database
 */
$ADMIN_config['auth_container'] = 'MDB2';
$ADMIN_config['auth'] = array(
    'dsn'         => 'mysql://igor:1q2w3e4r@localhost/planet',
    'table'       => 'auth',
    'usernamecol' => 'username',
    'passwordcol' => 'password',
); 
