<?php
require_once '../../inc/config-admin.php';
require_once '../../inc/config.inc.php';
require_once 'Auth.php';
require_once 'Log.php';
require_once 'Log/observer.php';
require_once 'Validate.php';
require_once 'HTML/Template/IT.php';
require_once 'MDB2.php';
require_once '../../library/PlanetAdmin.php';

function listFeeds(PlanetAdmin $p, HTML_Template_IT $it)
{
    $it->setCurrentBlock('list.entry');
    foreach ($p->getFeeds() as $feed) {
        $it->setVariable('id', $feed['id']);
        $it->setVariable('link', $feed['link']);
        $it->parseCurrentBlock();
    }
}

function loginFunction($username = null, $status = null, &$auth = null)
{
    echo '<form method="post" action="admin.php">';
    echo '<label for="username">PEAR User:</label> <input type="text" name="username" value="' . htmlspecialchars($username) . '"/><br/>';
    echo '<label for="password">Password:</label> <input type="password" name="password"/><br/>';
    echo '<input type="submit" value="Login"/>';
    echo '</form>';
}

$auth = new Auth(
    $ADMIN_config['auth_container'],
    $ADMIN_config['auth'],
    'loginFunction'
);
$auth->start();

$db = MDB2::connect($BX_config['dsn']);
$planet = new PlanetAdmin($db);

$debugObserver = new Log_observer(PEAR_LOG_DEBUG);
$auth->attachLogObserver($debugObvserver);

$it = new HTML_Template_IT(TEMPLATE_DIR.$BX_config['theme']);
$it->loadTemplatefile('admin.tpl', true, true);

if (isset($_GET['logout']) && $auth->checkAuth()) {
    $auth->logout();
    $auth->start();
}

if ($auth->checkAuth()) {
    try {
        if (!empty($_POST['feedurl'])) {
            $planet->addFeedForm($_POST['feedurl']);
        }

        if (!empty($_GET['delete']) && empty($_GET['deleteReally'])) {
            $it->setVariable('id', (int) $_GET['delete']);
            $it->parse('feed.delete');
            $it->show();
            exit;
        }

        if (!empty($_GET['delete']) && !empty($_GET['deleteReally'])) {
            $planet->deleteFeed((int) $_GET['delete']);
        }

        $it->setVariable('error', '');
    } catch (Exception $e) {
        $it->setVariable('error', $e->getMessage());
    }

    listFeeds($planet, $it);
    $it->touchBlock('feed.add');
    $it->show();
}
