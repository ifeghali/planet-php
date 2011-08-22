<?php
// Get configuration
if (!include dirname(__FILE__) . '/../inc/config.inc.php') {
    die("No conf.");
}

$query = (string) @$_GET['resource'];
if (empty($query)) {
    $query = null;
}

header('location: ../themes/'.$BX_config['theme'].'/'.$query);
