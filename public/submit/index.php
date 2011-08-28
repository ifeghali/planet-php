<?php
/**
 * Configuration file.
 */
require_once dirname(dirname(dirname(__FILE__))).'/config/config.inc.php';

$dom = new domdocument();
$xsl = new domdocument();
$xsl->load("../themes/planet-php/static.xsl");


$xslt = new xsltprocessor();
$xslt->registerPHPFunctions();


$xslt->importStylesheet($xsl);

if (!empty($_POST['url2'])) {
    die("You look like a spammer...");
}

$spam = false;
if ( !empty($_POST['name']) &&  !empty($_POST['firstname']) && !empty($_POST['url']) && !empty($_POST['description'])) {

    foreach($_POST as $key => $value) {
        $_POST[$key] = trim($value);
    }

    if ($_POST['rss'] == $_POST['url']) {
        $spam = 1;
    } else if ( $_POST['rss'] == '') {
        $spam = 1  ;
    } else if ( strpos($_POST['rss'],'http://') !== 0) {
        $spam = 1  ;
    } else if ( strpos($_POST['url'],'<') !== false) {
        $spam = 1  ;
    } else if ( strpos($_POST['rss'],'<') !== false) {
        $spam = 1  ;
    } else if ( strtolower($_POST['firstname']) != 'rasmus') {
        $spam = 2  ;
    }

    $header = "From: ".$_POST['name']." <".$_POST['email'].">";
    if (strpos($header, "\n") !== FALSE or strpos($header, "\r") !== FALSE) {
       die("From is invalid.");
    }

    if (!$spam) {
        $db = MDB2::connect($BX_config['dsn']);
        $db->query("set names 'utf8';");

        $query = "insert into submissions (rss,name,url,email,description) values (";
        $query .= $db->quote($_POST['rss']) .",";
        $query .= $db->quote($_POST['name']) .",";
        $query .= $db->quote($_POST['url']) .",";
        $query .= $db->quote($_POST['email']) .",";
        $query .= $db->quote($_POST['description']) .")";
        $res = $db->query($query);
    }
    $mailtext='New ' . PROJECT_NAME_HR . ' Submission:

Name: '. $_POST['name'].'
URL: '. $_POST['url'].'
RSS: '. $_POST['rss'].'
Email: '. $_POST['email'].'
Name of Inventor: '. $_POST['firstname'].'
IP: '. $_SERVER['REMOTE_ADDR'].'
UA: '. $_SERVER['HTTP_USER_AGENT'].'

Description: '. $_POST['description'].'

Please accept or reject it here:
' . PROJECT_URL . '/submit/admin/
        ';

    if ($spam == 1) {
    } else if ($spam == 2) {
        mail(PROJECT_ADMIN_EMAIL, "[" . PROJECT_NAME_HR . "] (Rejected) New submission for ". $_POST['url'], $mailtext,$header);
    } else {
        //mail("chregu@liip.ch","New Planet PHP submission for ". $_POST['url'], $mailtext,$header);
        mail(PROJECT_ADMIN_URL, "[" . PROJECT_NAME_HR . "] New submission for ". $_POST['url'], $mailtext,$header);
    }

    if ($db && $db->isError($res)) {
        print "An Error happened";
        print $res->getUserInfo();
        die();
    } else {
        $dom->load("thanks.xml");
    }

} else {
    if (count($_POST) > 0 ) {
        $xslt->setParameter("","error","Please fill in all fields");
    }
    $dom->load("form.xml");
}

print ($xslt->transformToXml($dom));

/**
 * @todo ext/filter
 */
function getPostValue($name) {

    if (!empty($_POST[$name])) {
        return $_POST[$name];
    }
    return "";
}
