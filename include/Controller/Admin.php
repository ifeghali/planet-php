<?php
class Controller_Admin extends Controller
{
    protected $name     = 'Admin';

    /**
     * Templating engine
     */
    protected $tple     = null;

    /**
     * Auth object
     */
    protected $auth     = null;

    protected function listFeeds()
    {
        $this->tple->setCurrentBlock('feed.entry');
        foreach ($this->Admin->getFeeds() as $feed) {
            $this->tple->setVariable('id', $feed['id']);
            $this->tple->setVariable('link', $feed['link']);
            $this->tple->setVariable('author', $feed['author']);
            $this->tple->parseCurrentBlock('feed.entry');
        }
        $this->tple->parse('feed.list');
    }

    protected function listSubmissions()
    {
        $this->tple->setCurrentBlock('sub.entry');
        foreach ($this->Admin->getSubmissions() as $entry) {
            $this->tple->setVariable('id', $entry['id']);
            $this->tple->setVariable('link', $entry['url']);
            $this->tple->setVariable('author', $entry['name']);
            $this->tple->parseCurrentBlock('sub.entry');
        }
        $this->tple->parse('sub.list');
    }

    public function login()
    {
        $this->tple->loadTemplatefile('admin-login.tpl', true, true);
        $this->tple->setVariable('base_url', PLANET_BASE_URL);
        $this->tple->setVariable('username', htmlspecialchars($this->data['username']));

        return $this->tple->get();
    }

    public function index()
    {
        $this->tple->loadTemplatefile('admin.tpl', true, true);
        $this->tple->setVariable('base_url', PLANET_BASE_URL);

        $this->listFeeds();
        $this->tple->touchBlock('feed.add');

        $this->listSubmissions();

        return $this->tple->get();
    }

    public function logout()
    {
        $this->auth->logout();
        $this->auth->start();

        return $this->index();
    }

    public function addFeed()
    {
        try {
            $this->Admin->addFeedForm($this->data);
        } catch (Exception $e) {
            $this->tple->setVariable('error', $e->getMessage());
        }

        return $this->tple->get();
    }

    public function deleteFeed()
    {
        if (empty($this->data['id'])) {
            return $this->index();
        }

        if (!array_key_exists('confirm', $this->data)
            || $this->data['confirm'] != 'really'
        ) {
            $this->tple->setVariable('id', (int)$this->data['id']);
            $this->tple->parse('feed.delete');
            return $this->tple->get();
        }

        try {
            $this->Admin->deleteFeed((int)$this->data['id']);
        } catch (Exception $e) {
            $this->tple->setVariable('error', $e->getMessage());
        }

        return $this->tple->get();
    }

    public function promote()
    {
        if (!array_key_exists('id', $this->data)
            || empty($this->data['id'])
        ) {
            throw new Exception('Invalid id.');
        }

        $this->Admin->promoteSubmission($this->data['id']);
        $data = $this->Admin->getSubmission($this->data['id']);

        $mailtext = 'Hi

            We\'d like to inform you, that your ' . PROJECT_NAME_HR .' submission for 
            '. $data['url'].' was accepted and should show up in the next
            (max. 30) minutes on ' . PROJECT_URL . '

            Thanks for your submission

            The ' . PROJECT_NAME_HR . ' team.';


        $this->sendMail($data['email'], "Your " . PROJECT_NAME_HR . " submission was accepted", $mailtext);

        return $this->tple->get();
    }

    public function reject()
    {
        if (!empty($this->data['reallyreject']) 
            && !empty($this->data['rejectreason'])
        ) {
            $this->Admin->refuseSubmission($this->data['id']);
            sendMail($this->data['email'],"Your " . PROJECT_NAME_HR . " submission for ". $this->data['url']. " was rejected",$this->data['rejectreason']);
        }

        return $this->tple->get();
    }

    protected function sendMail($to, $subject, $text)
    {
        $header = "From: " . PROJECT_ADMIN_EMAIL . "\r\n";
        mail($to, $subject, $text, $header);
    }

    public function clearCache()
    {
        $path = BX_TEMP_DIR;
        var_dump(exec("find $path -type f -exec rm -f {};"));
    }

    public function render()
    {
        /**
         * Configuration file.
         */
        require_once dirname(dirname(dirname(__FILE__)))
            .'/config/config-admin.inc.php';

        try {
            $this->auth = new Auth(
                $ADMIN_config['auth_container'],
                $ADMIN_config['auth'],
                null,
                false
            );
            $debugObserver = new Log_observer(PEAR_LOG_DEBUG);
            $this->auth->attachLogObserver($debugObvserver);
            $this->auth->start();

            $this->tple = new HTML_Template_IT(
                TEMPLATE_DIR . $GLOBALS['BX_config']['theme']
            );

            if (!$this->auth->checkAuth()) {
                $page = $this->login();
            } else {
                $page = call_user_func(array($this, $this->action));
            }
        } catch (Exception $e) {
            die($e->getMessage());
        }

        return $page;
    }

    public function getCacheName()
    {
        return null;
    }
}
