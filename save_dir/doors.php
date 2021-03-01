<?php
function showDoors($conn){

	$logg_all = '<div class="container ">
					<div class=" w-100 p-2 text-black rounded ">';

//	$fromDate	= "2020-05-05";
//	$toDate		= date("Y-m-d");
	$logg_all  .= getDoors($conn);

	$logg_all  .= '</div></div>';
	return $logg_all	;
}

function getDoors ($conn){
	$logg_all		= "";

	if ( isset($_POST['door_id'] ) )
		$door_id = $_POST["door_id"];
	if ( isset($_POST['submit'] ) ) {
		$submit = $_POST["submit"];

		$textAr = explode(".", $_SERVER['REMOTE_ADDR']);
		$textAr = array_filter($textAr, 'trim'); 
		$chip_id1 = $textAr[0];
		$chip_id2 = $textAr[1];
		$chip_id3 = $textAr[2];
		$chip_id4 = $textAr[3];
			
		$enterFrom = 'enterFrom_'.$GLOBALS['deviceType'];
		$query = "INSERT INTO `register_entrance` (`id`, `date`, `UID1`,`UID2`,`UID3`,`UID4`,`allow`,`action`,`door_id`) values ('', now(), '$chip_id1','$chip_id2','$chip_id3','$chip_id4','yes', '$enterFrom', '$door_id')";
		$result = mysqli_query($conn, $query);
		if (!$result) {
			$logg1 .= "<br><br>Invalid ... Грешка 91923.<br><br>";
			echo('<br><br>Invalid ... Грешка 91923.<br><br>');
		} else {
			// All OK
			echo "<br>@#*;Writing in register_entrance OK.Coord";
			$logg1 .= "<br>@@@Writing in register_entrance OK.Coord";
		}



		if ( $door_id == 1 ) {
			header('Location: http://46.10.208.174:7715/unlock_Owekde3okqE');
			exit;
		}
	}
	if ( isset($_POST['submit2'] ) ) {
		$submit2 = $_POST["submit2"];
		if ( $door_id == 1 ) {
			header('Location: http://46.10.208.174:7715/ReadAllowCards_BdgWDSdxenDAW93_2');
			exit;
		}
		
	}

//	$query  = "SELECT * FROM `doors`";
	$query  = "SELECT *,MINUTE (TIMEDIFF(now(),date_modify)) as min_diff,HOUR (TIMEDIFF(now(),date_modify)) as hour_diff FROM `Doors` WHERE `Level`<='3'";
	$result = mysqli_query($conn, $query);
	if ($result && mysqli_num_rows($result) > 0) {
		$logg_all .= '<table width=100%><tr><th colspan="12" style="text-align:center" class="th-top h5"><b>Врати</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
		$logg_all .= '<tr>  <th width=15%  >Врата Номер</th>
							<th width=25% style="text-align:left">Описание</th>
							<th width=5%>Валиден</th>
							<th width=15%>Статус</th>
							<th width=10%>Ниво</th>
							<th width=15% style="text-align:left">IP адрес</th>
							<th width=25%>Последен запис</th>
							<th >Действие</th>
							</tr>';
			while ($row1 = mysqli_fetch_assoc($result) ) {
				$logg_all	.= '<tr>';
				$logg_all	.= '<td >'.$row1['id'].'</td>';
				$logg_all	.= '<td style="text-align:left"">'.$row1['description'].'</td>';
				$logg_all	.= '<td>'.$row1['isValid'].'</td>';
				
				$all_minutes = $row1['hour_diff']*60+$row1['min_diff'];	// Пресмята общо минути

				$doorStatus = getDoorStatusLabel ( $row1['state'], $all_minutes );
				$logg_all	.= '<td>'.$doorStatus.'</td>';				
				
				$logg_all	.= '<td>'.$row1['Level'].'</td>';
				$logg_all	.= '<td style="text-align:left"">'.$row1['ip_address'].'</td>';

				$logg_all	.= '<td>преди '.$all_minutes.' минути</td>';

				if ( $doorStatus != "няма връзка" ) {		// Ако няма връзка с тази брава - НЕ показва бутоните за управление
					$logg_all 	.= '<form name="continue" action="index.php?m=19" method="post" class="row g-3">';
					$logg_all	.= '<input type="hidden" name="door_id" id="door_id" value="'.$row1['id'].'">';
					$logg_all	.= '<td><input type="submit" class="btn btn-secondary w-100 mt-1 mb-1"  id="'.$row1['id'].'" name="submit"  value="Отключи">
										<input type="submit" class="btn btn-secondary w-100"  id="'.$row1['id'].'" name="submit2" value="Опресни информация за чипове">
									</td></form>';
				} else 
					$logg_all	.= '<td></td>';
			}
			$logg_all	.= '</table>';
		$logg_all	.= 'Ако не виждате бутони в колона ДЕЙСТВИЕ, управлението на вратата няма връзка с интернет.';
	}
	return $logg_all;
}
?>