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

	$logg_all 	.= '<form name="continue" action="" method="post" >';
	$logg_all	.= '<input type="submit" class="btn btn-secondary w-100"  id="555" name="submit" value="Опресни"></form>';

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
//	$query="SELECT * FROM `register_entrance` WHERE  `date` between '".$startDate." 00:00:00' And '".$endDate." 23:59:59' ORDER BY id DESC";
	$UID 			= "";		// Обш стринг с ID на чип-а
	$uid1			= "";		// Разбито поотделно ID-то на части, за да се дава по-лесно на mysql
	$uid2			= "";
	$uid3			= "";
	$uid4			= "";
	$chipOwnerName	= "";
	$doorId			= "";
	$unlockFrom		= "";
	if ( isset($_GET['UID'] ) ) {
		$UID				= $_GET['UID'];
		if ( $UID != "" ) {
			$textAr = explode("-", $UID);
			$textAr = array_filter($textAr, 'trim'); 
			$uid1 = $textAr[0];
			$uid2 = $textAr[1];
			$uid3 = $textAr[2];
			$uid4 = $textAr[3];
		}
	}
	if ( isset($_GET['chipOwnerName'] ) ) 
		$chipOwnerName		= $_GET['chipOwnerName'];
	if ( isset($_GET['unlockFrom'] ) ) 
		$unlockFrom		= $_GET['unlockFrom'];
	if ( isset($_GET['doorid'] ) ) 
		$doorId		        = $_GET['doorid'];
	// Заявката е по-сложна, за да може да вземе името на собственика на чипа от друга таблица
	if ( $UID == "" and $chipOwnerName == "" and $doorId == "" and $unlockFrom == "" ) 	// Ако няма избрано UID или име на потребител или врата
		$query="SELECT * FROM `register_entrance`
				WHERE `date` between '".$startDate."' And '".$endDate." 23:59:59' 
				ORDER BY id DESC";
	else if ( $UID != "" ) 	// Ако е избрано да показва влизане по чип - UID
		$query="SELECT `register_entrance`.`id`, date, action, door_id, 
					`register_entrance`.`UID1`, `register_entrance`.`UID2`, `register_entrance`.`UID3`, `register_entrance`.`UID4`, 
					`register_entrance`.`unlockFrom`, 
					`allowchips`.`userid`, `allowchips`.`chipOwnerName`	 FROM `register_entrance`, `allowchips`  
				WHERE  
					`date` between '".$startDate."' And '".$endDate." 23:59:59' and
					`register_entrance`.`UID1`=`allowchips`.`UID1` and
					`register_entrance`.`UID2`=`allowchips`.`UID2` and
					`register_entrance`.`UID3`=`allowchips`.`UID3` and
					`register_entrance`.`UID4`=`allowchips`.`UID4` and
					`register_entrance`.`UID1`='".$uid1."' and
					`register_entrance`.`UID2`='".$uid2."' and
					`register_entrance`.`UID3`='".$uid3."' and
					`register_entrance`.`UID4`='".$uid4."'
				ORDER BY id DESC";
	else if ( $chipOwnerName != "" ) 	// Ако е избрано да показва влизане по потребител
		$query="SELECT * FROM `register_entrance`
				WHERE `date` between '".$startDate."' And '".$endDate." 23:59:59' And 
					`register_entrance`.`chipOwnerName` = '".$chipOwnerName."'
				ORDER BY id DESC";

	else if ( $doorId != "" ) 	// Ако е избрано да показва влизане по ВРАТА
		$query="SELECT * FROM `register_entrance`
				WHERE `date` between '".$startDate."' And '".$endDate." 23:59:59' And 
				`register_entrance`.`door_id` = '".$doorId."' 
				ORDER BY id DESC";
	else if ( $unlockFrom != "" ) 	// Ако е избрано да показва влизане ОТ
		$query="SELECT * FROM `register_entrance`
				WHERE `date` between '".$startDate."' And '".$endDate." 23:59:59' And 
				`register_entrance`.`unlockFrom` = '".$unlockFrom."' 
				ORDER BY id DESC";
	$result = mysqli_query($conn, $query);
//	echo "query====$query===";
	$logg_all="";

	 if ($result && mysqli_num_rows($result) > 0) {
		$logg_all .= '<table width=100%><tr><th colspan="11" class="th-top h5"> <b>Влизания/Чекиране на врата</b>, брой записи : '.mysqli_num_rows($result);
		
		if ( $UID != "" or $chipOwnerName != "" or $doorId != "" or $unlockFrom != "" )
			$logg_all .= '				<a href="/index.php?m=11&UID=&chipOwnerName=" class="float-right ml-5 btn btn-secondary">Изчисти филтър</a>';
						
		$logg_all .= '</th></tr>';
		$logg_all .= '<tr>  <th width=5% >Номер</th>
							<th width=15%>Дата на посещение</th>
							<th width=15%>Действие</th>
							<th width=15%>Номер на врата</th>
							<th width=15%>Влизане от</th>
							<th width=15%>Индентификатор</th>
							<th width=10%>Име</th>
							</tr>';
		   while ($row1 = mysqli_fetch_assoc($result) ) {
				$logg_all	.= '<tr>';	  	      		
				$logg_all	.= '<td>'.$row1['id'].'</td>';
				$logg_all	.= '<td>'.$row1['date'].'</td>';
				$logg_all	.= '<td style="text-align:center"">';

				$logg_all	.= getEntranceStatusLabel ($row1['action']);
					
				$logg_all	.= '</td>';
				$logg_all	.= '<td><a href="/index.php?m=11&doorid='.$row1['door_id'].'">'.$row1['door_id'].'</a></td>';

				$logg_all	.= '<td><a href="/index.php?m=11&unlockFrom='.$row1['unlockFrom'].'">'.$row1['unlockFrom'].'</a></td>';

				$logg_all	.= '<td><a href="/index.php?m=11&UID='.$row1['UID1'].'-'.$row1['UID2'].'-'.$row1['UID3'].'-'.$row1['UID4'].'">'.$row1['UID1'].'-'.$row1['UID2'].'-'.$row1['UID3'].'-'.$row1['UID4'].'</a></td>';
				$logg_all	.= '<td>';
				
				$logg_all	.='<a href="/index.php?m=11&chipOwnerName='.$row1['chipOwnerName'].'">'.$row1['chipOwnerName'].'</a>';
					
				$logg_all	.= '</td>';
				


				$logg_all	.= '</tr>';
		 }
		 mysqli_free_result($result);
		 $logg_all	.= '</table>';
	}
	
	return $logg_all;
} 

?>


