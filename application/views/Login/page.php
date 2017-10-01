<h1>HELLO! <?php session_start(); echo $_SESSION['username']?> </h1>
<form name="login" action="/loginprocess" method="post">
  <input type="text" name="username" >
  <input type="password" name="password">
  <input type="submit" value="Submit">
</form> 