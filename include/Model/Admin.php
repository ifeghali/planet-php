<?php
class Model_Admin extends Model
{
    protected $db;

    /**
     * @param MDB2_Common $db Optional MDB2 object.
     *
     * @return $this
     */
    public function __construct(MDB2_Common $db = null)
    {
        if ($db !== null) {
            $this->db = $db;
        } else {
            $this->db = MDB2::connect($GLOBALS['BX_config']['dsn']);
        }

        if (MDB2::isError($this->db)) {
            throw new RuntimeException(
                $this->db->getUserInfo(),
                $this->db->getCode()
            );
        }
    }

    protected function _validateRss($url) 
    {
        $xml = new DomDocument();
        if(!@$xml->load($url)) 
            return false;
        return true;
    }

    public function addFeed($post) 
    {
        /**
         * FIXME: this is probably not safe
         */
        extract($post);

        if (empty($url)) {
            throw new Exception('Empty URL');
        }

        if (empty($author)) {
            throw new Exception('Empty author');
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

        $stmt = $this->db->prepare(
            'INSERT INTO feeds SET link = ?, author = ?',
            array('text', 'text')
        );
        return $stmt->execute(array($url, $author));
    }

    public function getFeeds() 
    {
        $results = array();
        $stmt    = $this->db->query("SELECT id, link, author FROM feeds ORDER BY ID");

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

        $stmt = $this->db->prepare('DELETE FROM feeds WHERE ID = ?', array('integer'));
        return $stmt->execute($id);
    }

    public function getSubmissions()
    {
        $results = array();
        $stmt    = $this->db->query("SELECT * FROM submissions WHERE state = 0");

        while ($row = $stmt->fetchRow(MDB2_FETCHMODE_ASSOC))
        {
            $results[] = $row;
        }

        return $results;
    }

    public function getSubmission($id = null)
    {
        $id   = $this->db->quote($id);
        $stmt = $this->db->query("SELECT * FROM submissions WHERE id = $id");
        $res  = $stmt->fetchRow(MDB2_FETCHMODE_ASSOC);

        if ($this->db->isError($res)) {
            die("a DB errror happened: " . $res->getUserInfo());
        }

        return $res;
    }

    protected function flagSubmission($id, $state) {

        $stmt = $this->db->prepare(
            'UPDATE submissions set STATE = ? WHERE id = ?',
            array('integer', 'integer')
        );

        $res = $stmt->execute(array($state, $id));
        if ($this->db->isError($res)) {
            die("a DB errror happened: " . $res->getUserInfo());
        }

    }

    public function promoteSubmission($id) {

        $entry = $this->getSubmission($id);

        if ($entry['state'] !== '0') {
            die("There is no pending request #$id");
        }

        $data  = array(
            'url'    => $entry['rss'],
            'author' => $entry['name']
        );

        $this->addFeed($data);
        $this->flagSubmission($id, 1);
    }

    public function rejectSubmission($id) {

        $entry = $this->getSubmission($id);

        if ($entry['state'] !== '0') {
            die("There is no pending request #$id");
        }

        $this->flagSubmission($id, -1);
    }
}
