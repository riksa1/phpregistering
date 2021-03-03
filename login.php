<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Kirjautumis sivu</title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <div class="header">
  	<h2>Kirjaudu</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Käyttäjänimi</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Salasana</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Kirjaudu</button>
  	</div>
  	<p>
  		Et ole käyttäjä? <a href="register.php">Registeröi</a>
  	</p>
  </form>
</body>
</html>