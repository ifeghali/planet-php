<?php
/**
 * @author Till Klampaeckel <till@php.net>
 */
class Controller_Planet extends Controller
{
    protected $name = 'Planet';

    public function index()
    {
        $this->setData(array(
            'page'  => 0,
            'query' => null
        ));
        return $this->page();
    }

    /**
     * page action
     *
     * @param int    $from  The start key.
     * @param string $query Search query.
     *
     * @return array
     */
    public function page()
    {
        $data = array_merge(
            array(
                'page'  => 0,
                'query' => null
            ),
            $this->data
        );
        extract($data);

        $return = array();
        $return['blogs']     = $this->Planet->getBlogs();
        $return['BX_config'] = $GLOBALS['BX_config'];

        if (empty($query)) {
            $query = null;
            $return['nav'] = $this->Planet->getNavigation($page);
        } else {
            $return['nav'] = array('prev' => null, 'next' => null);
        }

        $return['entries'] = $this->Planet->getEntries(
            'default', $page, $query
        );

        return $return;
    }

    public function search()
    {
        return $this->page();
    }

    /**
     * List OPML feed
     *
     * @return void
     */
    public function opml()
    {
        header('Content-Type: text/x-opml');
        header('Content-Type: text/xml');
        $project = PROJECT_NAME_HR;
        $title   = PROJECT_NAME_HR . ' feed list';
        $created = date('r');
        echo <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<opml version="2.0">
 <head>
  <title>{$title}</title>
  <dateCreated>{$created}</dateCreated>
 </head>
 <body>
XML;
        foreach ($this->Planet->getFeeds('default') as $data) {
            echo '<outline type="rss" text="'
                . htmlspecialchars($data['title'])
                . '" htmlUrl="'
                . htmlspecialchars($data['blogurl'])
                . '" xmlUrl="'
                . htmlspecialchars($data['feedurl'])
                . '" />' . "\n";
        }
        echo <<< XML
 </body>
</opml>
XML;
        exit(0);
    }

    public function setData($data = array())
    {
        if (array_key_exists('query', $data)) {
            $data['query'] = trim($data['query']);
        }
        if (array_key_exists('page', $data)) {
            $data['page'] = (int)($data['page']);
        }
        
        $this->data = $data;
    }

    public function getCacheName()
    {
        $data = $this->data;

        if (array_key_exists('query', $data)) {
            $data['query'] = md5($data['query']);
        }

        return parent::getCacheName($data);
    }
}
