<?php

class PlanetAdmin
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
