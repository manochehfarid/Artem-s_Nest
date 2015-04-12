<?php
	include_once 'header.php';

	if (isset($_SESSION['user'])) {
		destroySession();
		echo "<div class='main'>Вы вышли. <a href='index.php'>Клацните здесь</a> для обновления страницы."; 
	}
	else echo "<div class='main'><br/>Вы не можете выйти потому что Вы не входили!";
?>

<br/><br/></div></body></html>