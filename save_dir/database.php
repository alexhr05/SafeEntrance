<?php

$database = DBNAME;
$host = HOST;
$username = USER;
$password = PASS;


$conn = mysqli_connect("localhost", $username, $password, $database) or die('Could not connect to DB server.' );

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//    echo "<br>Debugging errNO: " . mysqli_connect_errno() . PHP_EOL;
//    echo "<br>Debugging errOR: " . mysqli_connect_error() . PHP_EOL;



//mysqli_select_db($database, $conn) or die('Could not connect to DB.' );
//$chars="SET CHARACTER SET utf8";
//mysql_query($chars);



// $db_link = mysql_connect($host, $username, $password) or die('Could not connect to DB server------'.mysql_error());  
//    mysql_select_db($database, $db_link) or die('Could not connect to DB.=======:'.mysql_error());
	
	


?>