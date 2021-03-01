<?php

function logIn ($conn) {
	$form_log		= "";
	$errorsFound 	= "";
	$form_login_success = "";
	$userInput		= "";
	$pass1			= "";
	$send_button	= "";
	
	// Взима данните, които сме въвели от формата
	if ( isset($_POST['userInput'] ) ) 
		$userInput		= $_POST['userInput'];
	if ( isset($_POST['pass1'] ) ) 
		$pass1 			= $_POST['pass1'];
	if ( isset($_POST['send_button'] ) ) 
		$send_button 	= "yes";;

		$form_log .= '
			<div class="container pt-5 ">
				<div class=" w-75 pl-5 bg-secondary text-white rounded mx-auto ">';	

		// Ако потребителя НЕ Е логнат - показва форма за логване
		$form_log .= '<form name="enter_fm" action="" method="post" class="row g-3">';

		$form_log .= '<div class="w-75 pt-3 pb-3 h4 ">';
		$form_log .= 'Вход за регистрирани потребители</div>';
		$form_log .= '<div class="w-75 pt-1 h6 ">';
		$form_log .= '<label for="userInput" class="form-label">Потребителско име или Електронна поща:</label>';
		$form_log .= '<input type="username" class="form-control form-control w-75" id="userInput"  value="'.$userInput.'" name="userInput" autofocus>';
		$form_log .= '</div>';
	
		// Проверява дали в полето userInput са въведени коректни стойности
		$checkError = checkText ($userInput);
		if ( $checkError != "" && $send_button == "yes" ) {
			$form_log 	.= '<div class="w-75 pb-3 h6 ">';
			$form_log   .= '<font style="color:DarkRed">'.$checkError.'</font></div>';
			$errorsFound .= 'Има грешки.';
		}

		$form_log .= '<div class="w-75 pt-1 h6 ">';
		$form_log .= '<label for="inputPassword4" class="form-label">Парола:</label>';
		$form_log .= '<input type="password" class="form-control  form-control w-75" name="pass1" value="'.$pass1.'">';
		$form_log .= '</div>';
		// Проверява дали в полето pass1 са въведени коректни стойности
		$checkError = checkText ($pass1);
		if ( $checkError != "" && $send_button == "yes" ) {
			$form_log 	.= '<div class="w-75 pb-3 h6">';
			$form_log   .= '<font style="color:DarkRed">'.$checkError.'</font></div>';
			$errorsFound .= 'Има грешки.';
		}

		
		// Ако е натиснат бутон и НЯМА грешки
		if ( $send_button == "yes"  and strlen($errorsFound) == 0 ) {
			$query= "SELECT * from users where (`username`= '".addslashes(  $userInput )."' or `mail` = '".addslashes(  $userInput )."') ";
			$result = mysqli_query($conn, $query); 
			if ($result && mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				if ( $row['deleted']  == 'deleted' ) {
					$form_log .= '<font style="color:DarkRed"><b>Вашият профил е изтрит. Ако искате да го ползате, свържете се с нас като видите данните от меню КОНТАКТИ.</b></font>';
				} else if ( $row['userType']  == '0' ) {
					$form_log .= '<font style="color:DarkRed"><b>Вашият профил все още не е активиран. <br>Проверете дали сте получили на електронната поща линк за активация.</b></font>';
				} else if ( $row['password']  == cryptoPassword ($pass1) ) {
					$form_log .= "<br>Намерен е потребител, който има право да ползва страницата.";
					// Записва данни на потребителя в сесията
           			$_SESSION['auth']			= true;
           			$_SESSION['userType']		= $row['userType'];
           			$_SESSION['userEmail']		= $row['mail'];
           			$_SESSION['userfulname'] 	= $row['username'];
           			$_SESSION['userid']			= $row['id'];
           			$_SESSION['lifetime']		= time()+30*60;	// Време, след което да разлогва = 30*60

					// update на последното логване
					$query = "UPDATE `chips`.`users` SET lastVisitDate=now() WHERE id='".addslashes($row['id'])."'";
					$result = mysqli_query($conn, $query);
					if ( mysqli_affected_rows($conn) ) {
						  // Успешно променен статус на потребител
					}
					
				} else {
					$form_log .= '<font style="color:DarkRed"><b>Грешна парола. Проверете и опитайте отново.</b></font><br>';
				}
			} else {
				$form_log .= '<font style="font-size:1vw; color:DarkRed">Няма такъв потребител. Проверете дали са коректни въведени <br>електронна поща или парола.</font><br>';
			}		
		}	

		$form_log .= '<div class="w-75 pt-1 h6 ">';
		$form_log .= '	<a href="index.php?m=17" class="text-white">Забравили сте си паролата?</a>';
		$form_log .= '	<a href="index.php?m=65" class="text-white">Ако сте нов потребител : Регистрирайте се</a>';
		$form_log .= '</div>';
		$form_log .= '<div class="w-75 pt-4 pb-4 h6 ">';
		$form_log .= '	<button type="submit" class="btn btn-dark px-5 py-2 btn-lg" name="send_button" value="Вход" id=submit1>Вход</button></div>';
		$form_log .= '</div>';
		$form_log .= '</form>';
		$form_log .= '</div>';
		
		if (isset ($_SESSION['auth']) && $_SESSION['auth']==true  && $_SESSION['lifetime'] > time()) {
			
			// Ако потребителя е вече логнат и в от мобилно устройство
			if ( $GLOBALS['deviceType'] == 'mobile' )
				$form_login_success.=showUnlocking($conn);
			else
				// Ако потребителя е вече логнат и в от компютър
				$form_login_success = '<center><div class="container d-flex justify-content-center align-items-center  h-25 w-50 m-5 p-4 bg-secondary text-white rounded text-left ">
					Здравейте, '.$_SESSION['userfulname'].'
					<br>Вие сте се влезнали в сайта като активен потребител.
					</div>';
		}
	
	// Проверява дали е логнат потребител или не
	if (isset ($_SESSION['auth']) && $_SESSION['auth']==true  && $_SESSION['lifetime'] > time()) 	
		return  $form_login_success;			// Логнат е - показва информационен текст
	else
		return  $form_log;						// Не е логнат - печата формата за логване
}
?>