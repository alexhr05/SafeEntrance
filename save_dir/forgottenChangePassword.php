<?php

function showForgottenChangePassword ($conn) {
	$form_log		 = "";
	$action		     = "";
	$activationCode	 = "";
	$email           = "";
	$newPass         = "";
	$repeatNewPass   = "";
	$errors_log		 = "";
	$errorsFound 	 = "";
	$send_button 	 = "no";		// Инициализира в началото да НЕ е натиснат бутон
	
	if ( isset($_GET['action'] ) ) 
		$action = $_GET['action'];
	if ( isset($_GET['activationCode'] ) ) 
		$activationCode = $_GET['activationCode'];
	if ( isset($_GET['email'] ) ) 
		$email = $_GET['email'];
	if ( isset($_POST['newPass'] ) ) 
		$newPass= $_POST['newPass'];
	if ( isset($_POST['repeatNewPass'] ) ) 
		$repeatNewPass= $_POST['repeatNewPass'];
	if ( isset($_GET['send_button'] ) ) 
		$send_button 	= "yes";;

	
	$form_log		= '
	<div class="container pt-5 ">
		<div class=" w-50 pl-5 bg-secondary text-white rounded mx-auto ">';	

	
	// Проверява дали са въведени данни в поне едно от полетата за парола,
	// Ако са въведени - започва проверка. Ако и трите са празни - не прави нищо за парола
	if ($newPass != "" or $repeatNewPass!= "" )
		$pass_change = true;		// Ще проверява
	else
		$pass_change = false;		// Няма да проверява

	$query="SELECT * FROM `users` WHERE mail='".$email."' AND `activation`='".$activationCode."'";
	$result = mysqli_query($conn, $query );	

	

	if ($result && mysqli_num_rows($result) > 0) {
	
		//Ако е променена чавката за sendEmail-update в mySQL
		$form_log .= '<form  name="registration_fm" action="" method="POST" class="row g-3">';
		$form_log .= '<div class="w-75 pt-3 pb-3 h4 ">';
		$form_log .= 'Въвеждане на нова парола</div>'; 
		$form_log .= '<div class="w-75 pt-1 h6 "><label for="age">Въведете нова парола:</label><br>
						<input type="password" class="form-control   w-75" name="newPass" value="'.$newPass.'" id="fage"></div>';
		$checkError = checkText ($newPass);
		if ( $checkError != "" && $send_button == "yes" ) {
				$form_log 		.= '<div class="w-75 pb-3 h6">';
				$form_log   	.= '<font style="color:DarkRed">'.$checkError.'</font></div>';
				$errorsFound 	.= 'Има грешки.';
		}
			
		$form_log .=' 
			<div class="w-75 pt-1 h6 "><label for="age">Повторете нова парола:</label><br>
					<input type="password" class="form-control   w-75" name="repeatNewPass" value="'.$repeatNewPass.'" id="fage"></div>';
		$checkError = checkText ($repeatNewPass);
		if ( $checkError != "" && $send_button == "yes" ) {	
			$form_log 		.= '<div class="w-75 pb-3 h6">';
			$form_log   	.= '<font style="color:DarkRed">'.$checkError.'</font></div>';
			$errorsFound 	.= 'Има грешки.';
		}
		if($repeatNewPass!= $newPass && isset($_POST['send_button'])) {
			$form_log   .= '<div class="w-75 pb-3 h6"><font style="color:DarkRed">Двете пароли са различни.</font></div>';
			$errors_log .= 'Има грешки.';
		}
		

		$form_log .= '	<div class="w-75 pt-4 pb-4 h6 ">';
		$form_log .= '		<button type="submit"  class="btn btn-dark px-5 py-2 btn-lg " name="send_button">Смени парола</button>';
		$form_log .= '	</div> ';
		$form_log.='</form>';

		// Ако има грешки - не прави опит за връзка към mysql
		if ( strlen($errors_log) > 1 ) {
		} else {		// Ако няма грешки - записва
			//Ако  са въведени данни в полетата за пароли , update-вам парола. Заявка към бзата данни update 
			if ( $pass_change==true ) {
				$query = "UPDATE `users`SET `password`='".addslashes(cryptoPassword($newPass))."' WHERE `activation`='".addslashes($activationCode)."'";
				$result = mysqli_query($conn, $query);
				if ( mysqli_affected_rows($conn)>0 ) {
					// Успешно променен статус на потребител
					$form_log = '<div class="container "><div class=" w-50 m-5 p-5 bg-secondary text-white rounded mx-auto "><h5>Паролата е променена успешно.</h5>';
				}else{
					$form_log .= '<font style="color:DarkRed"><h5>Грешка.</h5></font>';
				}
			} 
		}
			
			
			
			
			

			



	} else {
		$form_log .='Възникна грешка при обработка на данни.';
	}

	$form_log .='</div>
	</div>';
	
	return $form_log;
}
?>