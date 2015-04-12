<?php
	include_once 'header.php';

	if (!$loggedin) die();

	if (isset($_GET['view'])) $view = sanitizeString($_GET['view']); 
	else $view = $user;

	if (isset($_POST['text'])) {
		$text = sanitizeString($_POST['text']);

		if ($text != "") {
			$pm = substr(sanitizeString($_POST['pm']),0,1);
			$time = time();
			queryMysql("INSERT INTO messages VALUES(NULL, '$user', '$view', '$pm', '$time', '$text')");
		}
	}

	if ($view !="") {
		if ($view == $user) $name1 = $name2 = "Ваши"; //  Ваши 
		else {
			$name1 = "<a href='members.php?view=$view'>$view</a>'s";
			$name2 = "$view's";
		}

	echo  "<div class='main'><h3>$name1 сообщения</h3>";

	//  Сообщения
	showProfile($view); 
	echo  <<<_END
	<form method='post' action='messages.php?view=$view'>
	Печатайте сообщения здесь:<br />
	<textarea name='text' cols='40' rows='3'></textarea><br />
	В личку<input type='radio' name='pm' value='1' checked='checked'/>
	На стену<input type='radio' name='pm' value='0'/>
	<input type='submit' value='Отправить' /></form><br />
_END;

	if (isset($_GET['erase'])) {
		$erase = sanitizeString($_GET['erase']);
		queryMysql("DELETE FROM messages WHERE id = $erase AND recip = '$user'");
	}

	$query = "SELECT * FROM messages WHERE recip='$view' ORDER BY time DESC";
	$result = queryMysql($query);
	$num = mysqli_num_rows($result);

	for ($j=0; $j<$num; ++$j) {
		$row = mysqli_fetch_row($result);

		if ($row[3] == 0 || $row[1] == $user || $row[2] == $user) {
			echo date('m.d.y, g:ia:', $row[4]);
			echo "<a href='messages.php?view=$row[1]'>$row[1]</a> ";

			if ($row[3] == 0) echo "публично: &quot;$row[5]&quot; ";
			//  Сообщил
			else echo "лично: <span class='whisper'>&quot;$row[5]&quot;</span> ";
			//  Прошептал
			if  ($row[2] == $user) {
				echo "[<a href='messages.php?view=$view &erase=$row[0]'>erase</a>]";
			}
			//  Стереть
			echo  "<br/>";
		}
	}
}
	if (!$num) echo "<br/><span class='info'>Пока нет сообщений</span><br/><br/>";
	//  Пока  сообщений  нет
	echo "<br/><a class='button' href='messages.php?view=$view'>Обновиь сообщения</a>".
	//  Обновить  сообщения 
	"<a class='button' href='friends.php?view=$view'>$name2 друзья</a>";
?>
</div><br/></body></html>
