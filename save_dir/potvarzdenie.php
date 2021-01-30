<?php


function potvarzdenie($mail1, $keyss, $conn){
$form_log = "";

	$form_log = '
		<div class="container h-75 d-flex align-items-center justify-content-center ">
			<div class=" w-50 p-4 bg-secondary text-white rounded ">';
	$form_log .= '<form name="registration_fm" action="" method="post">';
	$form_log .= '	<br><font style="font-size:2vw">Регистрация</font><br>';

if ( $keyss != "" and checkUsername ($keyss) and checkEmail ($mail1) ) {
	$form_log .= '	<br>Въведени данни: '.$mail1.'<br>';

	// select да провери дали keyss Получено от линка е записано на някой потребител

			$query= "select *,HOUR (TIMEDIFF(now(),registerDate)) as HourDiff from `users` where `mail` ='".$mail1."' and `activation` ='".$keyss."'";
			$result = mysqli_query($conn, $query);
			if ($result && mysqli_num_rows($result) > 0) { // Ако има някакъв резултат, значи са правилни полетата mail1 и keyss
				$row5 = mysqli_fetch_assoc($result);
				// Проверката е успешна - трябва да смени userType`
				if ( $row5['HourDiff'] < 24 ) {
					$query= "UPDATE `users` SET userType='1' WHERE `mail`='".$mail1."' and `deleted`='0'";
					$result = mysqli_query($conn, $query);
					if ($result) { // Ако има някакъв резултат, значи са попълнени правилно цифрите
						$form_log .= "<br>Здравейте, Вие активирахте своя акаунт. Може да се оторизирате като изберете меню ВХОД.";
					} else {
						$form_log .= "<br>Възникна грешка при активирането. Моля, свържете се с администратор на сайта.";
					}	
				} else {
					$form_log .= "<br>За съжаление, са изминали повече от 24 часа от Вашата регистрация и този линк е неактивен. Изберете меню РЕГИСТРАЦИЯ и въведете отново Вашите данни. Ще получите НОВ мейл с нов линк за активация.";
					// Променя статуса на записа на DELETED=1, по този начин, ще може отново да се регистрира със същият мейл
					$query= "UPDATE `users` SET `deleted`='1' WHERE `mail`='".$mail1."'";
					$result = mysqli_query($conn, $query);
//					if ($result) { // Ако има някакъв резултат, значи е ъпдейтнато правилно
//						$form_log .= "<br>Старият акаунт е заличен.";
//					} else {
//						$form_log .= "<br>Възникна грешка при заличаването на стария акаунт. Моля, свържете се с администратор на сайта.";
//					}	
				}				
			} else {
				// Грешка
				$form_log .= "<br>Грешка при проверка на данни. Моля свържете се с администратор на сайта.";
			}


} else {
	$form_log .= "<br>Некоректни данни.";
}

	
$form_log .= '</form></div></div>';

return $form_log;
}
?>

