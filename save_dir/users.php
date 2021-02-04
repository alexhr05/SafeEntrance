<?php
/*--------------------------------------------------------------------------------------------------------------
	showUsers	- Показва справка за потребители

	Входни данни:
		$conn		- параметри за връзка с mysql

	Изходни данни:
		$logg_all	- форматиран html код, който директно може да се покаже
--------------------------------------------------------------------------------------------------------------*/
function showUsers($conn){

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

/*--------------------------------------------------------------------------------------------------------------
	getUsers	- Справка за потребители

	Входни данни:
		$startDate  - начална дата за справка - формат  '2021-01-31'
		$endDate 	- крайна дата за справка - формат  '2021-01-31'
		$conn		- параметри за връзка с mysql

	Изходни данни:
		$logg_all	- форматиран html код, който директно може да се покаже
--------------------------------------------------------------------------------------------------------------*/
function getUsers($startDate, $endDate, $poleParam, $conn){
	$query="SELECT * FROM `users` WHERE $poleParam between '".$startDate." 00:00:00' And '".$endDate." 23:59:59'";
	$result = mysqli_query($conn, $query);
	$logg_all="";
	if ( $poleParam == 'registerDate' )
		$tablica = 'Регистрирани потребители';
	if ( $poleParam == 'lastVisitDate' )
		$tablica = 'Последни потребители на сайта';
	
	if ($result && mysqli_num_rows($result) > 0) {
		$logg_all .= '<table width=100%><tr><th colspan="11" class="th-top"> <b>'.$tablica.'</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
		$logg_all .= '<tr>  <th width=5%  >номер</th>
							<th width=15% >Дата регистрация</th>
							<th width=15% >Последно активен</th>
							<th width=15% style="text-align:left">Потребителско име</th>
							<th width=15% style="text-align:left">Истинско име</th>
							<th width=15% style="text-align:left">Електронна поща</th>
							<th width=5%  >sendEmail</th>
							<th width=5%  >userType</th>
							<th width=10% >Deleted</th>
							</tr>';
		while ($row1 = mysqli_fetch_assoc($result) ) {
			if ( $row1['deleted'] == 'yes' )
				$logg_all	.= '<tr style="color:white; background:DarkRed">';
			else
				$logg_all	.= '<tr>';

				$logg_all	.= '<td>'.$row1['id'].'</td>';
				$logg_all	.= '<td>'.$row1['registerDate'].'</td>';
				$logg_all	.= '<td>'.$row1['lastVisitDate'].'</td>';
				$logg_all	.= '<td style="text-align:left" >'.$row1['username'].'</td>';
				$logg_all	.= '<td style="text-align:left" >'.$row1['realName'].'</td>';
				$logg_all	.= '<td style="text-align:left" >'.$row1['mail'].'</td>';
				if ( $row1['sendEmail'] == 'yes' ) 
					$logg_all	.= '<td>
										<a href="index.php?m=13&action=act&id='.$row1['id'].'&sendEmail=no">
										yes</a></td>';
				else
					$logg_all	.= '<td>
										<a href="index.php?m=13&action=act&id='.$row1['id'].'&sendEmail=yes">
										no</a></td>';
				$logg_all	.= '<td>'.$row1['userType'];
				$logg_all	.= '<a href="index.php?m=13&action=act&id='.$row1['id'].'&userType='.$row1['userType'].'">
									<img src="img/plusOne_v3_25x25.png" style="opacity: 0.3;" height=25px width=25px>
								</a></td>';
				
				if ( $row1['deleted'] == 'yes' ) 
					$logg_all	.= '<td>
									<a href="index.php?m=13&action=act&id='.$row1['id'].'&deleted=no" style="color:white">
									изтрит</a></td>';
				else
					$logg_all	.= '<td>
									<a href="index.php?m=13&action=act&id='.$row1['id'].'&deleted=yes" >
									активен</a></td>';
				$logg_all	.= '</tr>';
		}
		mysqli_free_result($result);
		$logg_all	.= '</table>';
		$logg_all	.= 'userType=0 неактивен потребител, =1 потвърдил регистрация, =2 admin.';
	}

	return $logg_all;
}

?>


