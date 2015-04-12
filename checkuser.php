<?php
	include_once 'functions.php';

	if (isset($_POST['user'])) {
		$user = sanitizeString($_POST['user']);
		
		if (mysqli_num_rows(queryMysql("SELECT * FROM members WHERE user = '$user'"))) {
			echo "<span class='taken'>&nbsp;&#x2718:Пардон, ник уже занят!</span>";
		}
		else {
			echo "<span class='avaliable'>&nbsp;&#x2718:Этот ник свободен!</span>";
		}
	}
?>