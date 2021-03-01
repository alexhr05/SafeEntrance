<?php
function logOut () {

	$form_log = '
			<div class="container  mt-5 ">
				<div class=" w-75 p-5 bg-secondary text-white rounded d-flex align-items-center justify-content-center ">';

	if (isset($_SESSION['auth']) && $_SESSION['auth']==true ) {
		// Ако потребителя е вече логнат - излиза

		$form_log .= '
			Здравейте, '.$_SESSION['userfulname'].'
				<br>Вие току що се разлогнахте от сайта. Save Entrance Ви пожелава Приятен Ден.
			</div>';

		// Разлогва
 		unset($_SESSION['auth']);
		unset($_SESSION['userid']);
		unset($_SESSION['userFullName']);
		unset($_SESSION['userEmail']);
		unset($_SESSION['lifeTime']);
		unset($_SESSION['userType']);
		$m=0;		// Задава да се покаже начален екран при последващо опресняване.	
	} else {
		$form_log .= '
				Вече, сте излезнали от Вашия потребителски профил от сайта. <br>Ако искате да Влезете, ползвайте менюто ВХОД, горе вдясно.
			</div>';
		
	}
	return $form_log;
}

?>