<?php

function za6titi($tekst) {
	//echo "<br>($tekst)";
	if ( (int)$tekst )
		return $tekst;
	else {
		$tekst = addslashes($tekst);
		$tekst = htmlspecialchars($tekst, ENT_NOQUOTES);
	
		return $tekst;
	}
}

// Проверка дали има забранени символи в username
function checkUsername($username5) 
{
	if ( $username5 == "" )
		return "Полето е празно.";

	if ( strlen ( $username5) <= 3 )
		return "Въведеното потребителско име е с прекалено малко символи. Въведете повече от 3 символа.";
	
	if ( strlen ( $username5) >= 50 )
		return "Въведената потребителско име е прекалено дълго. Трябва да бъде по-малко от 50 символа.";
	
	$possible = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789-_!@#$+.";
	$bAllowUsername = true;
	$i = 0;
	while ($i < strlen ($username5) ) {
		if ( !strstr($possible, $username5[$i] ) )
			$bAllowUsername = false;
		$i++;
	}
	
	if ( !$bAllowUsername )
		return "В полето има забранени символи. Може да ползвате всички букви на латиница, цифри и символите: ! @ # _ - +";
	else
		return "";
}

// Проверка дали има забранени символи в password
function checkPassword($pass5) 
{
	if ( $pass5 == "" )
		return "Полето е празно.";

	if ( strlen ( $pass5) <= 1 )
		return "Въведената парола е прекалено кратка. Трябва да бъде над 8 символа.";

	if ( strlen ( $pass5) >= 50 )
		return "Въведената парола е прекалено дълга. Трябва да бъде по-малко от 50 символа.";
	
	$possible = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789-_!@#$+.";
	$bAllowUsername = true;
	$i = 0;
	while ($i < strlen ($pass5) ) {
		if ( !strstr($possible, $pass5[$i] ) ) {
			$bAllowUsername = false;
			echo "($pass5[$i])";
		}
		$i++;
	}

	if ( !$bAllowUsername )
		return "В полето има забранени символи. Може да ползвате всички букви на латиница, цифри и символите: ! @ # _ - +";
	else
		return "";
}

function checkRealName($RealName) 
{
	if ( $RealName == "" )
		return "Полето е празно.";

	if ( strlen ( $RealName) <= 3 )
		return "Въвели сте прекалено малко символи.";

	if ( strlen ( $RealName) >= 68 )
		return "Въвели сте прекалено много символи. Разрешени са максимум 50 символа.";

	$possible = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789-_!@#$+.абвгдежзийклмнопрстуфхцчшщъьюяАБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЬЮЯ";
	$bAllowUsername = true;
	$i = 0;
	while ($i < strlen ($RealName) ) {
		if ( !strstr($possible, $RealName[$i] ) )
			return false;
		$i++;
	}
	if ( !$bAllowUsername )
		return "В полето има забранени символи. Може да ползвате всички букви на кирилица, латиница, цифри и символите: ! @ # _ - +";
	else
		return "";
}

function checkText($Text) 
{
	if ( $Text == "" )
		return "Полето е празно.";

	if ( strlen ( $Text) <= 3 )
		return "Въвели сте прекалено малко символи.";

	if ( strlen ( $Text) >= 68 )
		return "Въвели сте прекалено много символи. Разрешени са максимум 50 символа.";

	$possible = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789-_!@#$+.абвгдежзийклмнопрстуфхцчшщъьюяАБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЬЮЯ";
	$bAllowUsername = true;
	$i = 0;
	while ($i < strlen ($Text) ) {
		if ( !strstr($possible, $Text[$i] ) )
			return false;
		$i++;
	}
	if ( !$bAllowUsername )
		return "В полето има забранени символи. Може да ползвате всички букви на кирилица, латиница, цифри и символите: ! @ # _ - +";
	else
		return "";
}


function checkEmail($mail1) 
{
	if ( $mail1 == "" )
		return "Полето е празно.";

	if ( strlen ( $mail1) <= 6 )
		return "Въвели сте прекалено малко символи.";

	if ( strlen ( $mail1) >= 68 )
		return "Въвели сте прекалено много символи. Разрешени са максимум 70 символа.";

	if (!filter_var($mail1, FILTER_VALIDATE_EMAIL))
		return "Въведеният електронен адрес не е разпознат като реален.";

	$possible = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789-_!@#$+.";
	$bAllowEmail = true;
	$i = 0;
	while ($i < strlen ($mail1) ) {
		if ( !strstr($possible, $mail1[$i] ) )
			$bAllowEmail = false;
		$i++;
	}
	if ( !$bAllowEmail )
		return "В полето има забранени символи. Може да ползвате всички букви на латиница, цифри и символите: ! @ # _ - +";
	else
		return "";
}

// Проверка дали има забранени символи в checkUserOrMail
function checkUserOrMail($username5) 
{
	if ( $username5 == "" )
		return "Полето е празно.";

	if ( strlen ( $username5) <= 3 )
		return "Въведеното потребителско име е с прекалено малко символи. Въведете повече от 3 символа.";
	
	if ( strlen ( $username5) >= 50 )
		return "Въведената потребителско име е прекалено дълго. Трябва да бъде по-малко от 50 символа.";
	
	$possible = "AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789-_!@#$+.";
	$bAllowUsername = true;
	$i = 0;
	while ($i < strlen ($username5) ) {
		if ( !strstr($possible, $username5[$i] ) )
			$bAllowUsername = false;
		$i++;
	}
	
	if ( !$bAllowUsername )
		return "В полето има забранени символи. Може да ползвате всички букви на латиница, цифри и символите: ! @ # _ - +";
	else
		return "";
}


function checkInt($userInput) {
	if ( $userInput == "" )
		return "Полето е празно.";

	$possible = "0123456789";
	$bAllowEmail = true;
	$i = 0;
	while ($i < strlen ($userInput) ) {
		if ( !strstr($possible, $userInput[$i] ) )
			$bAllowEmail = false;
		$i++;
	}
	if ( !$bAllowEmail )
		return "В полето има забранени символи. Може да въвеждате само цифри.";
	else
		return "";
}

function logout () {
 		unset($_SESSION['auth']);
		unset($_SESSION['userid']);
		unset($_SESSION['userFullName']);
		unset($_SESSION['userType']);
		unset($_SESSION['lifetime']);
		unset($_SESSION['userEmail']);
		$m=0;
}

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}


function getPostIfSet($test_vars)
{
        if (!is_array($test_vars)) {
                $test_vars = array($test_vars);
        }
        foreach($test_vars as $test_var) {
                if (isset($_POST[$test_var])) {
                        global $$test_var;
                        $$test_var = $_POST[$test_var];
                } elseif (isset($_GET[$test_var])) {
                        global $$test_var;
                        $$test_var = $_GET[$test_var];
                } else {
                    $$test_var = "";
                }
        }
}

function getpost_ifset_with_result($test_vars)
{
    $result = true;
        if (!is_array($test_vars)) {
                $test_vars = array($test_vars);
        }
        foreach($test_vars as $test_var) {
                if (isset($_POST[$test_var])) {
                    global $$test_var;
                    $$test_var = $_POST[$test_var];
                } elseif (isset($_GET[$test_var])) {
                    global $$test_var;
                    $$test_var = $_GET[$test_var];
                } else {
                    $result=false;
                    break;
                }
        }
        return $result;
}



function genRandomPassword($length = 8) {
                $salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                $len = strlen($salt);
                $makepass = '';
                mt_srand(10000000 * (double) microtime());

                for ($i = 0; $i < $length; $i ++) {
                        $makepass .= $salt[mt_rand(0, $len -1)];
                }

                return $makepass;
}

        
function getCryptedPassword($clearpass,$salt) {
	return md5( $clearpass . $salt );
}
  

function IsName ($string){
	if (preg_match("/^[ -_A-Za-zА-Яа-я0-9]{5,51}$/", $string))
		return true;
	else
		return false;
}  
function IsName2 ($string){
	if ( preg_match('/[\x00|\n|\r|\'|\"|\`|\\\|\x1a]/', $string) )
		return false;
	else
		return true;
}  

function IsPhone ($string){
	if (preg_match("/^[0-9]{5,15}$/", $string))
		return true;
	else
		return false;
}  



/*--------------------------------------------------------------------------------------------------------------
	getUsers	- Справка за потребители

	Входни данни:
		$startDate  - начална дата за справка - формат  '2021-01-31'
		$endDate 	- крайна дата за справка - формат  '2021-01-31'
		$conn		- параметри за връзка с mysql

	Изходни данни:
		$logg_all	- форматиран html код, който директно може да се покаже
*/
function getUsers($startDate, $endDate, $poleParam, $conn){
	$query="SELECT * FROM `users` WHERE $poleParam between '".$startDate." 00:00:00' And '".$endDate." 23:59:59'";
	$result = mysqli_query($conn, $query);
	$logg_all="";
	if ( $poleParam == 'registerDate' )
		$tablica = 'Регистрирани потребители';
	if ( $poleParam == 'lastVisitDate' )
		$tablica = 'Последни потребители на сайта';
	
	if ($result && mysqli_num_rows($result) > 0) {
		$logg_all .= '<table width=100%><tr><th colspan="11" class="th-top"> <b>'.$tablica.'</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
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
									активен</a></td>';
				$logg_all	.= '</tr>';
		}
		mysqli_free_result($result);
		$logg_all	.= '</table>';
		$logg_all	.= 'userType=0 неактивен потребител, =1 потвърдил регистрация, =2 admin.';
	}



	return $logg_all;
}

/*--------------------------------------------------------------------------------------------------------------
	getRegisterEntrance	- справка за влизание, чекиране на входни врати

	Входни данни:
		$startDate  - начална дата за справка - формат  '2021-01-31'
		$endDate 	- крайна дата за справка - формат  '2021-01-31'
		$conn		- параметри за връзка с mysql

	Изходни данни:
		$logg_all	- форматиран html код, който директно може да се покаже
*/
function getRegisterEntrance($startDate, $endDate, $conn){
	$query="SELECT * FROM `register_entrance` WHERE  `date` between '".$startDate." 00:00:00' And '".$endDate." 23:59:59'";
	$result = mysqli_query($conn, $query);
	$logg_all="";

	 if ($result && mysqli_num_rows($result) > 0) {
		$logg_all .= '<table width=100%><tr><th colspan="11" class="th-top"> <b>Влизания/Чекиране на врата</b>, брой записи : '.mysqli_num_rows($result).'</th></tr>';
		$logg_all .= '<tr>  <th width=5%>номер</th>
							<th width=15%>date</th>
							<th width=15%>aciton</th>
							<th width=15%>door_id</th>
							<th width=5%>UID1</th>
							<th width=5%>UID2</th>
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
		 mysqli_free_result($result);
		 $logg_all	.= '</table>';
	 }
	
	
	
	return $logg_all;
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
			mysqli_free_result($result);
			$logg_all	.= '</table>';
		} 			
		
		
		
		return $logg_all;
		} 

?>



