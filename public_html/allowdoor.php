<?php
//
// Изпълнява се от PC или от Телефон
// Конфигурира разрешени/забранени чипове, преглед на лог от отключвания
//


// Взима от каква операционна система се отваря сайта
if ( strpos ($_SERVER['HTTP_USER_AGENT'] , "Android") > 1 )
	$resolution2 = "1";	
if ( strpos ($_SERVER['HTTP_USER_AGENT'] , "Windows") > 1 )
	$resolution2 = "2";	
// echo "--".$_SERVER['HTTP_USER_AGENT']."+++++++($resolution2)--";


	if ( $resolution2 == "1" ) 	{		// Android - увеличава размера на шрифта
			$size_font1 = "7";
			$size_font2 = "5";
	}
	if ( $resolution2 == "2" ) 	{		// Windows - показва нормален размер шрифт
			$size_font1 = "3";
			$size_font2 = "2";
	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="bg-bg" lang="bg-bg" >
<head>
  <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="Vilata" />
  <meta name="title" content="123" />
  <meta name="author" content="456" />
  <meta name="description" content="789" />
  <meta name="generator" content="0123" />
  <title>ДА СЕ ПРОМЕНИ</title>
  <link href="/img/logo1.jpg" rel="shortcut icon" type="image/x-icon" /> 
<?php
	echo '</head><body>';
  
 
//
//	AllowDoor.php 
//
//	Показва статистики за отворена врата и разрешава определени чипове
//
//
//$libdir="../up_level/";

echo "Започва свързване към база данни.";

$libdir="./../save_dir/";
include ($libdir."functions.php");
include ($libdir."defines.php");
include ($libdir."database.php");

echo "Премина свързване към база данни.";

$logg_all = "";
$new_date_rev = "ДЕН X";

//include ("/home/bgroutin/up_level/broi2.php");

//echo '<form name="registration_fm" action="'.$PHP_SELF.'" method="post">	<table class="gradienttable" border="2" width=100% align="center">';
echo '<form name="registration_fm" action="" method="post">	<table class="gradienttable" border="2" width=100% align="center">';
echo '<table class="gradienttable" border="2" width=100% align="center">';
echo 	'<tr valign="center"><td valign="center">';
									


	// Проверка дали се ползва правилен код за достъп
//	getpost_ifset(array('nkey','chip_id1','chip_id2','chip_id3','chip_id4','allowchip', submit7, submit8, submit1072, submit1071));
	
		
		echo '<br><font size="'.$size_font2.'" color="black" face="verdana">ВКЪЩИ - Входна Врата - Конфигуриране</td></tr>';
		echo '<tr valign="center"><td valign="center">';

// ------ показва ЛОГ с отключвания ----------
//			echo "BUTON submit7 или НЕ е натиснат нито един бутон.";


		$result = mysqli_query($conn, "SELECT * from register_entrance ORDER BY id DESC limit 100");
//echo "Returned rows are: " . mysqli_num_rows($result);


			$logg_all .= '<br><input class="letter" type="submit" name="submit7"   id="submit7"   value=" ..:: Отчет откючване ::.. ">';
			$logg_all .= '    <input class="letter" type="submit" name="submit8"   id="submit8"   value=" ..:: Регистрирани ключове ::.. ">';
			$iRow = 1;
     		if ($result && mysqli_num_rows($result) > 0) {
				$logg_all .= '<table class="colortable" border="2"><tr><th colspan="11"> Подробни данни за : &nbsp;&nbsp;&nbsp;'.$new_date_rev.', брой записи : '.mysqli_num_rows($result).'</th></tr>';
				$logg_all .= '<tr><th width=50 align="center">номер</th>
									<th width=180 align="center"><b>час, дата</b></th>
									<th width=50 align="center"><b>UID 1</b></th>
									<th width=50 align="center"><b>UID 2</b></th>
									<th width=50 align="center"><b>UID 3</b></th>
									<th width=50 align="center"><b>UID 4</b></th>
									<th width=50 align="center"><b>Разрешена</b></th>
									</tr>';
	   			while ($row1 = mysqli_fetch_assoc($result) ) {
						if ( $iRow % 2 == 0 ) {
							$logg_all	.= '<tr style="background-color:#ebecda">';
						} else {
							$logg_all	.= '<tr>';
						}	  	      		
	  	      	
						$logg_all	.= '<td align="center">'.$iRow.'</td><td align="center" >'.date("H:i, d F", strtotime($row1['date'])).'</td>';
						$logg_all	.= '<td align="right" >';
						$logg_all	.= $row1['UID1'].'</td>';
						$logg_all	.= '<td align="right" >';
						$logg_all	.= $row1['UID2'].'</td>';
						$logg_all	.= '<td align="right" >';
						$logg_all	.= $row1['UID3'].'</td>';
						$logg_all	.= '<td align="right" >';
						$logg_all	.= $row1['UID4'].'</td>';
						$logg_all	.= '<td align="right" >';
						$logg_all	.= $row1['allow'].'</td>';


						$logg_all	.= '</tr>';
						$iRow++;
	
     			}
     		}
			mysqli_free_result($result);
			$logg_all	.= '</table>';

//			echo $logg_all;
		
	
		echo $logg_all	;
		
		
		
echo '</td></tr></table></form>';
?>
</body>
</html>
