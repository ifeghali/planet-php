<?php
// Get configuration
if (!include dirname(__FILE__) . '/../inc/config.inc.php') {
    die("No conf.");
}

$query = (string) @$_GET['r'];
if (empty($query)) {
    $query = null;
}

header('location: '.sprintf(
    '%s%s/%s/%s',
    dirname($_SERVER['SCRIPT_NAME']),
    'themes',
    $BX_config['theme'],
    $query
));
