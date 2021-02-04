<?php
/*--------------------------------------------------------------------------------------------------------------
	showRegsiterEntrance	- показва справка за влизание, чекиране на входни врати

	Входни данни:
		$conn		- параметри за връзка с mysql

	Изходни данни:
		$logg_all	- форматиран html код, който директно може да се покаже
--------------------------------------------------------------------------------------------------------------*/
function showRegsiterEntrance($conn){

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

/*--------------------------------------------------------------------------------------------------------------
	getRegisterEntrance	- справка за влизание, чекиране на входни врати

	Входни данни:
		$startDate  - начална дата за справка - формат  '2021-01-31'
		$endDate 	- крайна дата за справка - формат  '2021-01-31'
		$conn		- параметри за връзка с mysql

	Изходни данни:
		$logg_all	- форматиран html код, който директно може да се покаже
--------------------------------------------------------------------------------------------------------------*/
function getRegisterEntrance($startDate, $endDate, $conn){
	$query="SELECT * FROM `register_entrance` WHERE  `date` between '".$startDate." 00:00:00' And '".$endDate." 23:59:59'";
	$result = mysqli_query($conn, $query);
	$logg_all="";

	 if ($result && mysqli_num_rows($result) > 0) {
		$logg_all .= '<table width=100%><tr><th colspan="11" class="th-top"> <b>Влизания/Чекиране на врата</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
		$logg_all .= '<tr>  <th width=5%>номер</th>
							<th width=15%>date</th>
							<th width=15%>aciton</th>
							<th width=15%>door_id</th>
							<th width=5%>UID1</th>
							<th width=5%>UID2</th>
							<th width=5%>UID3</th>
							<th width=5%>UID4</th>
							<th width=10%>userid</th>
							<th width=10%>allow</th>
							</tr>';
		   while ($row1 = mysqli_fetch_assoc($result) ) {
				$logg_all	.= '<tr>';	  	      		
				$logg_all	.= '<td>'.$row1['id'].'</td>';
				$logg_all	.= '<td >'.$row1['date'].'</td>';
				$logg_all	.= '<td style="text-align:center"">'.$row1['action'].'</td>';
				$logg_all	.= '<td>'.$row1['door_id'].'</td>';
				$logg_all	.= '<td>'.$row1['UID1'].'</td>';
				$logg_all	.= '<td>'.$row1['UID2'].'</td>';
				$logg_all	.= '<td>'.$row1['UID3'].'</td>';
				$logg_all	.= '<td>'.$row1['UID4'].'</td>';
				$logg_all	.= '<td>'.$row1['userid'].'</td>';
				$logg_all	.= '<td>'.$row1['allow'].'</td>';
				


				$logg_all	.= '</tr>';
		 }
		 mysqli_free_result($result);
		 $logg_all	.= '</table>';
	}
	
	return $logg_all;
} 

?>


