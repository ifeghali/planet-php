<?xml version="1.0" encoding="utf-8" ?>
<html>
 <head>
  <title>Planet administration</title>
  <base href="{base_url}" />
 </head>
 <body>
  <form action="admin/" method="post">
   <label for="username">User:</label>
   <input type="text" name="username" value="{username}"/><br/>
   <label for="password">Password:</label>
   <input type="password" name="password"/><br/>
   <input type="submit" value="Login"/>
  </form>
 </body>
</html>
