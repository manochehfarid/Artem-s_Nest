<?php
	$dbhost = 'localhost';
	$dbname = 'u894727402_artem';

	$dbuser = 'u894727402_artem';
	$dbpass = 'artemsk';

	$appname = "Сеть Артема";

	$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("Error " . mysqli_error($link));
	mysqli_select_db($link, $dbname);

	function createTable($name,$query) {
		queryMysql("CREATE TABLE IF NOT EXISTS $name($query)"); 
		echo "Таблица '$name' создана или уже существовала<br />";
	}

	function queryMysql($query) {
		global $link;
		$result = mysqli_query($link, $query) or die(mysqli_error($link));
		return $result;
	}

	function destroySession() {
		$_SESSION = array();
		if (session_id() != '' || isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-2592000, '/');
		}
		session_destroy();
	}

	function sanitizeString($var) {
		global $link;
		$var = strip_tags($var);
		$var = htmlentities($var);
		$var = stripslashes($var);
		return mysqli_real_escape_string($link, $var);
	}

	function showProfile($user) {
		if (file_exists("$user.jpg")) {
			echo "<img src = '$user.jpg' border = '1' align = 'left' />";
		}
		$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

		if (mysqli_num_rows($result)) {
			$row = mysqli_fetch_row($result);
			echo stripslashes($row[1])."<br clear=left /><br/>";
		}
	}
?>