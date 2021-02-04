<?php

$libdir="./../save_dir/";		// Директория с файлове, които да НЕ са достъпни през WEB
$logg = "";
$user_id=-1;
$user_level=0;
$main_form = "";
$userTypeAdmin = 2;		// Администратор - има всички права

$username5	= "";
$pass1		= "";
$pass2		= "";
$mail1		= "";
$mail2		= "";
$send_button= "";
$realName	= "";
$userInput	= "";
$answer1	= "";

include ($libdir."functions.php");
include ($libdir."defines.php");
include ($libdir."database.php");
//include ($libdir."vars.php");
include ($libdir."menu.php");
include ($libdir."registration.php");
include ($libdir."contacts.php");
include ($libdir."aboutUs.php");
include ($libdir."rules.php");
include ($libdir."logOut.php");
include ($libdir."changeProfile.php");
include ($libdir."users.php");
include ($libdir."verification.php");
include ($libdir."allowChips.php");
include ($libdir."registerEntrance.php");
include ($libdir."spravki.php");
include ($libdir."unlocking.php");
include ($libdir."showAddChipToUser.php");
include ($libdir."deleteUsers.php");
include ($libdir."forgottenPassword.php");
include ($libdir."logIn.php");

include ($libdir."showControl.php");
include ($libdir."showBravi.php");


getPostIfSet(array('m'));
if (!isset($m)){
	$m=0;
}
session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth']==true && $_SESSION['lifetime'] > time()) {
	// Ако е логнат потребител - опреснява времето, за да НЕ го разлогне
	$_SESSION['lifetime']=time()+ 60*30;		// ДА СЕ ПРОВЕРИ ВРЕМЕТО - сега е 30 минути   30*60
	

$_GET = array_map("za6titi", $_GET);
$_POST = array_map("za6titi", $_POST);
$_SESSION = array_map("za6titi", $_SESSION);
$_COOKIE = array_map("za6titi", $_COOKIE);
$_SERVER = array_map("za6titi", $_SERVER);


	// Проверява дали данните за сесията са коректни
	if ( isset($_POST['userid'] ) or isset ($_GET['userid'] ) )
		if ( checkInt($_SESSION['userid']) != "" ) {
			logOut ();
			return;
		}

	
} else {
	// Ако е логнат потребител, ще го разлогне, поради изтичане на време
	if ( isset($_SESSION['lifetime']) and $_SESSION['lifetime'] < time() ) {
		logOut ();
	}
}

/*
$logg   = "<br>SESSION[auth]=".$_SESSION['auth'];
$logg  .= "<br>SESSION[userid]=".$_SESSION['userid'];
$logg  .= "<br>SESSION[userFullName]=".$_SESSION['userFullName'];
$logg  .= "<br>SESSION[userType]=".$_SESSION['userType'];
$logg  .= "<br>SESSION[lifeTime]=".$_SESSION['lifeTime'];
$logg  .= "<br>SESSION[userEmail]=".$_SESSION['userEmail'];
echo $logg;
*/

echo '

<!DOCTYPE html>
<html>
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css-bootstrap/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<title>Save Entrance</title>';

// Зарежда мой CSS, допълнение към bootstrap
include ("css-bootstrap/my_css.css");

echo '</head>
<body>';

if ( $m == 0 )
	// Ако няма нито един избран бутон - показва заглавна страница
	$main_form = '<br><br><br><br><br>
		<h1 class="display-3">Позволете новите технологии да охраняват Вашият дом</h1>
		<br><br><br>
		<h1 class="display-4">Бъдете в крак с времето и управлявайте Вашите имоти умно от разстояние</h1>
        ';  
else  if( $m==4 ){
	$main_form = logIn ($conn);
}else if( $m==5 and isset($_SESSION['auth']) && $_SESSION['auth']==true ){
	$main_form = changeProfile ($conn);
}else if( $m==6 ){
	$main_form = registration ($conn);
}else if( $m==65 ){
	$main_form = rules ();
}else if( $m==66 ){
	getPostIfSet(array('mail1','keyss'));
	$main_form = verification ($mail1, $keyss, $conn);
}else if($m==7){
	$main_form = contacts ();	
}else if($m==8){
	$main_form = aboutUs ();	
}else if($m==10){
	$main_form = logOut ();
}else if($m==13 and isset($_SESSION['auth']) && $_SESSION['auth']==true and $_SESSION['userType']==$userTypeAdmin){
	$main_form = showUsers($conn);
}else if($m==101 ){
	$main_form = showBravi();
}else if($m==102 ){
	$main_form = showControl();
}else if($m==9 and isset($_SESSION['auth']) && $_SESSION['auth']==true and $_SESSION['userType']==$userTypeAdmin){
	$main_form=showAllowChips($conn);
}else if($m==11 and isset($_SESSION['auth']) && $_SESSION['auth']==true and $_SESSION['userType']==$userTypeAdmin){
	$main_form=showRegsiterEntrance($conn);
}else if($m==12 and isset($_SESSION['auth']) && $_SESSION['auth']==true and $_SESSION['userType']==$userTypeAdmin){
	$main_form=showSpravki($conn);
}else if($m==14 and isset($_SESSION['auth']) && $_SESSION['auth']==true and $_SESSION['userType']>='1'){
	$main_form=showUnlocking($conn);
}else if($m==15 and isset($_SESSION['auth']) && $_SESSION['auth']==true and $_SESSION['userType']==$userTypeAdmin){
	$main_form=showAddChipToUser($conn);
}else if($m==16 and isset($_SESSION['auth']) && $_SESSION['auth']==true and $_SESSION['userType']==$userTypeAdmin){
	$main_form=showDeleteUsers($conn);
}else if($m==17){
	$main_form=showForgottenPassword($conn);
}

// Взима responsive меню, след като направи проверка дали сме или НЕ сме логнати и какви права има дадения потребител
$menu = get_menu();	

// Печата менюто
echo $menu;

// Печата главната форма под менюто
echo $main_form;		


//	include ($libdir."bottom.php");		// Тук още мислим дали да има bottom_menu


//echo '</center>';




// Следват няколко скрита за взимане на резолюцията на екрана - все още не се ползват в програмата
?>
    <script>
    function getResolution1() {
        alert("Your screen resolution is: " + window.screen.width * window.devicePixelRatio + "x" + window.screen.height * window.devicePixelRatio);
    }
    function getResolution2() {
        alert("Your screen resolution is: " + screen.width + "x" + screen.height);
    }
    </script>
     
   <!-- <button type="button" onclick="getResolution1();">Get Resolution1</button>
<button type="button" onclick="getResolution2();">Get Resolution2</button>-->

<script language="Javascript">
<!--
document.write('<br>your resolution is'.screen.width+'x'+screen.height)
//-->
</script> 


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js-bootstrap/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="js-bootstrap/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="js-bootstrap/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>