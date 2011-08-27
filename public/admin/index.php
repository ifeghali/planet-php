<?php
require_once '../../inc/config-admin.php';
require_once '../../inc/config.inc.php';
require_once 'Auth.php';
require_once 'Log.php';
require_once 'Log/observer.php';
require_once 'Validate.php';
require_once 'HTML/Template/IT.php';
require_once 'MDB2.php';

class Planet
{
	protected $_db;
	
	public function __construct($db = null) 
	{
		$this->_db = $db;
	}

	protected function _validateRss($url) 
	{
		$xml = new DomDocument();
		if(!@$xml->load($url)) 
			return false;
		return true;
	}

	public function addFeedForm($url) 
	{
		if (empty($url)) {
			throw new Exception('Empty URL');
		}

		$options = array(
			'allowed_schemes' => array('http', 'https'),
			'strict' => ''
		);
		if (!Validate::uri($url, $options)) {
			throw new Exception('Invalid URL');
		}
				
		if (!($fp = fopen($url, "r"))) {
			throw new Exception('URL not found');
		}
		fclose($fp);

		if (!$this->_validateRss($url)) {
			throw new Exception('Invalid RSS');
		}
		
		$stmt = $this->_db->prepare('INSERT INTO feeds SET link = ?', array('text'));
		return $stmt->execute($url);
	}

	public function getFeeds() 
	{
		$results = array();
		$stmt    = $this->_db->query("SELECT id, link FROM feeds ORDER BY ID");

		while ($row = $stmt->fetchRow(MDB2_FETCHMODE_ASSOC))
		{
			$results[] = $row;
		}

		return $results;
	}

	public function deleteFeed($id)
	{
		if (empty($id)) {
			throw new Exception('Cannot delete an empty id');
		}
		
		$stmt = $this->_db->prepare('DELETE FROM feeds WHERE ID = ?', array('integer'));
		return $stmt->execute($id);
	}
}

function listFeeds(Planet $p, HTML_Template_IT $it)
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
$planet = new Planet($db);

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
