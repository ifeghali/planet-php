<?php
/**
 * Planet PHP
 *
 * Feed Entry model
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
class Model_Feed_Entry extends Model 
{
    protected $data = array(

        //required
        'title' => null,
        'link'  => null,

        // required, only text, no html
        'description' => null,

        // optional
        'guid' => null,

        // optional, original source of the feed entry
        'source' => array(

            // required
            'title' => null,
            'url'   => null,

        )
    );

    public function __construct()
    {
        $this->filter = new Zend_Filter_StripTags;
    }

    public function __call($method, $value)
    {
        $var = str_replace('set', '', strtolower($method));

        $this->data[$var] = $value[0];

        return $this;
    }

    public function setDescription($value)
    {
        if (!$value) {
            $value = '';
        }
        $this->data['description'] = $this->filter->filter($value);
        return $this;
    }

    public function toArray()
    {
        return $this->data;
    }
}

