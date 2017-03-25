<?php
	session_start();
	session_destroy();
	session_start();
?>

<!DOCTYPE html>
<html >
<head>
  	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/styleIndex.css">
</head>

<body> 
<header>

</header>
  <div class="wrapper">
	<div class="container">
		<h1>Welcome</h1>
		
		<form class="form" action="actions/connectionAction.php" method="post">
			<input type="text" placeholder="Username" name="uname">
			<input type="password" placeholder="Password" name="passw">
			<button type="submit" id="login-button" name="member-conn">Login</button>
		</form>
	</div> 
</div> 

</body>
</html>
