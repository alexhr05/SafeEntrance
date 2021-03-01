<?php
function showUnlocking ($conn){
	$door_id			= 0;
	$timerToLockDoor1 	= 0;
	
	$logg_all = '
		<div class="container ">
			<div class=" w-100 p-2 text-black rounded ">';

	if ( isset($_POST['door_id'] ) )
		$door_id = $_POST["door_id"];
	if ( isset($_GET['timerToLockDoor1'] ) ) {
		$timerToLockDoor1 	= $_GET["timerToLockDoor1"];
		$door_id			= 1;
	}

	if ( isset($_POST['submit'] ) ) {
		$submit = $_POST["submit"];
		

		if ( $door_id == 1 ) {

			$textAr = explode(".", $_SERVER['REMOTE_ADDR']);
			$textAr = array_filter($textAr, 'trim'); 
			$chip_id1 = $textAr[0];
			$chip_id2 = $textAr[1];
			$chip_id3 = $textAr[2];
			$chip_id4 = $textAr[3];
			
			$query = "INSERT INTO `register_entrance` (`id`, `date`, `UID1`,`UID2`,`UID3`,`UID4`,`allow`,`action`,`unlockFrom`,`door_id`, `chipOwnerName`, `userid`) values ('', now(), '$chip_id1','$chip_id2','$chip_id3','$chip_id4','yes', 'enter','".$GLOBALS['deviceType']."', '$door_id', '".$_SESSION['userfulname']."', '".$_SESSION['userid']."')";
			$result = mysqli_query($conn, $query);
			if ($result)
				$logg_all .= "Грешка при работа с база данни.";


			header('Location: http://46.10.208.174:7715/unlock_Owekde3okqE');
			exit;

		}
	}

	$query  = "SELECT * FROM `allowchips` WHERE `userid`=".$_SESSION['userid']."";
	$result = mysqli_query($conn, $query);
	$maxLevel 	= 0;
	if ($result && mysqli_num_rows($result) > 0) {
	
			$logg_allowchips  = '<table width=100%><tr><th colspan="12" style="text-align:center" class="th-top h5"> <b>Разрешени чипове</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
			$logg_allowchips .= '<tr>  <th width=5%  >Чип Номер</th>
							<th width=15% style="text-align:left">чип идентификатор</th>
							<th width=15% style="text-align:left">Ниво</th>
							<th width=15% style="text-align:left">Последна редакция</th>
							</tr>';
			while ($row = mysqli_fetch_assoc($result) ) {
				$logg_allowchips	.= '<tr>';
				$logg_allowchips	.= '<td >'.$row['id'].'</td>';
				$logg_allowchips	.= '<td style="text-align:left"">'.$row['UID1'].':'.$row['UID2'].':'.$row['UID3'].':'.$row['UID4'].'</td>';
				$logg_allowchips	.= '<td style="text-align:left"">'.$row['Level'].'</td>';
				$logg_allowchips	.= '<td style="text-align:left"">'.$row['date_modify'].'</td>';
				
				// Взима малксималното ниво на достъп за този потребител
				if ( $row['Level'] > $maxLevel )
					$maxLevel 	= $row['Level'];
				$logg_allowchips	.= '</tr>';
			}
			$logg_allowchips	.= '</table>';
		
			if ( $GLOBALS['deviceType'] == 'PC' ) {
				$logg_all	.= $logg_allowchips;
			}


			$logg_all	.= '<br>Вие имате ниво на достъп до Врати : ('.$maxLevel.')<br><br>';

			$query  = "SELECT *,MINUTE (TIMEDIFF(now(),date_modify)) as min_diff,HOUR (TIMEDIFF(now(),date_modify)) as hour_diff FROM `Doors` WHERE `Level`<='".$maxLevel."'";
			$result = mysqli_query($conn, $query);
			if ($result && mysqli_num_rows($result) > 0) {
				$logg_all .= '<table width=100%><tr><th colspan="12" style="text-align:center" class="th-top h5"> <b>Врати</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
				$logg_all .= '<tr>  <th width=5%  >Врата Номер</th>
							<th width=15%>Описание</th>
							<th width=15%>Ниво</th>
							<th width=15%>Статус</th>
							<th width=15%>Време</th>
							<th width=15%>Действие</th>
							</tr>';

				while ($row = mysqli_fetch_assoc($result) ) {
					$logg_all	.= '<tr>';
					$logg_all	.= '<td>'.$row['id'].'</td>';
					$logg_all	.= '<td>'.$row['description'].'</td>';
					$logg_all	.= '<td>'.$row['Level'].'</td>';

					$all_minutes = $row['hour_diff']*60+$row['min_diff'];	// Пресмята общо минути
					
					$doorStatus = getDoorStatusLabel ( $row['state'], $all_minutes );
					$logg_all	.= '<td>'.$doorStatus.'</td>';				



					if ( $timerToLockDoor1 > 0 and $row['id'] == $door_id and $doorStatus == 'отворена' ) {
						echo "<script>CountDown(0);</script>";
						$logg_all	.= '<td></td>';

					} else if ( $timerToLockDoor1 > 0 and $row['id'] == $door_id and $doorStatus != 'заключена' ) {
						$logg_all	.= '<td><b><span id="output"></span></b> секунди<br> до заключване</td>';				

						echo "<script>CountDown(".$timerToLockDoor1++.");</script>";

					} else 
						$logg_all	.= '<td></td>';				

					if ( $doorStatus != "няма връзка" ) {		// Ако няма връзка с тази брава - НЕ показва бутоните за управление
						$logg_all 	.= '<form name="continue" action="index.php?m=14" method="post" class="row g-3">';
						$logg_all	.= '<input type="hidden" name="door_id" id="door_id" value="'.$row['id'].'">';
						$logg_all	.= '<td><input type="submit" class="btn btn-secondary w-100" id="'.$row['id'].'" name="submit" value="Отключи">
										</td></form>';
					} else 
						$logg_all	.= '<td></td>';
				}
				$logg_all	.= '</table>';
			}


			
			
			
			
	} else {
		$logg_all 	.= '<div class="w-75 p-4 m-4 text-white h3 bg-secondary rounded">';
		$logg_all	.= 'Няма регистрирани ключове за Вашият потребител.</div>';
	}
     	
	$logg_all	.= '</div></div>';
	return $logg_all;
		
	
}
?>