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

  <div class="box">
   <fieldset><legend>Prerequisites</legend>
    <ul>
    <li>You have something unique to say about PHP.</li>
    <li>Your posts are in english.</li>
    <li>It's a personal blog and not a project blog.</li>

    <li>You have a PHP category and an RSS/Atom feed just for that.</li>
    <li>You already made some posts about PHP.</li>
    <li>It's an advantage, if you are a PHP or PEAR developer.</li>
    <li>And please provide a link to an RSS/Atom feed for just your PHP category, Planet PHP readers usually
    don't want to read about your cat :)</li>
    </ul>
    <p>As always, there are exceptions to the rule, just write into
    the textarea below, why you think, we should include your blog :) </p>
   </fieldset>
  </div>

  <div class="box">
   <fieldset><legend>Submit your PHP blog</legend>
    <b>If your site nothing has to do with the programming language PHP, don't fill out the form.</b> We delete all spam.

    <br/><br/>
    <form action="submit/add" method="POST" id="submit">
     <error><?php echo $error;?></error>
     <label for="name">Your name: </label><input id="name" value="" name="name"/><br/>
     <label for="name">Your email: </label><input id="email" value="" name="email"/><br/>

     <label for="url2" class="url2">spamcheck (leave empty): </label><input id="url2" class="url2" name="url2"/>

     <label for="url">Your Blog URL: </label><input id="url" value="" name="url"/><br/>
     <label for="rss">Your RSS/Atom URL:</label><input id="rss" value="" name="rss"/> (to the PHP cat only) <br/>
     Why should your blog be on Planet PHP:<br/> <textarea name="description" id="description" cols="40" rows="10"></textarea><br/>
     <br/>
     <label for="rss">What's the first name of the inventor of PHP?</label><input id="firstname" value="" name="firstname"/> <br/>
     <br/>
     <label for="submit"> </label><input type="submit" value="send"/>
    </form>
   </fieldset>
  </div>
  </div>
 </body>
</html>
