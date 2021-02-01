<?php

function check_in ($conn) {
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

		$form_log .= '<div class="w-75 pt-3 pb-3 h6 ">';
		$form_log .= '<font style="font-size:2vw">Вход за регистрирани потребители</font></div>';
		$form_log .= '<div class="w-75 pt-1 h6 ">';
		$form_log .= '<label for="userInput" class="form-label">Потребителско име или Електронна поща:</label>';
		$form_log .= '<input type="username" class="form-control form-control w-75" id="userInput"  value="'.$userInput.'" name="userInput" autofocus>';
		$form_log .= '</div>';
	
		// Проверява дали в полето userInput са въведени коректни стойности
		$checkError = checkUserOrMail ($userInput);
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
		$checkError = checkPassword ($pass1);
		if ( $checkError != "" && $send_button == "yes" ) {
			$form_log 	.= '<div class="w-75 pb-3 h6">';
			$form_log   .= '<font style="color:DarkRed">'.$checkError.'</font></div>';
			$errorsFound .= 'Има грешки.';
		}

		
		// Ако е натиснат бутон и НЯМА грешки
		if ( $send_button == "yes"  and strlen($errorsFound) == 0 ) {
			$query= "SELECT * from users where (`username`= '".addslashes(  $userInput )."' or `mail` = '".addslashes(  $userInput )."') and `deleted`='0' and `userType`<>'0'";
			$result = mysqli_query($conn, $query); 
			if ($result && mysqli_num_rows($result) > 0) {
				$row5 = mysqli_fetch_assoc($result);

				if ( $row5['password']  == md5 ($pass1) ) {
					$form_log .= "<br>Намерен е потребител, който има право да ползва страницата.";
				
					// Записва данни на потребителя в сесията
           			$_SESSION['auth']			= true;
           			$_SESSION['userType']		= $row5['userType'];
           			$_SESSION['userEmail']		= $row5['mail'];
           			$_SESSION['userfulname'] 	= $row5['username'];
           			$_SESSION['userid']			= $row5['id'];
           			$_SESSION['lifetime']		= time()+30*60;	// Време, след което да разлогва = 30*60

					// update на последното логване
					$query = "UPDATE `chips`.`users` SET lastVisitDate=now() WHERE id='".addslashes($row5['id'])."'";
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
		$form_log .= '	<a href="#home" class="text-white">Забравили сте си паролата?</a>';
		$form_log .= '	<a href="registrirai_se.html" class="text-white">Ако сте нов потребител : Регистрирайте се</a>';
		$form_log .= '</div>';
		$form_log .= '<div class="w-75 pt-4 pb-4 h6 ">';
		$form_log .= '	<button type="submit" class="btn btn-dark px-5 py-2 btn-lg" name="send_button" value="Вход" id=submit1>Вход</button></div>';
		$form_log .= '</div>';
		$form_log .= '</form>';
		$form_log .= '</div>';
		
		if (isset ($_SESSION['auth']) && $_SESSION['auth']==true  && $_SESSION['lifetime'] > time()) {
			// Ако потребителя е вече логнат
			$form_login_success = '<center><div class="container d-flex align-items-center justify-content-center h-75 w-50 m-5 p-4 bg-secondary text-white rounded">
				<p>Здравейте, '.$_SESSION['userfulname'].'
				<br>Вие сте се влезнали в сайта като активен потребител. Може да се възползвате от правата зададени за Вашето ниво на достъп.
				</p>
				</div>';	
	}
	
	// Проверява дали е логнат потребител или не
	if (isset ($_SESSION['auth']) && $_SESSION['auth']==true  && $_SESSION['lifetime'] > time()) 	
		return  $form_login_success;			// Логнат е - показва информационен текст
	else
		return  $form_log;						// Не е логнат - печата формата за логване
}
?>