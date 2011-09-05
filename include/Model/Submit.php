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

        $query = $this->db->prepare(
            'INSERT INTO submissions (rss, name, url, email, description) VALUES (?, ?, ?, ?, ?)',
            array('text', 'text', 'text', 'text', 'text')
        );
        
        $res = $query->execute(array(
            $data['rss'],
            $data['name'],
            $data['url'],
            $data['email'],
            $data['description']
        ));

        if (MDB2::isError($res)) {
            throw new RuntimeException(
                $this->db->getUserInfo(),
                $this->db->getCode()
            );
        }
    }
}
