<?php
/**
 * Planet PHP
 *
 * Submit controller
 *
 * PHP version 5
 *
 * @package    Planet_PHP
 * @author     Christian Stocker <me@chregu.tv>
 * @author     Till Klampaeckel <till@php.net>
 * @author     Igor Feghali <ifeghali@php.net>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://github.com/ifeghali/planet-php/
 */
class Controller_Submit extends Controller
{
    protected $name     = 'Submit';
    protected $template = 'submit';

    public function index()
    {
        return array();
    }

    public function add()
    {
        if (empty($this->data['name'])
            || empty($this->data['challenge'])
            || empty($this->data['url'])
            || empty($this->data['description'])
        ) {
            if (count($this->data) > 0) {
                return array('error' => 'Please fill in all fields');
            }

            return array();
        }

        if ($this->data['rss'] == $this->data['url']
            || $this->data['rss'] == '' 
            || strpos($this->data['rss'],'http://') !== 0
            || strpos($this->data['url'],'<') !== false
            || strpos($this->data['rss'],'<') !== false 
            || strtolower($this->data['challenge']) != 'rasmus'
            || !empty($this->data['url2'])
        ) {
            die('You look like a spammer...');
        }

        foreach($this->data as $key => $value) {
            $this->data[$key] = trim($value);
        }

        try {
            $this->Submit->save($this->data);
        } catch (RuntimeException $e) {
            die('Database error.');
        }

        $header   = "From: {$this->data['name']} <{$this->data['email']}>\r\n";
        $mailtext = 'New ' . PROJECT_NAME_HR . ' Submission:

            Name: '. $this->data['name'].'
            URL: '. $this->data['url'].'
            RSS: '. $this->data['rss'].'
            Email: '. $this->data['email'].'
            IP: '. $_SERVER['REMOTE_ADDR'].'
            UA: '. $_SERVER['HTTP_USER_AGENT'].'

            Description: '. $this->data['description'].'

            Please accept or reject it here:
            ' . PROJECT_URL . '/admin/
            ';

        mail(
            PROJECT_ADMIN_EMAIL,
            "[" . PROJECT_NAME_HR . "] New submission",
            $mailtext,
            $header
        );

        $this->template = 'submit-thanks';
        return array();
    }
}
