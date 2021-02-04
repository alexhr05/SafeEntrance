<?php
function showForgottenPassword($conn){
	$form_log = '';
	$pass1 	  = '';
	$form_log .= '
		<div class="container pt-5 w-100 ">
			<div class=" w-75  pl-5 p-2 text-black rounded bg-secondary text-white rounded mx-auto">';

	
	$form_log  .= '<form name="enter_fm" action="" method="post" class="row g-5">';
	$form_log .= '<div class="w-75 pt-3 pb-3 h4 border">';
	$form_log .= 'Забравена парола</div>';
	
	$form_log .= '<div class="w-75 pt-1 h6 border">';
	$form_log .= '<label for="userInput" class="form-label">Моля въведете електронен адрес или потребителско име:</label><br>';
	$form_log .= '<input type="text" class="form-control  form-control w-75" name="pass1" value="'.$pass1.'"><br>';
	$form_log .= '</div>';		
	
	$form_log .= '<div class="w-75 pt-1 h6 border">';
	$form_log .= '<label for="age">Напишете с цифри следното число:</label><br>';
	$form_log .= '<input type="text" class="form-control  form-control w-75" name="pass1" value="'.$pass1.'"><br></div>';

	$form_log .= '<div class="w-75 pt-4 pb-4  ">';
	$form_log .= '	<button type="submit" class="btn btn-dark px-5 py-2 btn-lg" name="send_button" value="Изпрати" id=submit1>Изпрати</button></div>';
	$form_log .= '</form>';

	$form_log	.= '</div></div>';


	return $form_log;
}
?>