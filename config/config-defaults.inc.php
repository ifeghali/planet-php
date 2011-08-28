<?php
/**
 * This is a defaults configuration to ease configuration.
 *
 * You should not edit anything in here, just override the constants in
 * config.inc.php instead.
 *
 * @author Till Klampaeckel <till@php.net>
 */

if (!defined('PATH_SEPARATOR')) {
    define('PATH_SEPARATOR', ":");
}
if (!defined('BX_PROJECT_DIR')) {
    define('BX_PROJECT_DIR', dirname(dirname(__FILE__)));
}
if (!defined('BX_VENDOR_DIR')) {
    define('BX_VENDOR_DIR', BX_PROJECT_DIR. '/vendor/');
}
if (!defined('BX_INCLUDE_DIR')) {
    define('BX_INCLUDE_DIR', BX_PROJECT_DIR. '/include/');
}
if (!defined('BX_TEMP_DIR')) {
    define('BX_TEMP_DIR', BX_PROJECT_DIR. '/tmp/');
}
if (!defined('TEMPLATE_DIR')) {
    define('TEMPLATE_DIR', BX_PROJECT_DIR . '/templates/');
}
if (!defined('PLANET_DEBUG')) {
    define('PLANET_DEBUG', 0);
}

// consider commenting this out and move this to php.ini or similar
ini_set('include_path',
    BX_VENDOR_DIR . PATH_SEPARATOR .
    BX_INCLUDE_DIR . PATH_SEPARATOR .
    ini_get('include_path')
);

/////////// MAGPIE RELATED 
if (!defined('VERBOSE')) {
    define('VERBOSE', TRUE);
}
if (!defined('MAGPIE_CACHE_DIR')) {
    define('MAGPIE_CACHE_DIR', BX_PROJECT_DIR . '/tmp/magpie/');
}
if (!defined('MAGPIE_CACHE_AGE')) {
    define('MAGPIE_CACHE_AGE', 1000);
}
if (!defined('MAGPIE_USER_AGENT')) {
    define('MAGPIE_USER_AGENT', PROJECT_NAME . ' Aggregator/0.2 (PHP5) (' . PROJECT_URL . ')');
}

/**
 * Autoloader
 *
 * @return boolean
 */
function autoload($className)
{
    $file = str_replace('_', '/', $className);
    $file .= '.php';

    return require_once $file;
}

spl_autoload_register('autoload');
