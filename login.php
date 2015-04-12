<?php
	include_once 'header.php';

	echo "<div class='main'><h3>Введите данные для входа</h3>";
	
	$error = $user = $pass = "";

	if (isset($_POST['user'])) {
		$user = sanitizeString($_POST['user']);
		$pass = sanitizeString($_POST['pass']);

		if ($user == "" || $pass == "") {
			$error = "Не все поля заполнены!<br />";
		}
		else {
			$query = "SELECT user,pass FROM members WHERE user = '$user' AND pass = '$pass'";
			if (mysqli_num_rows(queryMysql($query)) == 0) {
				$error = "<span class='error'>Ник/Пароль неправельный!</span><br/><br/>";
			}
			else {
				$_SESSION['user'] = $user;
				$_SESSION['pass'] = $pass;
				die("Вы вошли. <a href='members.php?view=$user'>Жмите сюда</a> для продолжения.<br/><br/>");
			}
		}
	}
	echo <<<_END
	<form method='post' action='login.php'>$error
	<span class='fieldname'>Ник</span>
	<input type='text' maxlength='16' name='user' value='$user'/><br/>
	<span class='fieldname'>Пароль</span>
	<input type='password' maxlength='16' name='pass' value='$pass' />
_END;
?>
	<br/>
	<span сlass='fieldname'>&nbsp;</span>
	<input type='submit' value='Вход'/>
	</form><br/></div></body></html>