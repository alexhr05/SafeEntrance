<?php
function showForgottenPassword($conn){
	$form_log = '';
	$email 	  = '';
	$userInputRobotCheck = '';
	$errorsFound = '';
	$answerRobotCheck = '';

	$form_log .= '
		<div class="container pt-5 w-100 ">
			<div class=" w-75  pl-5 p-2 text-black rounded bg-secondary text-white rounded mx-auto">';
		if ( isset($_POST['answerRobotCheck'] ) )
			$answerRobotCheck = $_POST["answerRobotCheck"];
		if ( isset($_POST['userInputRobotCheck'] ) )
			$userInputRobotCheck = $_POST["userInputRobotCheck"];
		if ( isset($_POST['email'] ) )
			$email = $_POST["email"];

			
		$form_log  .= '<form name="enter_fm" action="index.php?m=17" method="POST" >';
		$form_log .= '<div class="w-75 pt-3 pb-3 h4 ">';
		$form_log .= 'Забравена парола</div>'; 
		
			
			$form_log .= '<div class="w-100 pt-1 h6  ">';
			$form_log .= '<label for="userInput" class="form-label">Моля въведете електронен адрес или потребителско име:</label><br>';
			$form_log .= '<input type="text" class="form-control w-50" name="email" value="'.$email.'">';
			
			if ( (checkEmail ($email) != '' and checkText($email) != '') and isset($_POST['submit'])) {
				$form_log   .= '<font style="color:DarkRed"><h5>Не сте въвели правилно електронна поща или потребителско име.</h5></font>';
				$errorsFound .= 'Има грешки.';
			}
			$form_log .= '</div>';		

			
			//	$form_log .= '<div class="w-75 pt-1 h6 ">';
			//	$form_log .= '<label for="age">Напишете с цифри следното число:</label><br>';
			//	$form_log .= '<input type="text" class="form-control  form-control w-75" name="pass1" value="'.$pass1.'"><br></div>';

			$rowX = rand (1,22);	
			$query= "select * from `cifri` where `id` ='".addslashes($rowX)."'";
			$result12 = mysqli_query($conn, $query);
			if ($result12 && mysqli_num_rows($result12) > 0) { // Ако има активна заявка за активация
				$row = mysqli_fetch_assoc($result12);
				$form_log .= '	<div class="  w-100 mt-2 ">';
				$form_log .= '		<label for="inputName" class="form-label ">Защита от автоматични регистрации. Напишете следното число ( <b><font class="text-warning">'.$row['text'].'</font></b> ) с цифри:</label>';
				$form_log .= '		<input type="text" class="form-control w-50 mr-1 "  name="userInputRobotCheck" value="'.$userInputRobotCheck.'" maxlengthзащи"10" ';
				if ( $errorsFound != "" )	// Оцветява в червено фона на полето за защита от автоматични регистрации, за да привлече внимание на потребителя
					$form_log .= 'style="background-color: #cd5c5c;"';

				$form_log .= '			>';
				$form_log .= '  		<input type="hidden" name="answerRobotCheck" value="'.$row['answer'].'">';
				

				$checkError = checkInt ($userInputRobotCheck);
				if ( $checkError != "" and isset($_POST['submit']) ) {
					$form_log   .= '<font style="color:DarkRed"><h5>'.$checkError.'</h5></font><br>';
					$errorsFound .= 'Има грешки.';
				} else if ( $answerRobotCheck != $userInputRobotCheck ) {
					$form_log   .= '<font style="color:DarkRed"><h5>Не сте попълнили правилно числото в поле "Защита от автоматични регистрации".</h5></font>';
					$errorsFound .= 'Има грешки.';
				}
			}
			
			$form_log .= '		</div>';
			



			$form_log .= '<div class="w-75 pt-4 pb-4  ">';
			$form_log .= '	<button type="submit" class="btn btn-dark px-5 py-2 btn-lg" name="submit" value="Изпрати" id=submit1>Изпрати</button></div>';
			$form_log .= '</form>';
		//}
		if($errorsFound == '' and isset($_POST['submit'])){// Няма грешки изпраща имейл
			// Проверява дали съществува такъв потребител
			$query= 'SELECT * FROM users WHERE `mail`="'.$email.'" ';
			//Да проверя дали съществува такъв потребител. Ако съществува да изпрати мейл, ако не да печата грешка.
			$result = mysqli_query($conn, $query);
			if ($result && mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);

				if($row['mail'] == $email){
					$form_log ='<center><div class="container d-flex justify-content-center align-items-center  h-75 w-50 m-5 p-4 bg-secondary text-white rounded text-left ">
					<h5>На Вашата електронна поща е изпратен линк, който трябва да потвърдите, за да можете да промените паролата за нашия сайт.</h5>
					</div>';	
					if ( strpos ($_SERVER['REMOTE_ADDR'], '192.168.1.')  === 0 ) 
						// Локален адрес
						$server_ip = "http://192.168.1.5";	
					else
						// Публичен адрес
						$server_ip = "safeentrance.biz";

					// Изпраща мейл въпрос или предложение
					$userMsgBody = 'Здравейте,<br>изберете следния линк, за да промените Вашата парола :<br> '.$server_ip.'/index.php?m=18&email='.$email.'&action=allow&activationCode='.$row['activation'];
					$subject1 = "Забравена парола за Safeentrance.biz ";
					$headers = "From: Alex<Alexhr05@gmail.com>\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
					$headers .= "Bcc: peterhr@gmail.com\r\n";	// Слага скрито копие за тестове
					$headers .= "Bcc: alexhr05@gmail.com\r\n";	// Слага скрито копие за тестове
					$headers1251 = iconv("UTF-8", "CP1251", $headers );					
					$recipient = "Alexhr05@gmail.com";
					mail($recipient, $subject1, $userMsgBody, $headers);

				}else{
					$form_log   .= '<font style="color:DarkRed"><h5>Не сте въвели правилно ел. поща или потребителско име."</h5></font>';
					$errorsFound .= 'Има грешки.';

				}

			}
			
			
			
			
		
		}
		
		

	$form_log	.= '</div></div>';


	return $form_log;
}
?>