<?php
	include_once 'header.php';

	if (!$loggedin) die();

	if (isset($_GET['view'])) $view = sanitizeString($_GET['view']);
	else $view = $user;

	if  ($view == $user) {
		$name1 = $name2 = "Ваши";  //  Ваши
		$name3 = "Вы";  //  Вы
	}
	else {
		$name1 = "<a href='members.php?view=$view'>$view</a>'s";
		$name2 = "$view's";
		$name3 = "$view is";
	}

	echo  "<div class = 'main'>";
	//  Если  хотите  вывести  здесь  профиль  пользователя,  уберите  знаки 
	//  комментария  из  следующей  строки 
	//  showProfile($view);
	$followers = array();
	$following = array();

	$result = queryMysql("SELECT * FROM friends WHERE user = '$view'");
	$num = mysqli_num_rows($result);

	for ($j=0; $j<$num; ++$j) {
		$row = mysqli_fetch_row($result);
		$followers[$j] = $row[1];
	}

	$result = queryMysql("SELECT * FROM friends WHERE friend = '$view'");
	$num = mysqli_num_rows($result);

	for ($j=0; $j<$num; ++$j) {
		$row = mysqli_fetch_row($result);
		$following[$j] = $row[0];
	}

	$mutual = array_intersect($followers, $following);
	$followers = array_diff($followers, $mutual);
	$following = array_diff($following, $mutual);
	$friends  =  FALSE;

	if (sizeof($mutual)) {
		echo "<span class='subhead'>$name2 друзья</span><ul>";
		//  Взаимные  друзья 
		foreach($mutual as $friend) {
			echo "<li><a href='members.php?view=$friend'>$friend</a>";
		}
		echo "</ul>";
		$friends = TRUE;
	}

	if (sizeof($followers)) {
		echo "<span class='subhead'>Заявки в $name2 друзья</span><ul>";
		//  Интересующиеся  в  дружбе  с... 
		foreach($followers as $friend) {
			echo "<li><a href='members.php?view=$friend'>$friend</a>";
		}
		echo "</ul>";
		$friends = TRUE;
	}

	if  (sizeof($following)) {
		echo "<span class='subhead'>$name2 заявки на дружбу</span><ul>";
		//  Заинтересован  в  дружбе  с... 
		foreach($following as $friend) {
			echo "<li><a href='members.php?view=$friend'>$friend</a>";
		}
		echo "</ul>";
		$friends = TRUE;
	}

	if (!$friends) echo "<br/>У Вас пока нет друзей!!<br/><br/>";
	//  Пока  у  вас  нет  друзей
	echo "<a class='button' href='messages.php?view=$view'>Посмотреть $name2 сообщения</a>";
?>

</div><br/></body></html>