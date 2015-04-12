<?php
	include_once 'header.php';

	echo "<br/><span class='main'>Добро пожаловать! ";
	if ($loggedin) echo " $user, вы вошли.";
	else echo 'Зарегистрируйтесь или войдите.';
?>

</span><br/><br/></body></html>