<?php
	session_start();
	echo "<!DOCTYPE html>\n<html><head><meta charset='utf-8'><script src='OSC.js'></script>";
	include 'functions.php';

	$userstr = ' (Гость)';

	if (isset($_SESSION['user'])) {
		$user = $_SESSION['user'];
		$loggedin = TRUE;
		$userstr = " ($user)";
	}
	else {
		$loggedin = FALSE;
	}

	echo "<title>$appname$userstr</title><link rel = 'stylesheet'".
		"href='styles.css' type='text/css'/>".
		"</head><body><div class='appname'>$appname$userstr</div>";

	if ($loggedin) {
		echo "<br/><ul class='menu'>".
		"<li><a href = 'members.php?view=$user'>Начало</a></li>".
		"<li><a href = 'members.php'>Учасники</a></li>".
		"<li><a href = 'friends.php'>Друзья</a></li>".
		"<li><a href = 'messages.php'>Сообщения</a></li>".
		"<li><a href = 'profile.php'>Профиль</a></li>".
		"<li><a href = 'logout.php'>Выйти</a></li></ul><br/>";
	}
	else {
		echo ("<br/><ul class='menu'>".
		"<li><a href = 'index.php'>Начало</a></li>".
		"<li><a href = 'signup.php'>Зарегится</a></li>".
		"<li><a href = 'login.php'>Войти</a></li></ul><br/>");
		//"<span class='info'>&#8658; Вы должны войти, чоб увидеть эту страницу.</span><br/><br/>");
	}
?>