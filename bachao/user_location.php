<?php
/*
Function : To insert or update uer_location table
Parameters 	: 	phone
				latitude
				longitude
				mode		INSERT or UPDATE
				debug
sample url :		
http://localhost/user_location.php?phone=11111111&latitude=lat&longitude=long&mode=INSERT				
*/

$p_phone 		= $_GET["phone"];
$p_latitude		= $_GET["latitude"];
$p_longitude	= $_GET["longitude"];
$p_mode			= $_GET["mode"];
// $p_debug	= $_GET["debug"];

// Connect to databse
$dbhost = 'localhost:3306';
$dbuser = 'guest_user';
$dbpass = 'guest123';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
echo "Connected successfully<br>";

if($p_mode == "INSERT")
{
	$sql = "INSERT INTO user_location VALUES('$p_phone', '$p_latitude', '$p_longitude', DEFAULT)";
}
else if ($p_mode == "UPDATE")
{
	$sql = "UPDATE user_location 
			SET latitude = '$p_latitude', longitude = '$p_longitude', last_update = CURRENT_TIMESTAMP()
			WHERE phone = '$p_phone'
			";
}

// Select database to use
mysql_select_db( 'bachao' );

// Execure query
$retval = mysql_query( $sql, $conn );

if(! $retval )
{
  die('Could not get data: ' . mysql_error());
}
/*
while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
{
    echo "ID :{$row['id']}  <br> ".
         "NAME : {$row['name']} <br> ".
         "--------------------------------<br>";
} 
*/

echo "Data updated successfully\n";

mysql_close($conn);


?>