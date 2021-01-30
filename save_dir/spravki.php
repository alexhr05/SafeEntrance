<?php
function show_spravki($conn){

	$logg_all = '
		<div class="container ">
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
	//if ( $action == "act" and isset($_GET['sendEmail'] ) )

		if ( $action == "act" and isset($_GET['deleted'] ) )
		$query_param = "deleted= '".$deleted."' ";
	*/
	
    $action 	= "0";		// Показва таблицата винаги	
	if ( $action == "0" ) {	// Няма избрано действие - листва таблицата
            $query='SELECT * FROM `users` WHERE month(registerDate)=Month(now()) AND day(registerDate)=day(now())';
			$result = mysqli_query($conn, $query);

     		if ($result && mysqli_num_rows($result) > 0) {
				$logg_all .= '<table width=100%><tr><th colspan="11" class="th-top"> <b>Регистрирани днес</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
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
											активиран</a></td>';
						



						$logg_all	.= '</tr>';
     			}
     		}
			mysqli_free_result($result);
			$logg_all	.= '</table><br><br>';
            
            
            $query='SELECT * FROM `users` WHERE month(lastVisitDate)=Month(now()) AND day(lastVisitDate)=day(now())';
			$result = mysqli_query($conn, $query);

     		if ($result && mysqli_num_rows($result) > 0) {
				$logg_all .= '<table width=100%><tr><th colspan="11" class="th-top"> <b>Потребители за деня</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
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
											активиран</a></td>';
						



						$logg_all	.= '</tr>';
     			}
     		}
			mysqli_free_result($result);
            $logg_all	.= '</table><br><br>';
            


            $query='SELECT * FROM `register_entrance` WHERE month(date)=Month(now()) AND day(date)=day(now())';
			$result = mysqli_query($conn, $query);

     		if ($result && mysqli_num_rows($result) > 0) {
				$logg_all .= '<table width=100%><tr><th colspan="11" class="th-top"> <b>Чекирания за днес</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
				$logg_all .= '<tr>  <th width=5%>номер</th>
									<th width=15%>date</th>
									<th width=15%>aciton</th>
									<th width=15%>door_id</th>
									<th width=15%>UID1</th>
									<th width=15%>UID2</th>
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
     		}
			mysqli_free_result($result);
			$logg_all	.= '</table>';









			$logg_all	.= '</div></div>';

		return $logg_all	;
		
	}
	
}
?>