<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <base href="<?php echo PLANET_BASE_URL;?>" />
  <title>
   <?php echo PROJECT_NAME_HR; ?>
  </title>
  <link rel="icon" href="theme/favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="theme/favicon.ico" type="image/x-icon" />
  <link href="theme/css/style.css" rel="stylesheet" type="text/css" />
  <link rel="alternate" type="application/rss+xml" title="RSS" href="http://feeds.feedburner.com/planetphprio-rss" />
  <link rel="alternate" type="application/atom+xml" title="Atom" href="http://feeds.feedburner.com/planetphprio-atom" />
  <link rel="outline" type="text/x-opml" title="OPML Feed list" href="opml/" />
  <link rel="search" type="application/opensearchdescription+xml" title="<?php echo PROJECT_NAME_HR; ?> search" href="opensearch.xml" />
 </head>
 <body>
  <div id="head">
   <h1><a href="/">planet phprio</a></h1>
   <!--<a href="" class="caption"></a>-->
   <div id="topnavi">
    Todas as novidades em um só lugar
   </div>
  </div>

  <div id="middlecontent">

<?php foreach ($entries as $entry): ?>
   <div class="box">
    <fieldset>
     <legend><a href="<?php echo $entry['blog_link']; ?>"><?php echo $entry['blog_author']; ?></a></legend>
     <a href="<?php echo $entry['link']; ?>" class="blogTitle"><?php echo $entry['title']; ?></a>
     (<?php echo $entry['dc_date']; ?>)
     <div class="feedcontent">
      <p>
        <?php
        if (!empty($entry['content_encoded'])) {
          echo $entry['content_encoded'];
        } else {
          echo $entry['description'];
        }
        ?>
      </p>

     </div><a href="<?php echo $entry['link']; ?>">Link</a>
    </fieldset>
   </div>
<?php endforeach; ?>

   <div id="pageNavi">

<?php if ($nav['next'] !== null || $nav['prev'] !== null): ?>

    <fieldset>
     <legend>More Entries</legend>
<?php if ($nav['next'] !== null): ?>
<span style="float: right;"><a href="/index/<?php echo $nav['next']; ?>">Next 10 Older Entries</a></span>
<?php endif; ?>
<?php if ($nav['prev'] !== null): ?>
<span style="float: left;"><a href="/index/<?php echo $nav['prev']; ?>">Previous 10 Newer Entries</a></span>
<?php endif; ?>

<br />
    </fieldset>

<?php endif; ?>

   </div>
  </div>
  <div id="rightcol">

   <div class="menu">
    <fieldset>
     <legend>Busque aqui</legend>
     <form onsubmit="niceURL(); return false;" name="search" method="get" action="/" id="search">
      <input id="searchtext" type="text" name="search" /><input class="submit" type="submit" value="Go" />
     </form><a id="searchbarLink" href="javascript:addEngine()" name="searchbarLink">Mozilla Searchbar</a>
    </fieldset>
   </div>

   <div class="menu">
    <fieldset>
     <legend><a href="opml/">Blogs</a></legend>
    <?php foreach ($blogs as $blog): ?>
    <a href="<?php echo $blog['link']; ?>" class="blogLinkPad"><?php echo $blog['author']; ?></a>
    <?php endforeach; ?>
    </fieldset>
   </div>
   <div class="buttons">

    <fieldset>
     <legend>Links</legend>
     <a href="http://feeds.feedburner.com/planetphprio-rss"><img border="0" alt="RDF 1." src="images/rss1.gif" width="80" height="15" /></a>
     <a href="http://feeds.feedburner.com/planetphprio-atom"><img border="0" alt="Atom Feed" src="images/atompixel.png" width="80" height="15" /></a><br />
     <a href="http://www.php.net/"><img border="0" alt="PHP5 powered" src="images/phppowered.png" width="80" height="15" /></a>
     <a href="http://pear.php.net/"><img alt="PEAR" border="0" src="images/pearpowered.png" width="80" height="15" /></a>
    </fieldset>

   </div>
   <div class="menu">
    <fieldset>
     <legend>Planetarium</legend>
     <a class="blogLinkPad" href="http://drupal.org/planet/">Drupal</a>
     <a class="blogLinkPad" href="http://www.planetmysql.org/">MySQL</a>
     <a class="blogLinkPad" href="http://planet-php.org/">PHP</a>
     <a class="blogLinkPad" href="http://planet-pear.org/">PEAR</a>
    </fieldset>
   </div>
   <div class="buttons">

    <fieldset>
     <legend>Divulgue</legend> <code>&lt;a href="http://planet.phprio.org/"&gt;Planet PHP Rio&lt;/a&gt;</code>
    </fieldset>
   </div>
   <div class="menu">
    <fieldset>
     <legend>Melhore</legend>
     <!--<a class="blogLinkPad" href="http://blog.liip.ch/archive/2005/05/26/planet-php-faq.html">Planet PHP FAQ</a>-->
     <a class="blogLinkPad" href="submit/">Sugira um Blog PHP</a>
     <a class="blogLinkPad" href="http://github.com/ifeghali/planet-php/">Código Fonte</a>
     <a class="blogLinkPad" href="ma&#105;&#108;t&#111;&#58;%69f&#101;&#103;&#104;&#97;l%69&#64;p&#104;p&#114;i&#111;%&#50;E&#111;&#37;72&#37;67">Contato</a>
    </fieldset>
   </div>
   <div class="menu">
    <fieldset>
     <legend>Créditos</legend>
     <div class="nnbe">
       <strong>Código:</strong>
         Christian Stocker,
         Christian Weiske,
         Till Klampaeckel,
         Igor Feghali.
       <br/>
       <strong>Conteúdo:</strong> Comunidade PHP Rio.
      </div>
    </fieldset>
   </div>
  </div><script language="JavaScript" src="js/search.js" type="text/javascript">
</script>
 </body>
</html>
