<?php
/**
 * Planet PHP
 *
 * Site router. Renders controller's action as requested by user.
 *
 * PHP version 5
 *
 * @package    Planet_PHP
 * @author     Till Klampaeckel <till@php.net>
 * @author     Christian Weiske <cweiske@cweiske.de>
 * @author     Igor Feghali <ifeghali@php.net>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://github.com/ifeghali/planet-php/
 */

/**
 * Configuration file.
 */
require_once dirname(dirname(__FILE__)).'/config/config.inc.php';

/**
 * Parse URL
 */
try {
    $m = Net_URL_Mapper::getInstance();

    $m->connect('opml', array('controller' => 'planet', 'action' => 'opml'));
    $m->connect('index', array('controller' => 'planet', 'action' => 'index', 'from' => 0));
    $m->connect('index/:page', array('controller' => 'planet', 'action' => 'page'));
    $m->connect('search/:query', array('controller' => 'planet', 'action' => 'page'));
    $m->connect('submit', array('controller' => 'submit', 'action' => 'index'));
    $m->connect('submit/add', array('controller' => 'submit', 'action' => 'add'));
    $m->connect('admin', array('controller' => 'admin', 'action' => 'index'));
    $m->connect('admin/add', array('controller' => 'admin', 'action' => 'add'));
    $m->connect('admin/promote/:id', array('controller' => 'admin', 'action' => 'promote'));
    $m->connect('admin/delete/:id', array('controller' => 'admin', 'action' => 'delete'));
    $m->connect('admin/delete/:confirm/:id', array('controller' => 'admin', 'action' => 'delete'));
    $m->connect('admin/reject/:id', array('controller' => 'admin', 'action' => 'reject'));
    $m->connect('admin/reject/:confirm/:id', array('controller' => 'admin', 'action' => 'reject'));
    $m->connect('admin/logout', array('controller' => 'admin', 'action' => 'logout'));
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
$cacheFile = BX_TEMP_DIR . '/cache-' . strtolower($cacheName);

if (empty($cacheName)) {

    echo $page = $controller->render();

} else if (!file_exists($cacheFile)
    || PLANET_DEBUG
) {

    echo $page = $controller->render();

    $fp = fopen($cacheFile, 'w');
    if ($fp) {
        fwrite($fp, $page);
        fclose($fp);
    }

} else {

    echo file_get_contents($cacheFile);

}
