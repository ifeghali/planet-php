<?php
/**
 * Configuration file.
 */
require_once dirname(dirname(__FILE__)).'/config/config.inc.php';

// Init Router
try {
    $m = Net_URL_Mapper::getInstance();

    $m->connect('opml', array('controller' => 'planet', 'action' => 'opml'));
    $m->connect('index', array('controller' => 'planet', 'action' => 'index', 'from' => 0));
    $m->connect('index/:page', array('controller' => 'planet', 'action' => 'page'));
    $m->connect('search/:query', array('controller' => 'planet', 'action' => 'page'));
    $m->connect('submit', array('controller' => 'submit', 'action' => 'index'));
    $m->connect('submit/add', array('controller' => 'submit', 'action' => 'add'));
    $m->connect('admin', array('controller' => 'admin', 'action' => 'index'));
    $m->connect('atom', array('controller' => 'feed', 'action' => 'atom'));
    $m->connect('atom/:hash', array('controller' => 'feed', 'action' => 'atom'));
    $m->connect('rss', array('controller' => 'feed', 'action' => 'rss'));
    $m->connect('rss/:hash', array('controller' => 'feed', 'action' => 'rss'));

    $route = $m->match($_SERVER['REQUEST_URI']);
} catch (Net_URL_Mapper_Exception $e) {
    die("Something went wrong.");
}

if ($route === null) {
    $route = array('controller' => 'planet', 'action' => 'index');
}

$c          = "Controller_".ucfirst(strtolower($route['controller']));
$controller = new $c();

$controller->setAction(strtolower($route['action']));
$controller->setData(array_merge(
    array_diff_key(
        $route,
        array('controller' => null, 'action' => null)
    ),
    $_POST
));

$cacheName = $controller->getCacheName();
$cacheFile = BX_TEMP_DIR . '/' . $cacheName;

if (empty($cacheName)
    || !file_exists($cacheFile)
    || PLANET_DEBUG
) {

    echo $page =$controller->render();

    $fp = fopen($cacheFile, 'w');
    if ($fp) {
        fwrite($fp, $page);
        fclose($fp);
    }

} else {

    echo file_get_contents($cacheFile);

}
