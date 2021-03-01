<?php
function showAddChipToUser($conn){

	$logg_all = '
		<div class="container ">
			<div class=" w-100 pl-2 text-black rounded ">';
	$action 	= "";
	$id 		= "0";
	$userid		= "";
	$deleted	= "";
	$cardid		= "";
	$chipOwnerName = "";

	// Прочитаме параметри от линк-а
	if ( isset($_GET['action'] ) )
		$action = $_GET["action"];
	if ( isset($_GET['cardid'] ) )
		$cardid = $_GET["cardid"];
	if ( isset($_GET['userid'] ) )
		$userid = $_GET["userid"];
	if ( isset($_GET['chipOwnerName'] ) )
		$chipOwnerName = $_GET["chipOwnerName"];

	// Проверява дали да показва таблица или да извършва промяна
	if ( $action != '' and $cardid != "" and $userid != "" ) {

		// Проверяват се входните данни
		if ( $action == "act" and checkInt($cardid)=='' and checkInt($userid)=='' and checkText($chipOwnerName)=='' ) {
			$query = "UPDATE `chips`.`allowchips` SET userid='".addslashes($userid)."', chipOwnerName='".addslashes($chipOwnerName)."', `date_modify`=now() WHERE id='".addslashes($cardid)."'";
			$result = mysqli_query($conn, $query);
			if ( mysqli_affected_rows($conn) ) {
				// Успешно променен статус на потребител

				$logg_all .= '<div class=" w-100 mt-5 p-5 text-white bg-secondary d-flex align-items-center justify-content-center rounded ">';
				$logg_all .= '<div class="w-50 h5  round">';
				$logg_all .= '<label class="d-flex align-items-center justify-content-center">Успешно променихте данни за потребителя.</label></div>';
				$logg_all .= '<div class="w-50 h5  round">';
				$logg_all .= '<form name="continue" action="index.php?m=9" method="post" class="row g-3">';
				$logg_all .= '	<button type="submit" class="btn btn-dark px-5 py-2 btn-lg mx-auto" name="continue" value="Продължи" id=submit1>Продължи</button></div>';
				$logg_all .= '</div></form></div>';
			}
		}
	} else {

		$startDate="2020-05-05";
		$endDate=date("Y-m-d");
			$query="SELECT * FROM `users` WHERE `registerDate` between '".$startDate." 00:00:00' And '".$endDate." 23:59:59' AND deleted<>'yes' AND userType>=1";
			$result = mysqli_query($conn, $query);

		
		if ($result && mysqli_num_rows($result) > 0) {
			$logg_all .= '<br><b>Ще добавите карта/чип с номер ('.$cardid.')</b><br><br>';
			$logg_all .= '<table width=100%><tr><th colspan="11" class="th-top"> <b>Потребители</b>, показват се само регистрирани и неизтрити потребители. Брой записи : '.mysqli_num_rows($result).'</th></tr>';
			$logg_all .= '<tr>  <th width=5%  >номер</th>
								<th width=15% style="text-align:left">Потребителско име</th>
								<th width=15% style="text-align:left">Истинско име</th>
								<th width=15% style="text-align:left">Електронна поща</th>
								<th width=10% >Действие</th>
								</tr>';
								
			while ($row1 = mysqli_fetch_assoc($result) ) {
				if ( $row1['deleted'] == 'yes' )
					$logg_all	.= '<tr style="color:white; background:DarkRed">';
				else
					$logg_all	.= '<tr>';

					$logg_all	.= '<td>'.$row1['id'].'</td>';
					$logg_all	.= '<td style="text-align:left" >'.$row1['username'].'</td>';
					$logg_all	.= '<td style="text-align:left" >'.$row1['realName'].'</td>';
					$logg_all	.= '<td style="text-align:left" >'.$row1['mail'].'</td>';
				
						$logg_all	.= '<td>
										<a href="index.php?m=15&action=act&cardid='.$cardid.'&userid='.$row1['id'].'&chipOwnerName='.$row1['username'].'" class="btn btn-secondary w-100" >
										Добави карта/чип</a></td>';
					$logg_all	.= '</tr>';
			}
			mysqli_free_result($result);
			$logg_all	.= '</table>';
		}

	}
	$logg_all	.= '</div></div>';
	return $logg_all;
}
?>


