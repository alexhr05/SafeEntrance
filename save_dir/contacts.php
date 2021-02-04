<?php
function contacts() {
	$form_log = '
	<div class="container h-75 d-flex align-items-center justify-content-center ">
		<div class=" w-50 p-4 bg-secondary text-white rounded ">

				<p><br>За контакт с нас може да използвате следните данни:
				<br><br>SaveEntrance.net
				<br><br>Фирма Алекс ЕООД, 
				<br>гр.София, жк Сухата Река, бл.224
				<br>Тел.: +359 999 999 999
				<br>Електронна поща: info@saveentrance.net
				<br>
				<br>Може да зададете въпрос или предложение, като ползвате формата:
				</p>
			</div>
		</div>';
		
/*	
	$form_log .= '<form name="registration_fm" action="" method="POST" class="row g-3"><center>';
	$form_log .= '	<font style="font-size:2vw">Форма за връзка с екипа на SaveEntrance</font>';
	
	$form_log .= '  <div class="row pt-2">';
	$form_log .= '  	<div class="col-md-6 my-auto">';
	$form_log .= '			<label for="validationTooltipUsername" class="form-label float-right">Как да се свържем с Вас (електронна поща или телефон):</label>';
	$form_log .= '		</div>';
	$form_log .= '  	<div class="col-md-6 my-auto">';
	$form_log .= '			<input type="text" name="contact1" value="'.$contact1.'" maxlength="50" id="contact1" class="form-control w-50 float-left" >';

	if ( $contact1 == "" && $send_button == "yes" ) {
		$form_log   .= '<font style="color:DarkRed">Полето е празно.</font>';
		$errors_log .= 'Има грешки.';
	}
	if ( checkUsername ($contact1) == false && $send_button == "yes" ) {
		$form_log   .= '<font style="color:DarkRed">В полето username има забранени символи. Може да ползвате всички букви на латиница, цифри и символите: ! @ # _ - +</font>';
		$errors_log .= 'Има грешки.';
	}
	$form_log .= '		</div>';
	$form_log .= ' </div>';
	
	$form_log .= '  <div class="row pt-2">';
	$form_log .= '  	<div class="col-md-6 my-auto">';
	$form_log .= '			<label for="validationTooltipUsername" class="form-label float-right">Предложение или коментар (максимум 500 символа):</label>';
	$form_log .= '		</div>';
	$form_log .= '  	<div class="col-md-6 my-auto">';
	$form_log .= '			<input type="text" name="komentar" value="'.$komentar.'" maxlength="50" id="komentar" class="form-control w-50 float-left" >';

	if ( $komentar == "" && $send_button == "yes" ) {
		$form_log   .= '<font style="color:DarkRed">Полето е празно.</font>';
		$errors_log .= 'Има грешки.';
	}
	if ( checkUsername ($komentar) == false && $send_button == "yes" ) {
		$form_log   .= '<font style="color:DarkRed">В полето username има забранени символи. Може да ползвате всички букви на латиница, цифри и символите: ! @ # _ - +</font>';
		$errors_log .= 'Има грешки.';
	}
	$form_log .= '		</div>';
	$form_log .= ' </div>';

					// Изпраща мейл въпрос или предложение
					$user_msg_body1 .= "Здравейте, ".$contact1.". <br><br>";
					
					$subject1 = "Попълнена е форма за предложение : <br><br>".$komentar;
					
					$headers = "From: Alex<Alexhr05@gmail.com>\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
					$headers1251 = iconv("UTF-8", "CP1251", $headers );					
					$recipient = "Alexhr05@gmail.com";
					
					mail($recipient, $subject1, $user_msg_body1, $headers1251);	
	*/
	
	
return $form_log;
}
?>