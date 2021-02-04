<?php
function showAllowChips($conn){

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
	
	// Прави справка за ново разрешени чипове за дадения период 
	$fromDate="2020-05-05";
	$toDate=date("Y-m-d");
	$logg_all .= getAllowChips( $fromDate,$toDate, $conn);
			

     	
	$logg_all	.= '</div></div>';
	return $logg_all	;
		
	
}

/*--------------------------------------------------------------------------------------------------------------
	getAllowChips	- справка за разрешени чипове

	Входни данни:
		$startDate  - начална дата за справка - формат  '2021-01-31'
		$endDate 	- крайна дата за справка - формат  '2021-01-31'
		$conn		- параметри за връзка с mysql

	Изходни данни:
		$logg_all	- форматиран html код, който директно може да се покаже
*/
function getAllowChips($startDate, $endDate, $conn){
	$query="SELECT * FROM `allowchips` WHERE `date_create` between '".$startDate." 00:00:00' And '".$endDate." 23:59:59'";
	
	// Ако началната дата за справка е 1900-00-00 , тогава прави справка и за userid
	if($startDate == "1900-00-00"){
		$query .= " AND `userid`='".$_SESSION['userid']."'";
	}
	
	$result = mysqli_query($conn, $query);
	$logg_all="";
	$submit5 = "6";
	if ($result && mysqli_num_rows($result) > 0) {
		$logg_all .= '<table width=100%><tr><th colspan="12" style="text-align:center" class="th-top"> <b>Разрешени чипове</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
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
							<th width=10% >Действие</th>
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
				if($row1['userid']==0){
					$logg_all	.= '<td><a href="index.php?m=15&cardid='.$row1['id'].'" class="btn btn-secondary w-100">+ Добави потребител</button></a></td>';
//						$logg_all	.= '<td><button type="button" class="btn btn-danger w-100"  data-target="index.php?m=15&cardid='.$row1['id'].'">Добави потребител</button></td>';
				}else{

					$logg_all	.= '<td><button type="submit" class="btn btn-danger w-100"  data-toggle="modal" value="5" name="submit5" data-target="#exampleModalCenter">
					- Изтрий потребител
				  </button></td>';




//						$logg_all	.= '<td><a href="index.php?m=15&cardid='.$row1['id'].'" class="btn btn-danger w-100">- Изтрий </a></td>';
				}
				
		}
		//mysqli_free_result($result);
		$logg_all	.= '</table>';
		$logg_all   .='
		
		<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		  <div class="modal-content">
		  <form name="continue" action="index.php?m=9" method="post">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLongTitle">Сигурен ли сте, че искате да изтриете карта/чип за потребител ('.$submit5.')</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			</form>
			
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
			  <button type="button" class="btn btn-danger" data-target="index.php?m=16&cardid=27" >Изтрий</button>
			</div>
		  </div>
		</div>
	  </div>';
	  
	} 			

return $logg_all;
} 
?>