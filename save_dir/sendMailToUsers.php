<?php
function sendMailToUsers($conn) {
	$recipient 				= "";
	$messageBody 			= "";
	$mailSubject			= "";
	$mySelect				= "";
	$allMailToSend			= "";
	
	$form_log = '
		<div class="container ">
			<div class=" w-75  m-4  p-4 bg-secondary text-white rounded  mx-auto">';

	if ( isset($_POST['messageBody'] ) )
		$messageBody = $_POST["messageBody"];
	if ( isset($_POST['recipient'] ) )
		$recipient = $_POST["recipient"];
	if ( isset($_POST['mailSubject'] ) )
		$mailSubject = $_POST["mailSubject"];
	
	if ( isset($_POST['mySelect'] ) )
		$mySelect = $_POST["mySelect"];


	if (isset($_POST['submit']) ) {	
		
		if ( $recipient  == "" ) {	// Ако има зададен конректе
	
			if ( $mySelect == "регистрирани потребители" )
				$query = "SELECT * from users WHERE `sendEmail`='yes' and `userType`>0";
			if ( $mySelect == "администратори" )
				$query = "SELECT * from users WHERE `sendEmail`='yes' and `userType`='".$GLOBALS['userTypeAdmin']."'";
			if ( $mySelect == "потребители с регистрирани ключове/чипове" )
				$query = "SELECT `users`.`mail`,`allowchips`.`userid` from users,allowchips WHERE `users`.`sendEmail`='yes' and `allowchips`.`userid`=`users`.`id` ";
			if ( $mySelect == "всички потребители" )
				$query = "SELECT * from users WHERE `sendEmail`='yes'";
			
			$result = mysqli_query($conn, $query );			
			if ($result && mysqli_num_rows($result) > 0)  {
				while ($row = mysqli_fetch_assoc($result) ) {
					$allMailToSend .= $row['mail'].", ";
				}
			}
			$recipient = "Alexhr05@gmail.com, ".$allMailToSend;
		} 
		
		$form_log .= '<h3>Вашето Съобщение е изпратено.</h3>';

		if ( $mySelect != "изберете група от потребители" ) 
			$form_log .= '<br><br>Избрана група=('.$mySelect.')';
		
		$form_log .= '<br><br>До=('.$recipient.')';
		$form_log .= '<br><br>Заглавие=('.$mailSubject.')';
		$form_log .= '<br><br>Съобщение=('.$messageBody.')';

			
		// Изпраща мейл въпрос или предложение
		$messageBody = "Здравейте, получавате съобщение от сайта SafeEntrance.biz : <br><br>".$messageBody."<br><br>Изратено от : SafeEntrance";
		$headers  = "From: Alex<Alexhr05@gmail.com>\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
		$headers .= "Bcc: peterhr@gmail.com\r\n";	// Слага скрито копие за тестове
		$headers1251 = iconv("UTF-8", "CP1251", $headers );					
		mail($recipient, $mailSubject, $messageBody, $headers);

	} 
	if ( !isset($_POST['submit']) ) {		// Ако има грешки, печата отново формата за изпращане
	
		$form_log .= '<div  class="w-100 h6 ">
						<form name="registration_fm" action="index.php?m=11" method="POST" >
						<div class="form-inline w-100 mt-4" >
							<h3>Форма за изпращане на електронни съобщения до потребители :</h3>
						</div>
						';


		$form_log .= '  	<div class="form-inline w-100 mt-4">';
		$form_log .= '			<label for="validationTooltipUsername" class="form-label float-right">До кого да бъде изпратено : <br>напишете конкретен електронен адрес или изберете група от потребители от падащото меню :</label>';
		$form_log .= '		</div><br>';
		$form_log .= '  	<div class="form-inline w-100">';
		$form_log .= '			<input type="text" name="recipient" value="'.$recipient.'" maxlength="50" id="recipient" class="form-control w-50 float-left" autofocus>';
		$form_log .= '		</div>';
		
		$form_log .= '  	<div class="form-inline w-100">';
			$mySelect_array = array("изберете група от потребители","регистрирани потребители","администратори","потребители с регистрирани ключове/чипове","всички потребители");
			$form_log .= '<select class="select-sendmail" id="mySelect" name="mySelect" onchange="myFunction()" >';
			foreach($mySelect_array as $sOption){
				$form_log .= '<option value="'.$sOption.'" ';
				if ( $mySelect == $sOption )
					$form_log .= 'selected';
				$form_log .= '>'.$sOption.'</option>';
			}
			$form_log .= '</select></div>';

		
		$form_log .= '  	<div class="form-inline w-100 mt-4">';
		$form_log .= '			<label for="validationTooltipUsername" class="form-label float-right">Заглавие на съобщението :</label>';
		$form_log .= '		</div><br>';
		$form_log .= '  	<div class="form-inline w-100">';
		$form_log .= '			<input type="text" name="mailSubject" value="'.$mailSubject.'" maxlength="50" id="mailSubject" class="form-control w-50 float-left" autofocus>';
		$form_log .= '		</div>';
	
		$form_log .= '  	<div class="form-inline w-100 mt-4">';
		$form_log .= '			<label for="validationTooltipUsername" class="form-label float-right">Текст на съобщението :</label>';
		$form_log .= '		</div><br>';
		$form_log .= '  	<div class="form-inline w-100">';
		$form_log .= '			<textarea id="messageBody" name="messageBody" rows="6" cols="80" class="form-control w-50 float-left" maxlength="500">'.$messageBody.'</textarea>';
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