<?php
/**
 * Configuration file.
 */
require_once dirname(dirname(__FILE__)).'/config/config.inc.php';

$query = (string) @$_GET['r'];
if (empty($query)) {
    $query = null;
}

/**
 * Ok, we get incosistent results from dirname() depending when the script is 
 * hosted at root level or inside a subdir, so we are going to add the slashes 
 * manually
 */
$path = array_filter(explode('/', dirname($_SERVER['SCRIPT_NAME'])));

/**
 * themes folder
 */
$path[] = 'themes';

/**
 * chosen theme
 */
$path[] = $BX_config['theme'];

/**
 * requested file
 */
$path[] = $query;

header('location: '.sprintf(
    '/%s',
    implode('/', $path)
));
