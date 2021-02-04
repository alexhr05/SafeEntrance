<?php

function changeProfile ($conn) {
	$form_log		= "";
	$Old_pass		= "";
	$New_pass		= "";
	$Check_1		= "";
	$Repeat_New_pass= "";
	$errors_log		= "";
	$errorsFound 	= "";
	$send_button 	= "no";		// Инициализира в началото да НЕ е натиснат бутон
	
	
	if ( isset($_POST['Old_pass'] ) ) 
		$Old_pass= $_POST['Old_pass'];
	if ( isset($_POST['New_pass'] ) ) 
		$New_pass= $_POST['New_pass'];
	if ( isset($_POST['Repeat_New_pass'] ) ) 
		$Repeat_New_pass= $_POST['Repeat_New_pass'];
	if ( isset($_POST['Check_1'] ) ) 
		$Check_1= $_POST['Check_1'];
	if ( isset($_POST['send_button'] ) ) 
		$send_button 	= "yes";;

	$form_log		= '
	<div class="container pt-5 ">
	<div class=" w-50 pl-5 bg-secondary text-white rounded mx-auto ">';	

	
	// Проверява дали са въведени данни в поне едно от полетата за парола,
	// Ако са въведени - започва проверка. Ако и трите са празни - не прави нищо за парола
	if ( $Old_pass != "" or $New_pass != "" or $Repeat_New_pass != "" )
		$pass_change = true;		// Ще проверява
	else
		$pass_change = false;		// Няма да проверява

	if ( $send_button == "yes"  ) {
		//	Презаписва дали да се получава мейл или не
		if ( $Check_1=='on'  )
			$query = "UPDATE `chips`.`users` SET sendEmail='yes' WHERE id='".addslashes($_SESSION['userid'])."'";
		else
			$query = "UPDATE `chips`.`users` SET sendEmail='no' WHERE id='".addslashes($_SESSION['userid'])."'";
		$result = mysqli_query($conn, $query);
		if ( mysqli_affected_rows($conn) ) {
			// Успешно променен статус на потребител
		}
	}

			//Ако е променена чавката за sendEmail-update в mySQL
			$form_log .= '<form  name="registration_fm" action="" method="POST" class="row g-3">';
			$form_log .= '<div class="w-75 pt-3 pb-3 h6 ">';
			$form_log .= '<font style="font-size:2vw">Профил</font></div>';
			$form_log .='<div class="w-75 pt-1 h6 "><label for="age">Въведете старата си парола:</label><br>';
			$form_log .='<input type="password" class="form-control   w-75" name="Old_pass" value="'.$Old_pass.'" id="fage"></div>';
			$checkError = checkPassword ($Old_pass);
			if ( $checkError != "" && $send_button == "yes" ) {
				$form_log 		.= '<div class="w-75 pb-3 h6">';
				$form_log   	.= '<font style="color:DarkRed">'.$checkError.'</font></div>';
				$errorsFound 	.= 'Има грешки.';
			}
			
			$form_log .= '					
					<div class="w-75 pt-1 h6 "><label for="age">Въведете нова парола:</label><br>
					<input type="password" class="form-control   w-75" name="New_pass" value="'.$New_pass.'" id="fage"></div>';
			$checkError = checkPassword ($New_pass);
			if ( $checkError != "" && $send_button == "yes" ) {
				$form_log 		.= '<div class="w-75 pb-3 h6">';
				$form_log   	.= '<font style="color:DarkRed">'.$checkError.'</font></div>';
				$errorsFound 	.= 'Има грешки.';
			}
			
			$form_log .=' 
			<div class="w-75 pt-1 h6 "><label for="age">Повторете нова парола:</label><br>
					<input type="password" class="form-control   w-75" name="Repeat_New_pass" value="'.$Repeat_New_pass.'" id="fage"></div>';
			$checkError = checkPassword ($Repeat_New_pass);
			if ( $checkError != "" && $send_button == "yes" ) {	
				$form_log 		.= '<div class="w-75 pb-3 h6">';
				$form_log   	.= '<font style="color:DarkRed">'.$checkError.'</font></div>';
				$errorsFound 	.= 'Има грешки.';
			}
			if($Repeat_New_pass != $New_pass && isset($_POST['send_button'])) {
				$form_log   .= '<div class="w-75 pb-3 h6"><font style="color:DarkRed">Двете пароли са различни.</font></div>';
				$errors_log .= 'Има грешки.';
			}
				
			// Ако има грешки - не прави опит за връзка към mysql
			if ( strlen($errors_log) > 1 ) {
			} else {		// Ако няма грешки - записва
			
			
			//Ако  са въведени данни в полетата за пароли , update-вам парола. Заявка към бзата данни update 
			if ( $pass_change ) {
				$query = "SELECT * from users WHERE id=".addslashes($_SESSION['userid']);
				$result = mysqli_query($conn, $query );			
				if ($result && mysqli_num_rows($result) > 0)  {
					$row1 = mysqli_fetch_assoc($result);
					$read_pass = $row1['password'];
					if ( md5($Old_pass) == $read_pass ) {		// Ако старата парола съвпадне с прочетената от базата данни - прави ъпдейт на парола
						$query = "UPDATE `chips`.`users` SET password='".addslashes(md5($New_pass))."' WHERE id='".addslashes($_SESSION['userid'])."'";
						$result = mysqli_query($conn, $query);
						if ( mysqli_affected_rows($conn) ) {
							// Успешно променен статус на потребител
							$form_log .= '<font style="color:DarkRed"><h5>Паролата е променена успешно.</h5></font>';
						}
					} else {
							$form_log .= '<font style="color:DarkRed"><h5>Старата паролата не съвпада с Вашият потребителски профил.</h5></font>';
					}
				}			
			}
			
			
			
			
			
			
			
			
			}
			
			// Взима текущия запис дали да праща мейли
			$result = mysqli_query($conn, "SELECT * from users WHERE id=".addslashes($_SESSION['userid']) );
			if ($result && mysqli_num_rows($result) > 0) 
			    $row1 = mysqli_fetch_assoc($result);
						
				
			$form_log .= '	<div class="form-check d-flex align-items-center justify-content-center border">';   
			$form_log .= '		<div class="col-md-12 my-auto w-100">';
			$form_log .= '			<input class="form-check-input" type="checkbox" id="gridCheck" ';
			if ($row1['sendEmail']== 'yes')
				$form_log .= ' checked ';
			$form_log .= ' name="Check_1">';

			$form_log .= '			<label class="form-check-label" for="gridCheck">';
			$form_log .= '				Съгласен съм да получавам електронни съобщения. ';
			$form_log .= '		</div>';
			$form_log .= '	</div>';
			
			$form_log .= '	<div class="w-75 pt-4 pb-4 h6 ">';
			$form_log .= '		<button type="submit"  class="btn btn-dark px-5 py-2 btn-lg " name="send_button">Смени парола</button>';
			$form_log .= '	</div> ';
			
	
			$form_log.='</form>
		</div>
	</div>
	';
	
	return $form_log;
	
}
?>