<?php
function show_regsiter($conn){

	$logg_all = '
		<div class="container w-100 ">
			<div class=" w-100 p-2 text-black rounded ">';
	$action 	= "0";
/*	$id 		= "0";
	$userType	= "";
	$deleted	= "";
	// Прочитаме параметри от линк-а
	if ( isset($_GET['action'] ) )
		$action = $_GET["action"];
	if ( isset($_GET['id'] ) )
		$id = $_GET["id"];
	if ( isset($_GET['userType'] ) )
		$userType = $_GET["userType"];
	if ( isset($_GET['sendEmail'] ) )
		$sendEmail = $_GET['sendEmail'];
	if ( isset($_GET['deleted'] ) )
		$deleted = $_GET['deleted'];

	// Решава каква заявка за кои параметри да се update-не
	if ( $action == "act" and isset($_GET['userType'] ) ) {
		$userType = $userType + 1;
		if ( $userType > $GLOBALS["userTypeAdmin"] )	// Ако е достигнал лимит за админ, сваля го на НУЛА
			$userType = 0;
		$query_param = "userType= '".$userType."' ";
	}
	if ( $action == "act" and isset($_GET['sendEmail'] ) )
		$query_param = "sendEmail= '".$sendEmail."' ";
		if ( $action == "act" and isset($_GET['deleted'] ) )
		$query_param = "deleted= '".$deleted."' ";
*/	
		// Прави справка за влезнали
		$fromDate="2020-05-05 00:00:00";
		$toDate=date("Y-m-d");
		$logg_all .= getRegisterEntrance( $fromDate,$toDate, $conn);

	
			
			$logg_all	.= '</div></div>';
		return $logg_all	;
		
	
}
?>


