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
include ($libdir."vhod.php");
include ($libdir."registrirai_se.php");
include ($libdir."kontakti.php");
include ($libdir."za_nas.php");
include ($libdir."pravila.php");
include ($libdir."izhod.php");
include ($libdir."profil.php");
include ($libdir."potrebiteli.php");
include ($libdir."potvarzdenie.php");
include ($libdir."allowCards.php");
include ($libdir."register_entrance.php");
include ($libdir."spravki.php");

include ($libdir."electronnaBravaZaklucvane.php");
include ($libdir."electronnaBravaControl.php");


getPostIfSet(array('m'));
if (!isset($m)){
	$m=0;
}
session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth']==true && $_SESSION['lifetime'] > time()) {
	// Ако е логнат потребител - опреснява времето, за да НЕ го разлогне
	$_SESSION['lifetime']=time()+ 60*30;		// ДА СЕ ПРОВЕРИ ВРЕМЕТО - сега е 30 минути   30*60
	
	// Проверява дали данните за сесията са коректни
	if ( isset($_POST['userid'] ) or isset ($_GET['userid'] ) )
		if ( checkInt($_SESSION['userid']) != "" ) {
			logout ();
			return;
		}

	
} else {
	// Ако е логнат потребител, ще го разлогне, поради изтичане на време
	if ( isset($_SESSION['lifetime']) and $_SESSION['lifetime'] < time() ) {
		logout ();
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
	$main_form = check_in ($conn);
}else if( $m==5 and isset($_SESSION['auth']) && $_SESSION['auth']==true ){
	$main_form = change_profile ($conn);
}else if( $m==6 ){
	$main_form = regsiter_in ($conn);
}else if( $m==65 ){
	$main_form = pravila ();
}else if( $m==66 ){
	getPostIfSet(array('mail1','keyss'));
	$main_form = potvarzdenie ($mail1, $keyss, $conn);
}else if($m==7){
	$main_form = contact_us ();	
}else if($m==8){
	$main_form = about_us ();	
}else if($m==10){
	$main_form = check_out ();
}else if($m==13 and isset($_SESSION['auth']) && $_SESSION['auth']==true and $_SESSION['userType']==$userTypeAdmin){
	$main_form = show_potrebiteli($conn);
}else if($m==101 ){
	$main_form = show_bravi();
}else if($m==102 ){
	$main_form = show_control();
}else if($m==9){
	$main_form=show_allow_cards($conn);
}else if($m==11){
	$main_form=show_regsiter($conn);
}else if($m==12){
	$main_form=show_spravki($conn);
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