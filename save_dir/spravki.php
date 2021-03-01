<?php
function showSpravki($conn){

	$logg_all = '
		<div class="container ">
			<div class=" w-100 p-2 text-black rounded ">';
	$action 	= "0";
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

			// Прави справка за потребители посетили сайта за дадения периода 
            $toDate=date("Y-m-d");
            $logg_all .= getUsers( $fromDate,$toDate, 'lastVisitDate' , $conn)."<br>";

			// Прави справка за потребителите, които са влизали за дадения периода
            $toDate=date("Y-m-d");
            $logg_all .= getRegisterEntrance( $fromDate,$toDate, $conn)."<br>";

			// Прави справка за ново разрешени чипове за дадения период 
			$toDate=date("Y-m-d");
			$logg_all .= getAllowChips( $fromDate,$toDate, $conn)."<br>";
			
			// Показва врати, статус на всички
			$logg_all .= getDoors($conn)."<br>";
			
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