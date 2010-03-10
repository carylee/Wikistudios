<?php
$title = "Register";
require_once('../includes/header.php');

if(isset($_POST['username']) && isset($_POST['password']))
{
	$username = $_POST['username'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	$user = new User;
	$user->create($username, $name, $password, $email);
	
}
?>
<h1>Register</h1>
    
   <p>Please enter your details below to register.</p>
    
	<form method="post" action="register.php" name="registerform" id="registerform">
	<fieldset>
		<label for="name">Real Name:</label><input type="text" name="name" id="name" /><br />
		<label for="username">Username:</label><input type="text" name="username" id="username" /><br />
		<label for="password">Password:</label><input type="password" name="password" id="password" /><br />
        <label for="email">Email Address:</label><input type="text" name="email" id="email" /><br />
		<input type="submit" name="register" id="register" value="Register" />
	</fieldset>
	</form>