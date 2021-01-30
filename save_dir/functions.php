<?php

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



?>



