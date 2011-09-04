<?php
/**
 * Configuration file.
 */
require_once dirname(dirname(__FILE__)).'/config/config.inc.php';

/**
 * If secred hash is set, password protect feed
 */
if (defined('SECRET_FEED_HASH')) {
    if (SECRET_FEED_HASH != '') {
        if ($_GET['hash'] != SECRET_FEED_HASH) {
            die('Denied.');
        }
    }
}

try {
    $planet  = new PlanetPEAR;
    $results = $planet->getEntries();

    $planetFeed = new PlanetPEAR_Feed($_GET['type']);

    /**
     * Retrieve entries
     */
    foreach ($results as $result) {

        $entry = $planetFeed->createEntry();

        $entry->setTitle($result['title']); 
        $entry->setLink($result['link']);
        $entry->setDescription($result['description']);
        $entry->setGuid($result['guid']);
        $entry->setSource(array(
            'title' => $result['title'],
            'url'   => $result['link'],
        ));

        $planetFeed->addEntry($entry);
    }

    echo $planetFeed;

} catch (Exception $e) {
    die('Feed fail.');
}
