<?php
// Title sets what comes in the title after WikiStudios
$title = "User Page";
$skiphtml = TRUE;
// Require the header file
require_once('../includes/header.php');

$HTML = new HTMLObject;
$stylesheet[] = '/styles/styletest.css';
$HTML->htmlheader($title, $stylesheet);
$HTML->topnav();
// I found some help for this at http://nettuts.com/tutorials/php/user-membership-with-php/
// I modified the code, but went with the basic structure
// This is the first time I've dealt with a user login


if(isset($_SESSION['LoggedIn']) && isset($_SESSION['current_user']))
{
	$user = unserialize($_SESSION['current_user']);
	if ($_GET['action']=='logout') {
		$user->logout();
		echo "you are now logged out";
		//echo "<meta http-equiv='refresh' content='=2;login.php' />";
		
	}
	else {
	//	echo "WHAT?";
	$url = $user->getAuthSubRequestUrl();
	echo "<p><a href=\"$url\">Authorize Youtube</a></p>\n";
	$yt = $user->make_auth_yt();
	 ?>
	
	<div id='bodycontent'>
	 <h1>Member Area</h1>
     <p>Thanks for logging in! You are <b><?= $user->name ?></b> and your email address is <b><?= $user->email ?></b>.</p>
	<a href="login.php?action=logout">Logout?</a>


     
     <?php
	}
}
elseif(isset($_POST['username']) && isset($_POST['password']))
{
	$username = ($_POST['username']);
    $password = ($_POST['password']);
	
	if(isset($user))
		echo $user->name;
	
	$user = new User;
	$user->login($username, $password);
	
	if($_SESSION['LoggedIn']==1){
		echo "<h1>Success</h1>";
        echo "<p>We are now redirecting you to the member area.</p>";
        echo "<meta http-equiv='refresh' content='=2;login.php' />";
	}
    else {
		echo "<h1>Error</h1>";
	    echo "<p>Sorry, your account could not be found. Please <a href=\"login.php\">click here to try again</a>.</p>";
	}
}

else
{
	?>
    
   <h1>Member Login</h1>
    
   <p>Thanks for visiting! Please either login below, or <a href="register_oop.php">click here to register</a>.</p>
    
	<form method="post" action="login.php" name="loginform" id="loginform">
	<fieldset>
		<label for="username">Username:</label><input type="text" name="username" id="username" /><br />
		<label for="password">Password:</label><input type="password" name="password" id="password" /><br />
		<input type="submit" name="login" id="login" value="Login" />
	</fieldset>
	</form>
    </div>
   <?php
}
// After the header is included, other requires and includes can use the global definitions
$HTML->footer();
?>

