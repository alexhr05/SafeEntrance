<?php
/*

 Изпълнява се само от ESP8266

 Регстрира в лог отключвания, 
 и записва нови ключове, които все още не са разрешени
 
 Проверка на разрешени ключове : 
 От esp8266 се изпълянва заявка:
 www.domain.com
 /logDoor.php?nkey=k3d4kK93kOi34PI_h2allow
 /logDoor.php?nkey=k3d4kK93kOi34PI_h2Log     - заявка да записва всяко влизане 

*/

$libdir="./../../save_dir/";		// Директория с файлове, които да НЕ са достъпни през WEB
include ($libdir."functions.php");
include ($libdir."defines.php");
include ($libdir."database.php");

$domain_name 	= "192.168.1.5";
$logg1 			= "";
$chip_id1 		= 0;
$chip_id2 		= 0;
$chip_id3 		= 0;
$chip_id4 		= 0;
$allowchip 		= "";
$action			= "";
$door_id		= "";
$doorStatus		= "";
$time_alive		= "";


	// По подразбиране НЕ изпраща мейли, 
	// Изпращат се ако има опит за НЕОТОРИЗИРАН достъп - винаги
	$send_mail = "no";

	// Проверка дали се ползва правилен код за достъп
	getPostIfSet(array('nkey','chip_id1','chip_id2','chip_id3','chip_id4','poss','time','dist','allowchip','action','door_id','doorStatus','alarm_on','time_alive'));
	echo "z1.";
	$logg1 .= "z1.";
	if ( $nkey == "k3d4kK93kOi34PI_h2Log" ) {
		echo "<br>z2.";
		$logg1 .= "<br>z2.Test Door.";
		$tablica_name = "register_entrance";
	} 
	if ( $nkey == "k3d4kK93kOi34PI_h2allow" ) {
		$logg1 .= "<br>z6.allow_cards";
		$tablica_name = "allowchips";
	}

	// -------------------- Запитва сървъра за разрешени карти и записва резултата в EEPROM на ESO8266 -------------
	// Тази функция - праща към ESP8266 разрешените карти/чипове
	if ( $nkey == "k3d4kK93kOi34PI_h2allow" ) {
		echo "<br>z61.";
		
		// Прави запитване, ако има userid != 0, значи картата е активна, показват се само разрешени карти
		// Взима само ниво на достъп до тази врата
	  	$query= "SELECT * from allowchips where `userid` <> '0' and `Level` >= '1' ORDER BY id";
//		echo "<br>$query";
   		$result = mysqli_query($conn, $query); 
   		if ($result && mysqli_num_rows($result) > 0) {
			while ($row1 = mysqli_fetch_assoc($result)) {
				// Да се показват по ТРИ цифри
				echo "<br>Card001:";
				echo "y:";

				if ( strlen ($row1['UID1']) == 1 )
					echo "00";
				else if ( strlen ($row1['UID1']) == 2 )
					echo "0";

				echo $row1['UID1'];
				echo "-";

				if ( strlen ($row1['UID2']) == 1 )
					echo "00";
				else if ( strlen ($row1['UID2']) == 2 )
					echo "0";
				echo $row1['UID2'];
				echo "-";

				if ( strlen ($row1['UID3']) == 1 )
					echo "00";
				else if ( strlen ($row1['UID3']) == 2 )
					echo "0";
				echo $row1['UID3'];
				echo "-";

				if ( strlen ($row1['UID4']) == 1 )
					echo "00";
				else if ( strlen ($row1['UID4']) == 2 )
					echo "0";
				echo $row1['UID4'];

			}
		}
		
	// ------------------------------------------- Регистрира всяко влизане и оторизация с карта -----------------------------
	} else if ( $nkey == "k3d4kK93kOi34PI_h2Log" ) {			// Log - записва всяко влизане и оторизация с карта
			// Взима userid, username, chipOwnerName  и други
			$query= "SELECT * from allowchips where `UID1` = '$chip_id1' and `UID2` = '$chip_id2' and `UID3` = '$chip_id3' and `UID4` = '$chip_id4'";
//			echo "<br>$query";
			$result = mysqli_query($conn, $query); 
			if ($result && mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					// Да се показват по ТРИ цифри
					$userID 		= $row['userid'];
					$chipOwnerName 	= $row['chipOwnerName'];
				}
			}
			
			// Първо записва в log-а, събитието
			$query = "INSERT INTO `register_entrance` (`id`, `date`, `UID1`,`UID2`,`UID3`,`UID4`,`allow`,`action`,`unlockFrom`,`door_id`,`userid`,`chipOwnerName`) values ('', now(), '$chip_id1','$chip_id2','$chip_id3','$chip_id4','$allowchip', '$action', 'chip', '$door_id','$userID','$chipOwnerName')";
			$logg1 .= "<br>$query";
			$logg1 .= "<br>Записва отключване с чип.";
//			echo "<br>===".$query."===";
			$result = mysqli_query($conn, $query);
			if (!$result) {
				$logg1 .= "<br><br>Invalid ... Грешка 91923.<br><br>";
				echo('<br><br>Invalid ... Грешка 91923.<br><br>');
			} else {
				// All OK
				echo "<br>@#*;Writing in register_entrance OK.Coord";
				$logg1 .= "<br>@@@Writing in register_entrance OK.Coord";
			}
		
			if ( $chip_id1 === 0 and $chip_id2 === 0 and $chip_id3 === 0 and $chip_id4 === 0 ) {	// Има грешка, не са получени правилни стойности, изпраща мейл
				$send_mail == "yes";
				$logg1 .= "<br>Некоректни стойности на UID. Всички UID=0.";
			}
			
			// Второ записва в таблица "allowchips" - ако чипа не е разрешен
			if ($allowchip=="no") {
				$logg1 .= "<br>Регистриран е опит с НЕОТОРИЗИРАН чип. Проверява дали този чип е бил записан. Ако е, не прави нищо, ако НЕ е - записва го. ";
				
				$exist = "no";
				$query= "SELECT * from allowchips ORDER BY id";
//				echo "<br>query=($query)";
				$result = mysqli_query($conn, $query); 
				if ($result && mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<br>Прочетена карта : ".$row['UID1']."-".$row['UID2']."-".$row['UID3']."-".$row['UID4'].".";
						echo "; Сравнена с карта : ".$chip_id1."-".$chip_id2."-".$chip_id3."-".$chip_id4.".";
						if ( $row['UID1'] == $chip_id1 and $row['UID2'] == $chip_id2 and $row['UID3'] == $chip_id3 and $row['UID4'] == $chip_id4 )
							$exist = "yes";

					}
				}
				echo "<br>Резултат дали този чип е бил записан по-рано в таблица allowchips; exist=($exist)";

				if ( $exist == "no" ) {
					$logg1 .= "<br>Записан е и в таблицата с всички уникални опити. ";
					echo "<br>Записан е и в таблицата с всички уникални опити. ";
					$query = "INSERT INTO `allowchips` (`id`, `date_create`, `UID1`,`UID2`,`UID3`,`UID4`,`allow`) values ('', now(), '$chip_id1','$chip_id2','$chip_id3','$chip_id4','$allowchip')";
					$logg1 .= "<br>$query";
//					echo "<br>===".$query."===";
					$result = mysqli_query($conn, $query);
					if (!$result) {
						$logg1 .= "<br><br>Invalid ... Грешка 96923.<br><br>";
						echo('<br><br>Invalid ... Грешка 96923.<br><br>');
					} else {
						// All OK
						echo "<br>@#*;Writing in allow cards OK.Coord";
						$logg1 .= "<br>@@@Writing in allow cards OK.Coord";
					}
				}
			}

	// ------------------------------------------- Отворена/затворена врата --- door_id = 1 ---------------------------
	} else if ( $nkey == "hdRkTe3" ) {

		// Тук влиза при сигнал за отворена/затворена врата
		// Записва статус на врата, номер на врата - 1		
		if ( $doorStatus == "opened" )
			$query = "update `doors` set `state`='opened'  where `id`='1'";
		if ( $doorStatus == "closed" )
			$query = "update `doors` set `state`='closed'  where `id`='1'";
		if ( $doorStatus == "locked" )
			$query = "update `doors` set `state`='locked'  where `id`='1'";
		if ( $doorStatus == "unlocked" )
			$query = "update `doors` set `state`='unlocked'  where `id`='1'";
		if ( $doorStatus == "NA" )
			$query = "update `doors` set `state`='unknown'  where `id`='1'";

		if ( $time_alive == "now" )
			$query = "update `doors` set `date_modify`=now()  where `id`='1'";
	
		$result = mysqli_query($conn, $query);	
		echo "<br>new status ($doorStatus)";

	} else {
	  	echo "<br>Incorrect key for loging data for H.";
		$logg1 .= "<br>Incorrect key for loging data for H.";
		$send_mail = "yes";
	}
	
	if ( $send_mail == "yes" ) {
			//-----------------------------------------------------------------
			// Ако има разрешение -> изпраща мейл
			$msgmail1  = "(((".$_SERVER['REMOTE_ADDR'].")))---(((";
			$msgmail1 .= $_SERVER['QUERY_STRING'].")))";
			$msgmail1 .= "<br><br>logg===".$logg1."===";
			

			// Изпраща мейл
			$userMsgBody = 'Здравейте,<br>Има множество заявки от : <br>'.$msgmail1;
			$subject1 = "Много заявки от";
			$headers = "From: Alex<Alexhr05@gmail.com>\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=\"UTF-8\"\r\n";
			$headers .= "Bcc: peterhr@gmail.com\r\n";	// Слага скрито копие за тестове
			$headers .= "Bcc: alexhr05@gmail.com\r\n";	// Слага скрито копие за тестове
			$headers1251 = iconv("UTF-8", "CP1251", $headers );					
			$recipient = "Alexhr05@gmail.com";


			//------------------------------------------------
			// Изпраща МЕЙЛ
			//------------------------------------------------
			mail($recipient, $subject1, $msgmail1, $headers);
			//-----------------------------------------------------------------
	}	
	echo "<br>====================logg====================<br>".$logg1;
?>