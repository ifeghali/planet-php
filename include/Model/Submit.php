<?php
class Model_Submit extends Model
{
    /**
     * MDB2 object
     */
    protected $db;

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

    public function save($data = null)
    {
        if (empty($data)
            || !is_array($data)
        ) {
            throw new Exception('Invalid data.');
        }

        $this->db->query("set names 'utf8';");
        $query = $this->db->prepare(
            'INSERT INTO submissions (rss, name, url, email, description) VALUES (?, ?, ?, ?, ?)',
            array('text', 'text', 'text', 'text', 'text')
        );
        
        $res = $query->execute(array(
            $this->db->quote($data['rss']),
            $this->db->quote($data['name']),
            $this->db->quote($data['url']),
            $this->db->quote($data['email']),
            $this->db->quote($data['description'])
        ));

        if (MDB2::isError($res)) {
            throw new RuntimeException(
                $this->db->getUserInfo(),
                $this->db->getCode()
            );
        }
    }
}
