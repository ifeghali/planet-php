<?php
/**
 * Planet PHP
 *
 * Feed controller 
 *
 * PHP version 5
 *
 * @package    Planet_PHP
 * @author     Till Klampaeckel <till@php.net>
 * @author     Igor Feghali <ifeghali@php.net>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://github.com/ifeghali/planet-php/
 */
class Controller_Feed extends Controller
{
    protected $name = 'Feed';

    public function atom()
    {
        $this->Feed->setType('atom');
        return $this->feed();
    }

    public function rss()
    {
        $this->Feed->setType('rss');
        return $this->feed();
    }

    protected function feed()
    {
        /**
         * If secred hash is set, password protect feed
         */
        if (defined('SECRET_FEED_HASH') &&
            (SECRET_FEED_HASH != '')
        ) {
            if ($this->data['hash'] != SECRET_FEED_HASH) {
                die('Denied.');
            }
        }

        try {
            $this->loadModel('Planet');
            $results = $this->Planet->getEntries();

            /**
             * Retrieve entries
             */
            foreach ($results as $result) {

                $entry = $this->Feed->createEntry();

                $entry->setTitle($result['title']); 
                $entry->setLink($result['link']);
                $entry->setDescription($result['description']);
                $entry->setGuid($result['guid']);
                $entry->setSource(array(
                    'title' => $result['title'],
                    'url'   => $result['link'],
                ));

                $this->Feed->addEntry($entry);
            }

            return (string)$this->Feed;

        } catch (Exception $e) {
            die('Feed fail.');
        }
    }

    public function render()
    {
        try {
            $viewData = call_user_func(array($this, $this->action));
        } catch (Exception $e) {
            die("Just come back later.");
        }

        return $viewData;
    }
}
