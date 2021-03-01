<?php
function contacts($conn) {
	$userContactInfo 		= "";
	$userComment 			= "";
	$userInputRobotCheck  	= "";
	$answerRobotCheck 		= "";
	$errorsFound 			= "";

	$form_log = '
		<div class="container ">
			<div class=" w-75  m-4  p-4 bg-secondary text-white rounded  mx-auto">';
	$form_log .= '
			<div class="pt-2 " >
				<h3>За контакт с нас може да използвате следните данни:</h3>
				<br>SaveEntrance.biz
				<br>Фирма Алекс ЕООД, 
				<br>гр.София, жк Сухата Река, бл.224
				<br>Тел.: +359 999 999 999
				<br>Електронна поща: info@saveentrance.biz
				<hr style="border: 1px solid white">
			</div>';

	if ( isset($_POST['userComment'] ) )
		$userComment = $_POST["userComment"];
	if ( isset($_POST['userContactInfo'] ) )
		$userContactInfo = $_POST["userContactInfo"];
	if ( isset($_POST['answerRobotCheck'] ) )
		$answerRobotCheck = $_POST["answerRobotCheck"];
	if ( isset($_POST['userInputRobotCheck'] ) )
		$userInputRobotCheck = $_POST["userInputRobotCheck"];
	

	if (isset($_POST['submit']) ) {	
		
	
			// Проверява дали в полето userInputRobotCheck са въведени коректни стойности
			$checkError = checkInt ($userInputRobotCheck);
			if ( $checkError != ""  ) {
				$form_log   .= '<font style="color:DarkRed"><h3>'.$checkError.'</h3></font><br>';
				$errorsFound .= 'Има грешки.';
			} else if ( $answerRobotCheck != $userInputRobotCheck ) {
				$form_log   .= '<font style="color:DarkRed"><h3>Не сте попълнили правилно числото в поле "Защита от автоматични регистрации".</h3></font>';
				$errorsFound .= 'Има грешки.';
			} else
				$form_log .= '<h3>Вашето запитване е изпратено.</h3>';
			
			if ( $errorsFound == "" ) {		// Ако няма грешки - изпраща мейл
					// Изпраща мейл въпрос или предложение
					$userMsgBody = "Здравейте, Съдържание на коментар/предложение : <br><br>".$userComment."<br><br>Изратено от : ".$userContactInfo;
					$subject1 = "Попълнена е форма за предложение от : ".$userContactInfo;
					$headers = "From: Alex<Alexhr05@gmail.com>\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
					$headers .= "Bcc: alexhr05@gmail.com\r\n";	// Слага скрито копие за тестове
					$headers1251 = iconv("UTF-8", "CP1251", $headers );					
					$recipient = "Alexhr05@gmail.com";
					mail($recipient, $subject1, $userMsgBody, $headers);
			}

	} 
	if ( !isset($_POST['submit']) or $errorsFound != "" ) {		// Ако има грешки, печата отново формата за изпращане
	
		$form_log .= 'Може да зададете въпрос или предложение, като ползвате формата:
					<div  class="w-100 h6 ">
						<form name="registration_fm" action="index.php?m=7" method="POST" >
						<div class="form-inline w-100 mt-4" >
							<h3>Форма за връзка с екипа на SaveEntrance</h3>
						</div>
						';


		$form_log .= '  	<div class="form-inline w-100 mt-2">';
		$form_log .= '			<label for="validationTooltipUsername" class="form-label float-right">Как да се свържем с Вас ? (електронна поща или телефон).:</label>';
		$form_log .= '		</div><br>';
		$form_log .= '  	<div class="form-inline w-100">';
		$form_log .= '			<input type="text" name="userContactInfo" value="'.$userContactInfo.'" maxlength="50" id="userContactInfo" class="form-control w-50 float-left" autofocus>';
		$form_log .= '		</div>';
	
		$form_log .= '  	<div class="form-inline w-100 mt-2">';
		$form_log .= '			<label for="validationTooltipUsername" class="form-label float-right">Предложение или коментар (максимум 500 символа):</label>';
		$form_log .= '		</div><br>';
		$form_log .= '  	<div class="form-inline w-100">';
		$form_log .= '			<textarea id="userComment" name="userComment" rows="6" cols="80" class="form-control w-50 float-left" maxlength="500">'.$userComment.'</textarea>';
		$form_log .= '		</div>';
		$rowX = rand (1,22);	
		$query= "select * from `cifri` where `id` ='".addslashes($rowX)."'";
		$result12 = mysqli_query($conn, $query);
		if ($result12 && mysqli_num_rows($result12) > 0) { // Ако има активна заявка за активация
			$row5 = mysqli_fetch_assoc($result12);
			$form_log .= '	<div class="form-inline w-100 mt-2">';
			$form_log .= '		<label for="inputName" class="form-label ">Защита от автоматични регистрации. Напишете следното число ( <b><font class="text-warning">'.$row5['text'].'</font></b> ) с цифри:</label>
							</div><br>';
			$form_log .= '		<div class="form-inline w-100">';
			$form_log .= '			<input type="text" class="form-control w-50 mr-1 "  name="userInputRobotCheck" value="'.$userInputRobotCheck.'" maxlengthзащи"10" ';
			if ( $errorsFound != "" )	// Оцветява в червено фона на полето за защита от автоматични регистрации, за да привлече внимание на потребителя
				$form_log .= 'style="background-color: #cd5c5c;"';
			$form_log .= '			>';
			$form_log .= '  		<input type="hidden" name="answerRobotCheck" value="'.$row5['answer'].'">';

		}

		$form_log .= '		</div>';
		$form_log .= '		<div class="form-inline w-50 p-4 ">
								<input class="btn btn-dark btn-lg  w-100 pl-4 pr-4 " type="submit" name="submit" value="Изпрати">
							</div>
						</form>';
		$form_log .= '						
						</div>
					  </div>';
						
	}

	$form_log .= '	</div>';	// Заглавните 2 DIV-а
	$form_log .= '</div>';

	return $form_log;
}
?>