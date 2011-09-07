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
   <fieldset><legend>Condições</legend>
    <ul>
    <li>Você tem algo original para dizer sobre o PHP.</li>
    <li>Seu blog está em Português.</li>
    <li>Seu blog é pessoal.</li>

    <li>Você tem uma categoria PHP e um feed RSS/Atom só para ela.</li>
    <li>Você já tem algum conteúdo sobre o PHP.</li>
    <li>Você é membro da comunidade PHP Rio.</li>
    </ul>
    <p>Diga abaixo por que o seu blog é interessante :) </p>
   </fieldset>
  </div>

  <div class="box">
   <fieldset><legend>Sugira seu blog PHP</legend>
    <b>Não preencha o formulário caso o seu blog não tenha nada a ver com a linguagem PHP.</b>

    <br/><br/>
    <form action="submit/add" method="POST" id="submit">
     <error><?php echo $error;?></error>
     <label for="name">Autor: </label><input id="name" value="" name="name"/><br/>
     <label for="name">Email: </label><input id="email" value="" name="email"/><br/>

     <label for="url2" class="url2">spamcheck (deixe em branco): </label><input id="url2" class="url2" name="url2"/>

     <label for="url">Blog URL: </label><input id="url" value="" name="url"/><br/>
     <label for="rss">RSS/Atom URL (PHP):</label><input id="rss" value="" name="rss"/> (to the PHP cat only) <br/>
     Por que o seu blog deveria estar no Planet PHP Rio:<br/> <textarea name="description" id="description" cols="40" rows="10"></textarea><br/>
     <br/>
     <label for="rss">Qual é o primeiro nome do criador do PHP?</label><input id="challenge" value="" name="challenge"/> <br/>
     <br/>
     <label for="submit"> </label><input type="submit" value="enviar"/>
    </form>
   </fieldset>
  </div>
  </div>
 </body>
</html>
