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
		if ( $userType >x $GLOBALS["userTypeAdmin"] )	// Ако е достигнал лимит за админ, сваля го на НУЛА
			$userType = 0;
		$query_param = "userType= '".$userType."' ";
	}
	//if ( $action == "act" and isset($_GET['sendEmail'] ) )

		if ( $action == "act" and isset($_GET['deleted'] ) )
		$query_param = "deleted= '".$deleted."' ";
	*/
	$mySelect="";
	
	if ( isset($_POST['mySelect'] ) )
		$mySelect = $_POST["mySelect"];

			$logg_all .= '<form name="reloadForm" action="" method="post" >';
			$logg_all .= 'Изберете период за справка : ';

			// Падащо меню за избор на период преди днешния ден
			$mySelect_array = array("1 ден","1 седмица","1 месец","3 месеца");
			$logg_all .= '<select class="select-css" id="mySelect" name="mySelect" onchange="myFunction()" >';
			foreach($mySelect_array as $sOption){
				$logg_all .= '<option value="'.$sOption.'" ';
				if ( $mySelect == $sOption )
					$logg_all .= 'selected';
				$logg_all .= '>'.$sOption.'</option>';
			}
			$logg_all .= '</select>
						<button type="submit" hidden >
							..:: Покажи данни за периода ::..
						</button>
						</form>';

			// Според избраното от падащото меню се изчислява началото на периода
			$dDays = "";
			if ( $mySelect == "3 месеца")
				$dDays = "90";
			else if ( $mySelect == "1 месец")
				$dDays = "30";
			else if ( $mySelect == "1 седмица")
				$dDays = "7";
			else if ( $mySelect == "1 ден")
				$dDays = "1";
			else	// При първоначално зареждане 
				$dDays = "1";

			// Последно изчисляване на начало на периода, спрямо избраното от падащото меню
			$fromDate = date('Y-m-d', strtotime(date('Y-m-d'). ' - '.$dDays.' days'));

			// Прави справка за регистрирани потребители за дадения периода 
            $toDate=date("Y-m-d");
            $logg_all .= getUsers( $fromDate,$toDate, 'registerDate' , $conn)."<br>";

			// Прави справка за регистрирани потребители за дадения периода 
            $toDate=date("Y-m-d");
            $logg_all .= getUsers( $fromDate,$toDate, 'lastVisitDate' , $conn)."<br>";

			// Прави справка за потребителите, които са влизали за дадения периода
            $toDate=date("Y-m-d");
            $logg_all .= getRegisterEntrance( $fromDate,$toDate, $conn)."<br>";

			// Прави справка за ново разрешени чипове за дадения период 
			$toDate=date("Y-m-d");
			$logg_all .= getAllowChips( $fromDate,$toDate, $conn)."<br>";
			
			$logg_all	.= '</div></div>';
			$logg_all	.= '<p id="demo"></p>';
			// Функци на Javascript да опреснява страницата с новоизбраната стойност от падащото меню -> така показва новия период
			$logg_all	.= '<script>
			function myFunction() {
  				var x = document.getElementById("mySelect").value;
				document.reloadForm.submit();
			}			
			</script>';
			return $logg_all	;
}
?>