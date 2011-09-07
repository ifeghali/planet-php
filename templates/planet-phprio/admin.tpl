<?xml version="1.0" encoding="utf-8" ?>
<html>
 <head>
  <title>Planet administration</title>
  <base href="{base_url}" />
 </head>
 <body>
<h1>mi casa es su casa</h1>
<p class="error">{error}</p>
<!-- BEGIN feed.list -->
<table class="feedlist" border="1">
     <caption>Existing feeds</caption>
     <!-- BEGIN feed.entry -->
     <tr><td>{id}</td><td>{link}</td><td>{author}</td><td><a href="admin/delete/{id}">delete</a></td></tr>
     <!-- END feed.entry -->
</table>
<p/>
<!-- END feed.list -->
<!-- BEGIN sub.list -->
<table class="feedlist" border="1">
     <caption>Pending Feeds</caption>
     <!-- BEGIN sub.entry -->
     <tr><td>{id}</td><td>{link}</td><td>{author}</td>
     <td><a href="admin/promote/{id}">accept</a></td>
     <td><a href="admin/reject/{id}">reject</a></td>
     </tr>
     <!-- END sub.entry -->
</table>
<p/>
<!-- END sub.list -->
<!-- BEGIN sub.reject -->
<fieldset class="deletefeed"><legend>Reject submission</legend>
<p>Do you really want to reject submission #{id}?</p>
<p><a href="admin/reject/really/{id}">yes</a>
<a href="admin/">no</a></p>
</fieldset>
<!-- END sub.reject -->
<!-- BEGIN feed.delete -->
<fieldset class="deletefeed"><legend>Delete a feed</legend>
<p>Do you really want to delete feed #{id}?</p>
<p><a href="admin/delete/really/{id}">yes</a>
<a href="admin/">no</a></p>
</fieldset>
<!-- END feed.delete -->
<!-- BEGIN feed.add -->
<form method="post" action="admin/add">
    <fieldset class="addfeed">
        <legend>Add a feed</legend>
        <label for="url">Feed URL:</label>
        <input type="text" name="url" value=""/>
        <br/>
        <label for="author">Author:</label>
        <input type="text" name="author" value=""/>
        <br/>
        <input type="submit" value="Submit"/>
    </fieldset>
</form>
<!-- END feed.add -->
<p><a href="admin/logout/">logout</a></p>
</body>
</html>
