<?php
function showAllowChips($conn){

	$logg_all = '<div class="container ">
					<div class=" w-100 p-2 text-black rounded ">';

	// Прави справка за ново разрешени чипове за дадения период 
	$fromDate	= "2020-05-05";
	$toDate		= date("Y-m-d");
	$logg_all  .= getAllowChips( $fromDate,$toDate, $conn );

	$logg_all  .= '</div></div>';
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
	$chipID 		= "0";
	$action 		= "";
	$logg_all		= "";
	$currentLevel 	= "";
	
	if ( isset($_POST['chipID'] ) )
		$chipID = $_POST['chipID'];
	if ( isset($_GET['chipID'] ) )
		$chipID = $_GET['chipID'];
	if ( isset($_POST['action'] ) )
		$action = $_POST["action"];
	if ( isset($_GET['action'] ) )
		$action = $_GET["action"];
	if ( isset($_GET['currentLevel'] ) )
		$currentLevel = $_GET["currentLevel"];

	if ( $action == 'delete'){
	 	if(checkInt($chipID) == "") {
			$query = "UPDATE `chips`.`allowchips` SET `userid`='0', `chipOwnerName`='', `date_modify`=now() WHERE id='".addslashes($chipID)."'";
			$result = mysqli_query($conn, $query);
			if ( mysqli_affected_rows($conn) ) {
				// Успешно променен статус на потребител
				$logg_all .= '<br><b>Успешно изтрихте карта/чип с номер '.$chipID.'</b><br><br>';
			}

		} else 
			$logg_all .= 'Грешни параметри. Не може да бъде изтрит карта/чип с номер '.$chipID;
	} else if ( $action == 'incrementLevel'){
	 	if ( checkInt($chipID) == "" and checkInt($currentLevel) == "" ) {
			if ( $currentLevel >= 3 )
				$currentLevel = 0;
			else
				$currentLevel++;
			$query = "UPDATE `chips`.`allowchips` SET `Level`='".addslashes($currentLevel)."' WHERE id='".addslashes($chipID)."'";
			$result = mysqli_query($conn, $query);
		} else 
			$logg_all .= 'Грешни параметри. Не може да бъде изтрит карта/чип с номер '.$chipID;
	}


	$query  = "SELECT * FROM `allowchips` WHERE `date_create` between '".$startDate." 00:00:00' And '".$endDate." 23:59:59' ORDER BY date_modify DESC";
	$result = mysqli_query($conn, $query);
	if ($result && mysqli_num_rows($result) > 0) {
		$logg_all .= '<table width=100%><tr><th colspan="12" style="text-align:center" class="th-top h5"> <b>Разрешени чипове</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
		$logg_all .= '<tr>  <th width=5%  >Номер</th>
							<th width=15% style="text-align:left">Дата въвеждане</th>
							<th width=15% style="text-align:left">Последно активен</th>
							<th width=15% style="text-align:left" >Индентификатор на чип</th>
							<th width=10% >Потребителски номер</th>
							<th width=10% >Притежател на чип</th>
							<th width=10% >Ниво на достъп</th>
							<th width=10% >Действие</th>
							</tr>';
		   while ($row1 = mysqli_fetch_assoc($result) ) {
				$logg_all	.= '<tr>';
				$logg_all	.= '<td >'.$row1['id'].'</td>';
				$logg_all	.= '<td style="text-align:left"">'.$row1['date_create'].'</td>';
				$logg_all	.= '<td style="text-align:left" >'.$row1['date_modify'].'</td>';
				$logg_all	.= '<td style="text-align:left">'.$row1['UID1'].'-'.$row1['UID2'].'-'.$row1['UID3'].'-'.$row1['UID4'].'</td>';
				$logg_all	.= '<td>'.$row1['userid'].'</td>';
				$logg_all	.= '<td>'.$row1['chipOwnerName'].'</td>';

				$logg_all	.= '<td>'.$row1['Level'];
				
				// Ако е АДМИН -> показва бутон за промяна LEVEL на точи чип
				if ( $_SESSION['userType']==$GLOBALS['userTypeAdmin'] )
					$logg_all	.= '<a href="index.php?m=9&action=incrementLevel&chipID='.$row1['id'].'&currentLevel='.$row1['Level'].'">
										<img src="img/plusOne_v3_25x25.png" style="opacity: 0.3;" height=25px width=25px>
									</a></td>';

				if($row1['userid']==0){
					$logg_all	.= '<td><a href="index.php?m=15&cardid='.$row1['id'].'" class="btn btn-secondary w-100">+ Добави потребител</a></td>';
				}else{
					$logg_all	.= '<td><button type="submit" class="btn btn-danger w-100"  id="'.$row1['id'].'" data-toggle="modal"  data-target="#exampleModalCenter">
									Изтрий чип - '.$row1['id'].'</button></td>';
				}
				
		}
		mysqli_free_result($result);
		$logg_all	.= '</table>';

		$logg_all   .='
		
	  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		  <div class="modal-content">
		  <form method="POST" action="index.php?m=9">
			<div class="modal-header">
			  <h5 class="modal-title" id="exampleModalLongTitle">Внимание!</h5>
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body"> 
				<h6 id="modal_body"></h6> 
			</div> 
			<div class="modal-footer">
			  <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
			  <input type="submit" class="btn btn-danger" name="submit5" value="Изтрий">
			  <input type="hidden" name="chipID" id="chipID">
			  <input type="hidden" name="action" id="action">
			</div>
		   </form>
		  </div>
		</div>
	  </div>';

 
	} 			

return $logg_all;
} 
?>