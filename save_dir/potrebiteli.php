<?php
function show_potrebiteli($conn){

	$logg_all = '
		<div class="container ">
			<div class=" w-100 p-2 text-black rounded ">';
	$action 	= "0";
	$id 		= "0";
	$userType	= "";
	$deleted	= "";

//----------- da se proveri ottuk
	// Прочитаме параметри от линк-а
	if ( isset($_GET['action'] ) )
		$action = $_GET["action"];
	if ( isset($_GET['id'] ) )
		$id = $_GET["id"];
	if ( isset($_GET['userType'] ) ) {
		$userType = $_GET["userType"];
		if ( checkInt($userType) != '' )
			return '2';
	}

	// Решава каква заявка за кои параметри да се update-не
	if ( $action == "act" and isset($_GET['userType'] ) ) {
		$userType = $userType + 1;
		if ( $userType > $GLOBALS["userTypeAdmin"] )	// Ако е достигнал лимит за админ, сваля го на НУЛА
			$userType = 0;
		$query_param = "userType= '".addslashes($userType)."' ";
	}
	if ( $action == "act" and isset($_GET['sendEmail'] ) )
		$query_param = "sendEmail= '".addslashes($sendEmail)."' ";
	if ( $action == "act" and isset($_GET['deleted'] ) )
		$query_param = "deleted= '".addslashes($deleted)."' ";
//----------- da se proveri DO TUK
	
	
	
	// Извършва заявката
	if ( ($action == "act" or $action == "deact") and $_SESSION['userid'] != $id ) {	// Ако е избрано действие И то НЕ Е върху СЕБЕ си
		$query = "UPDATE `chips`.`users` SET $query_param WHERE id='".addslashes($id)."'";
		$result = mysqli_query($conn, $query);
   		if ( mysqli_affected_rows($conn) ) {
			// Успешно променен статус на потребител
		}
	}

	$fromDate="2000-05-05 00:00:00";
	$toDate=date("Y-m-d");
	$logg_all .= getUsers( $fromDate,$toDate, 'registerDate', $conn);

	


	$logg_all	.= '</div></div>';

	return $logg_all	;

}
?>


