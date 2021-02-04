<?php

function registration ($conn) {

$errorsFound 	= "";
$form_log 		= "";
$myurl			= "www.safeentrance.bg";
$activationCode = "";
$user_msg_body1 = "";

$username5		= "";
$pass1 			= "";
$mail1			= "";
$pass2			= "";
$mail2			= "";
$realName		= "";
$answer1		= "";
$send_button	= "";
$userInput		= "";

// Проверява дали потребителя е логнат, Ако Е - показва текст
if (isset($_SESSION['auth']) && $_SESSION['auth']==true  && $_SESSION['lifetime'] > time()) {
	$form_log  = '<br>Здравейте, '.$_SESSION['userfulname'];
	$form_log .= '<br>Вие сте се влезнали в сайта като активен потребител. Може да се възползвате от правата зададени за Вашето ниво на достъп.';
	$form_log .= '<br><br>Ако искате да регистирате друг потребител, моля, използвайте първо бутон ИЗХОД вляво и след това изберете РЕГИСТРАЦИЯ.';

} else {
	// Взима данните, които сме въвели от формата
	if ( isset($_POST['username5'] ) ) 
		$username5		= $_POST['username5'];
	if ( isset($_POST['pass1'] ) ) 
		$pass1 			= $_POST['pass1'];
	if ( isset($_POST['mail1'] ) ) 
		$mail1			= $_POST['mail1'];
	if ( isset($_POST['pass2'] ) ) 
		$pass2			= $_POST['pass2'];
	if ( isset($_POST['mail2'] ) ) 
		$mail2			= $_POST['mail2'];
	if ( isset($_POST['realName'] ) ) 
		$realName		= $_POST['realName'];
	if ( isset($_POST['answer1'] ) ) 
		$answer1		= $_POST['answer1'];
	if ( isset($_POST['send_button'] ) ) 
		$send_button	= "yes";
//		$send_button	= $_POST['send_button'];
	if ( isset($_POST['userInput'] ) ) 
		$userInput		= $_POST['userInput'];
	
	// Проверяваме дали въведените данни са коректни и подготвя форма за показване едновременно
	// За да може да покаже грешки вдясно от всяко грешно попълнено поле


		$form_log .= '
			<div class="container pt-5 pb-5 ">
				<div class=" w-75 pl-5 bg-secondary text-white rounded mx-auto ">';	
	
		$form_log .= '<form name="registration_fm" action="" method="POST" class="row g-3">';
		$form_log .= '	<div class="w-100 pt-3 pb-3 h6 ">';
		$form_log .= '		<font style="font-size:2vw">Регистрация</font></div>';
		
		$form_log .= '	<div class="w-100 h6 ">';
		$form_log .= '		<label class="w-25 float-left " for="username">Потребителско име:</label>';
		$form_log .= '		<div class="form-inline w-100 ">';
		$form_log .= '			<input type="text" name="username5" value="'.$username5.'" maxlength="50" id="username" class="form-control w-50 mr-1" autofocus>';

		$checkError = checkUsername ($username5);
		if ( $checkError != "" && $send_button == "yes" ) {
			$form_log   .= '<font style="color:DarkRed">'.$checkError.'</font>';
			$errorsFound .= 'Има грешки.';
		}
		$form_log .= '		</div>';
		$form_log .= '	</div>';

		$form_log .= '	<div class="w-100 pt-2 h6 ">';
		$form_log .= '		<label for="inputEmail4" class="w-25 float-left">Електронна поща:</label>';
		$form_log .= '		<div class="form-inline w-100 ">';
		$form_log .= '			<input type="email" id="inputEmail4" name="mail1" value="'.$mail1.'" maxlength="70" class="form-control w-50 mr-1">';
		
		// Проверява дали в полето mail1 са въведени коректни стойности
		$checkError = checkEmail ($mail1);
		if ( $checkError != "" && $send_button == "yes" ) {
			$form_log   .= '<font style="color:DarkRed">'.$checkError.'</font>';
			$errorsFound .= 'Има грешки.';
		}
		
		$form_log .= '  	</div>';
		$form_log .= '  </div>';

		$form_log .= '	<div class="w-100 pt-2 h6 ">';
		$form_log .= '		<label for="inputEmail4" class="form-label ">Повторете електронната поща:</label>';
		$form_log .= '		<div class="form-inline w-100 ">';
		$form_log .= '			<input type="email" id="inputEmail4" name="mail2" value="'.$mail2.'" maxlength="70" class="form-control w-50 mr-1" >';
		
		// Проверява дали в полето mail2 са въведени коректни стойности
		$checkError = checkEmail ($mail2);
		if ( $checkError != "" && $send_button == "yes" ) {
			$form_log   .= '<font style="color:DarkRed">'.$checkError.'</font>';
			$errorsFound .= 'Има грешки.';
		} else if ( $mail1 != $mail2 && $send_button == "yes" ) 		// Прави допълнителна проверка, дали двата мейла са еднакви
			$form_log   .= '<font style="color:DarkRed">Двата email адреса са различни.</font>';
		
		$form_log .= '		</div>';
		$form_log .= '	</div>';

		$form_log .= '	<div class="w-100 pt-2 h6 ">';
		$form_log .= '		<label for="inputPassword4" class="form-label ">Парола:</label>';
		$form_log .= '		<div class="form-inline w-100 ">';
		$form_log .= '			<input type="password" id="inputPassword4" name="pass1" value="'.$pass1.'" maxlength="50" class="form-control w-50 mr-1" >';

		// Проверява дали в полето pass1 са въведени коректни стойности
		$checkError = checkPassword ($pass1);
		if ( $checkError != "" && $send_button == "yes" ) {
			$form_log   .= '<font style="color:DarkRed">'.$checkError.'</font>';
			$errorsFound .= 'Има грешки.';
		}

		$form_log .= '		</div>';

		$form_log .= '	<div class="w-100 pt-2 h6 ">';
		$form_log .= '		<label for="inputPassword4" class="form-label ">Повторете паролата:</label>';
		$form_log .= '		<div class="form-inline w-100 ">';
		$form_log .= '			<input type="password" name="pass2" value="'.$pass2.'" maxlength="50" id="inputPassword4" class="form-control w-50 mr-1" >';

		// Проверява дали в полето pass2 са въведени коректни стойности
		$checkError = checkPassword ($pass2);
		if ( $checkError != "" && $send_button == "yes" ) {
			$form_log   .= '<font style="color:DarkRed">'.$checkError.'</font>';
			$errorsFound .= 'Има грешки.';
		} else if ( $pass1 != $pass2 && $send_button == "yes" ) 		// Прави допълнителна проверка, дали двете пароли са еднакви
			$form_log   .= '<font style="color:DarkRed">Двете пароли са различни.</font>';

		$form_log .= '		</div>';
		$form_log .= '	</div>';

		$form_log .= '	<div class="w-100 pt-2 h6 ">';
		$form_log .= '		<label for="inputName" class="form-label ">Вашето име:</label>';
		$form_log .= '		<div class="form-inline w-100 ">';
		$form_log .= '			<input type="text" id="inputName" name="realName" value="'.$realName.'" class="form-control w-50 mr-1" >';           
		
		// Проверява дали в полето realName са въведени коректни стойности
		$checkError = checkRealName ($realName);
		if ( $checkError != "" && $send_button == "yes" ) {
			$form_log   .= '<font style="color:DarkRed">'.$checkError.'</font>';
			$errorsFound .= 'Има грешки.';
		}

		$form_log .= '		</div>';
		$form_log .= '	</div>';
	


		$rowX = rand (1,22);	
		$query= "select * from `cifri` where `id` ='".addslashes($rowX)."'";
		$result12 = mysqli_query($conn, $query);
		if ($result12 && mysqli_num_rows($result12) > 0) { // Ако има активна заявка за активация
			$row5 = mysqli_fetch_assoc($result12);
			$form_log .= '	<div class="w-100 pt-2 h6 ">';
			$form_log .= '		<label for="inputName" class="form-label ">Защита от автоматични регистрации. Напишете следното число ( <b><font class="text-warning">'.$row5['text'].'</font></b> ) с цифри:</label>';
			$form_log .= '		<div class="form-inline w-100 ">';
			$form_log .= '			<input type="text" name="userInput" value="'.$userInput.'" maxlength="10" class="form-control w-50 mr-1" >';
			$form_log .= '  		<input type="hidden" name="answer1" value="'.$row5['answer'].'">';
				
			// Проверява дали в полето userInput са въведени коректни стойности
			$checkError = checkInt ($userInput);
			if ( $checkError != "" && $send_button == "yes" ) {
				$form_log   .= '<font style="color:DarkRed">'.$checkError.'</font>';
				$errorsFound .= 'Има грешки.';
			} else if ( $answer1 != $userInput && $send_button == "yes" ) {
				$form_log   .= '<font style="color:DarkRed">Не сте попълнили правилно числото</font>';
				$errorsFound .= 'Има грешки.';
			}
		}

		$form_log .= '		</div>';
		$form_log .= '	</div>';

		$form_log .= '		<div class="w-100 pt-3 pb-3 h6 ">';
		$form_log .= '		<button type="submit" class="btn btn-dark px-5 py-2 btn-lg " name="send_button">Създай нов профил</button>';
		$form_log .= '		</div>';       


	// След като е обходена формата и са направени проверките за грешки - ако няма грешки - записва
	if ( $send_button == "yes" ) {
		// Показва ако има грешки
		if ( strlen($errorsFound) > 1 ) {
			return $form_log;	// Регистрацията НЕ може да продължи, печата формата до момента с описание какво да се коригира
		} else {
			// Няма грешки, прави заявка за запис на потребител
			$query= "SELECT * from users where (`username`= 'addslashes($username5)' or `mail` = 'addslashes($mail1)') and `deleted`='0'";
			$result = mysqli_query($conn, $query); 
			if ($result && mysqli_num_rows($result) > 0) {
				$form_log .= '  <font style="color:DarkRed">Потребител с този mail съществува. </font>';
				$form_log .= '<script>alert("Потребител с този mail съществува.\nАко вече сте се регистрирали в този сайт използвайте меню ВХОД\nАко не сте активирали профила си, използвайте линка, получен на Вашата електронна поща.");</script>';

				// Да проверява дали потребителя е вече регистриран, НО НЕ Е АКТИВИРАН, т.е. трябва да му удължи времето за 
				// избиране на линка от мейла
				$row5 = mysqli_fetch_assoc($result);
				$query = "UPDATE `chips`.`users` SET registerDate=now() WHERE id='".addslashes($row5['id'])."'";
				$result = mysqli_query($conn, $query);
				if ( mysqli_affected_rows($conn) ) {
					// Успешно променени данни
				}
				
				$form_log .= '	</div>';				
			} else {
	
				$hiddenPass = md5($pass1);
				
				$activationCode = genRandomPassword(12);		// Генерира код с 12 символа
				
				$query = "INSERT INTO `users` (`id`, `registerDate`, `lastVisitDate`,`username`,`realName`,`mail`,`password`,`sendEmail`, `userType`, `activation`) 
									    values ('', now(), now(), '$username5', '$realName', '$mail1', '$hiddenPass', 'yes', '0', '$activationCode' )";
				$result = mysqli_query($conn, $query);
				if (!$result) {
//					$logg .= "<br><br>Invalid ... Грешка 91923.<br><br>";
				} else {
					// All OK
					$form_log  = '<div class="container h-75 d-flex align-items-center justify-content-center ">
									<div class=" w-50 p-4 bg-secondary text-white rounded ">';
					$form_log .= '	<br><font style="font-size:2vw">Регистрация</font><br>';
					$form_log .= '	<br><br><label>Регистрацията премина успешно. <br>На Вашата електронна поща ще получите линк, с който да активирате профила си. <br>Той ще бъде активен 24 часа.</label>';
					
					$server_ip = "http://192.168.1.3";
					// Изпраща мейл с линк за потвърждение
					$user_msg_body1 .= "Здравейте, ".$username5.". <br><br>Вие се регистрирахте в сайт $myurl. За да активирате своят акаунт, трябва да потвърдите чрез линк от електронен адрес. Моля, изберете следния линк :";
					$user_msg_body1 .= "<br><br>".$server_ip."/index.php?m=66&keyss=$activationCode&mail1=$mail1";
					$user_msg_body1 .= "<br><br>Ако не сте се регистирали в нашият сайт, моля игнорирайте този мейл. Данните ще бъдат изтрити до 24 часа.";
					
					$subject1 = "Регистрация в ".$myurl;
					
					$headers = "From: Alex<Alexhr05@gmail.com>\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
					$headers .= "Bcc: peterhr@gmail.com\r\n";	// Слага скрито копие за тестове
					$headers1251 = iconv("UTF-8", "CP1251", $headers );					
					$recipient = $mail1;
					
					mail($recipient, $subject1, $user_msg_body1, $headers1251);	
				
					$form_log .= "</div></div>";
					return $form_log;				
				}
			}
		}
	}	










	
}	// Край на проверка дали е логнат


$form_log .= '</form>';
$form_log .= '</div>';       

return $form_log;

}

?>

