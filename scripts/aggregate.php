#!/usr/bin/env php
<?php
/**
 * Configuration file.
 */
require_once dirname(dirname(__FILE__)).'/config/config.inc.php';

/**
 * Sleep if machine load is too high
 */
while (getLoad() > 7) {
    print "load > 7. wait 20 sec. \n";
    sleep(20);
}

/**
 * Check if we are going to update one blog or all of them
 */
$blogId = null;
if (isset($argv[1]) || !empty($argv[1])) {
    $blogId = (int) $argv[1];
    if ($blogId === 0) {
        echo "Usage ./aggregate.php <int>\n";
        exit(1);
    }
}

$agg = new Aggregator();

/**
 * do the magic
 */
$agg->aggregateAllBlogs($blogId);
if ($agg->isNew() === true) {
    foreach (glob(BX_TEMP_DIR . 'Planet-*') as $file) {
        unlink($file);
    }
}

/* disable hub notify **********************************************************
$noti = new lx_notifier();

$url = "http://www.planet-php.net/";
$topicurls = array(
        $url . 'atom/',
);

$hubs = array("http://pubsubhubbub.appspot.com");
$noti->addPubSubHubs($topicurls, $hubs);
$noti->notifyAll();
*******************************************************************************/

/**
 * This doesn't work if your system doesn't have /proc.
 *
 * @return int
 */
function getLoad() {
    return 0;
    return substr(file_get_contents("/proc/loadavg"),0,4);
}
