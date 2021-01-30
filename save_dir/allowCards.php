<?php
function show_allow_cards($conn){

	$logg_all = '
		<div class="container border">
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

			$result = mysqli_query($conn, "SELECT * from allowCards ORDER BY id ASC");

     		if ($result && mysqli_num_rows($result) > 0) {
				$logg_all .= '<table width=100%><tr><th colspan="11" style="text-align:center" class="th-top"> <b>Разрешени чипове</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
				$logg_all .= '<tr>  <th width=5%  >номер</th>
									<th width=15% style="text-align:left">Дата въвеждане</th>
									<th width=15% style="text-align:left">Последно активен</th>
                                    <th width=15% >Действие</th>
                                    <th width=5%  >UID1</th>
									<th width=5%  >UID2</th>
									<th width=5%  >UID3</th>
									<th width=5%  >UID4</th>
                                    <th width=10% >Разрешен</th>
                                    <th width=10% >userid</th>
                                    <th width=10% >chipOwnerName</th>
									</tr>';
	   			while ($row1 = mysqli_fetch_assoc($result) ) {
						$logg_all	.= '<tr>';
						$logg_all	.= '<td >'.$row1['id'].'</td>';
						$logg_all	.= '<td style="text-align:left"">'.$row1['date_create'].'</td>';
						$logg_all	.= '<td style="text-align:left" >'.$row1['date_modify'].'</td>';
						$logg_all	.= '<td>'.$row1['action'].'</td>';
						$logg_all	.= '<td>'.$row1['UID1'].'</td>';
                        $logg_all	.= '<td>'.$row1['UID2'].'</td>';
                        $logg_all	.= '<td>'.$row1['UID3'].'</td>';
                        $logg_all	.= '<td>'.$row1['UID4'].'</td>';
                        $logg_all	.= '<td>'.$row1['allow'].'</td>';
                        $logg_all	.= '<td>'.$row1['userid'].'</td>';
                        $logg_all	.= '<td>'.$row1['chipOwnerName'].'</td>';
                }
            } 			
			mysqli_free_result($result);
			$logg_all	.= '</table>';
			$logg_all	.= '</div></div>';
		return $logg_all	;
		
	}
}
?>