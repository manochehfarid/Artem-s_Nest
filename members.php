<?php
	include_once 'header.php';

	if (!$loggedin) die(); 
	echo "<div class='main'>";

	if(isset($_GET['view'])) {
		$view = sanitizeString($_GET['view']);

		// if ($view == $user) {
		// 	$name = "Ваш";
		// }
		// else {
		// 	$name = "$view's";
		// }

		echo "<h3>Ваш профиль</h3>";
		showProfile($view);
		echo "<a class='button' href='messages.php?view=$view'>".
			"Посмотреть сообщения</a><br/><br/>";
		die("</div></body></html>");
	}

	if (isset($_GET['add'])) {
		$add = sanitizeString($_GET['add']);

		if (!mysqli_num_rows(queryMysql ("SELECT * FROM friends WHERE user = '$add' AND friend = '$user'"))) {
			queryMysql ("INSERT INTO friends VALUES ('$add', '$user')");
		}
	}
	elseif (isset($_GET['remove'])) {
		$remove = sanitizeString($_GET['remove']);
		queryMysql("DELETE FROM friends WHERE user = '$remove' AND friend = '$user'");
	}

	$result = queryMysql("SELECT user FROM members ORDER BY user");
	$num = mysqli_num_rows($result);

	echo "<h3>Другие участники</h3><ul>";

	for ($j=0; $j<$num; ++$j) {
		$row = mysqli_fetch_row($result);
		if ($row[0] == $user) {
			continue;
		}

		echo "<li><a href='members.php?view = $row[0]'>$row[0]</a>";
		$follow = "подать заявку";

		$t1 = mysqli_num_rows(queryMysql("SELECT * FROM friends WHERE user = '$row[0]' AND friend = '$user'"));
		$t2 = mysqli_num_rows(queryMysql("SELECT * FROM friends	WHERE user = '$user' AND friend = '$row[0]'"));

		if (($t1 + $t2) > 1) echo "  &harr; друзья";
		elseif ($t1) echo " &larr; в друзья";
		elseif  ($t2) {
			echo " &rarr; хотят в друзья";
			$follow = "принять заявку";
		}
		if (!$t1) echo " [<a href='members.php?add=".$row[0] . "'>$follow</a>]";
		else echo " [<a href='members.php?remove=".$row[0]  . "'>отклонить</a>]";
	}
?>

<br/></div></body></html>