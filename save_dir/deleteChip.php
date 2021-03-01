<?php

function deleteChip($conn){

	$logg_all = '
		<div class="container bg-secondary text-white mt-5 p-4 ">
			<div class=" w-100 p-2 text-black rounded ">';
	$action 	= "";
	$id 		= "0";
	$userid		= "";
	$deleted	= "";
	$cardid		= "";
	$chipOwnerName = "";
//----------- da se proveri ottuk
	// Прочитаме параметри от линк-а
	if ( isset($_GET['action'] ) )
		$action = $_GET["action"];
	if ( isset($_GET['cardid'] ) )
		$cardid = $_GET["cardid"];
	if ( isset($_GET['userid'] ) )
		$userid = $_GET["userid"];
	if ( isset($_GET['chipOwnerName'] ) )
		$chipOwnerName = $_GET["chipOwnerName"];
// Да се проверяват входни данни	
	$logg_all .= "Изтриване на карта/чип за chipOwnerName= $chipOwnerName; userid= $userid; cardid= $cardid";
	
//----------- da se proveri DO TUK
	// Проверява дали да показва таблица или да извършва промяна
	if ( $action == 'delete' and checkInt($cardid) != "") {


			$query = "UPDATE `chips`.`allowchips` SET userid='0', chipOwnerName='' WHERE id='addslashes($cardid)'";
			echo $query;
		//	$result = mysqli_query($conn, $query);
			if ( mysqli_affected_rows($conn) ) {
				// Успешно променен статус на потребител

				// Да се добави DIV със сив фон !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
				$logg_all .= '<br>Успешно променихте данни за потребителя.';
			}
			
	
	} else {
		$logg_all .= 'Грешни параметри.';
	
	}
	$logg_all	.= '</div></div>';
	return $logg_all;
}
?>


