<?php
require_once('global_definitions.php');

$DB_CONNECTION = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die("MySQL Error: " . mysql_error());
mysql_select_db(DB_NAME, $DB_CONNECTION) or die("MySQL Error: " . mysql_error());

?>