<?php
class User {
	
	private function check_username($username){
		$checkusername = mysql_query("SELECT * FROM users WHERE username = '".$username."'");
		$username_exists = FALSE;
	
		if(mysql_num_rows($checkusername) == 1)
	    	$username_exists = TRUE;
		else
			$username_exists = FALSE;
	
		return $username_exists;
	}
	
	public function create($username, $name, $password, $email) {
		//echo $username;
		$username = mysql_real_escape_string($username);
		$name = mysql_real_escape_string($name);
	    $password = md5(mysql_real_escape_string($password));
	    $email = mysql_real_escape_string($email);
	
		if ($this->check_username($username)) {
			echo "Username already exists. $password <br />";
			echo $email;
		}
		else {
			$registerquery = mysql_query("INSERT INTO users (username, name, password, email) VALUES('$username', '$name' ,'$password', '$email')");
			//echo "I just tried to add you to the database";
	        if($registerquery)
				echo "Success, $name!  Welcome to WikiStudios!";
			else
				echo "Uh-oh, $name. Something went wrong inserting you into the database.";
		}
		
		
	}
	function getAuthSubRequestUrl()	{
	    $next = "http://wikistudios.caryme.com/login.php";
	    $scope = 'http://gdata.youtube.com';
	    $secure = false;
	    $session = true;
	    return Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure, $session);
	}
	
	function getAuthSubHttpClient() {
    	if (!isset($_SESSION['sessionToken']) && !isset($_GET['token']) ){
	        echo '<a href="' . $this->getAuthSubRequestUrl() . '">Login!</a>';
	        return;
	    } 
	
		else if (!isset($_SESSION['sessionToken']) && isset($_GET['token'])) {
	      $_SESSION['sessionToken'] = Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);
	    }

	    $httpClient = Zend_Gdata_AuthSub::getHttpClient($_SESSION['sessionToken']);
	    return $httpClient;
	}
	
	function make_auth_yt(){
		$httpClient = $this->getAuthSubHttpClient();
		$applicationId = "WikiStudios";
		$clientID = "ytapi-CaryLee-WikiStudios-6red0jpo-0";
		$devID = "AI39si5eRjODFkv8IM3mI3B67n52px4BOK7f9RMFQDvwxPOCb-deybqqDq5J7YPBxUYIywFtHzVoOW3Vb2vXLshhoeUSctidTw";
		$yt = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientID, $devID);
	}

	public function login($username, $password) {
		$username = mysql_real_escape_string($username);
		$password = md5(mysql_real_escape_string($password));
		$checklogin = mysql_query("SELECT * FROM users WHERE username = '$username' AND Password = '$password'");
		
	    if(mysql_num_rows($checklogin) == 1)
	    {
			//echo "Hello world!";
	    	$row = mysql_fetch_array($checklogin);
			$this->user_id = $row['user_id'];
			$this->email = $row['email'];
			$this->username = $row['username'];
	        $this->name = $row['name'];
	        // I'm trying to understand how to deal with OOP here.
	        $_SESSION['LoggedIn'] = 1;
			$_SESSION['username'] = $row['username'];
			$_SESSION['current_user'] = serialize($this);
		//	if (isset($_SESSION['current_user']))
		//		echo "Session is set in user.php <br />";
		}
	}
	
	public function set_youtube_token($token){
		$token = mysql_real_escape_string($token);
		$registerquery = mysql_query("UPDATE users SET youtube_token='$token' WHERE user_id='$this->user_id'");	
	}
	
	function logout() {
		// Taken from PHP.net mostly
		session_start();

		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		/*if (isset($_COOKIE[session_name()])) {
		    setcookie(session_name(), '', time()-42000, '/');
		}*/

		// Finally, destroy the session.
		session_destroy();
	}
}


?>