<?php
/**
 * Planet PHP
 *
 * Main controller class
 *
 * PHP version 5
 *
 * @package    Planet_PHP
 * @author     Igor Feghali <ifeghali@php.net>
 * @copyright  2011 The Authors
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://github.com/ifeghali/planet-php/
 */

abstract class Controller
{
    /**
     * Controller name
     */
    protected $name;

    /**
     * Action to render
     */
    protected $action;

    /**
     * User input data
     */
    protected $data;

    /**
     * View template
     */
    protected $template;

    public function __construct()
    {
        $this->loadModel($this->name);
    }

    protected function loadModel($model = null)
    {
        $model_class = "Model_${model}";

        try {
            $obj = new $model_class();
        } catch (Exception $e) {
            die("Database error.");
        }

        $this->$model = $obj;
    }

    public function getCacheName($data = null)
    {
        if (empty($data)) {
            return sprintf(
                '%s-%s',
                $this->name,
                $this->action
            );
        }

        ksort($data);
        $data = implode('-', $data);

        return sprintf(
            '%s-%s-%s',
            $this->name,
            $this->action,
            $data
        );
    }

    public function setAction($action = null)
    {
        $this->action = $action;
    }
    
    public function setData($data = array())
    {
        $this->data = $data;
    }

    public function render()
    {
        ob_start();

        try {
            $viewData = call_user_func(array($this, $this->action));
            extract($viewData);

            $template = sprintf(
                '%s/%s.tpl',
                $GLOBALS['BX_config']['theme'],
                $this->template
            );
            include TEMPLATE_DIR . $template;

        } catch (Exception $e) {
            die("Just come back later.");
        }

        $page = ob_get_contents();
        ob_end_clean();

        return $page;
    }

    protected function redirect($url)
    {
        $url = PLANET_BASE_URL . $url;
        header("location: $url");
        exit;
    }

    protected function sendMail($to, $subject, $text)
    {
        $header = "From: " . PROJECT_ADMIN_EMAIL . "\r\n";

        if (!mail($to, $subject, $text, $header)) {
            throw new Exception('Could not send email.');
        }
    }
}
