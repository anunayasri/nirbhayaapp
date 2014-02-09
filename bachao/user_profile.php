<?php
/*
Function : To insert or update uer_profile table
Parameters 	: 	name
				phone
				email
				gender	M or F
				dob		YYYY-MM--DD
				mode		INSERT or UPDATE
				debug
sample url :		
http://localhost/user_profile.php?name=sample&phone=11111111&email=singh.rishi54@gmail.com&gender=M&dob=1990-11-11&mode=INSERT				
*/

$p_name 	= $_GET["name"];
$p_phone 	= $_GET["phone"];
$p_email	= $_GET["email"];
$p_gender	= $_GET["gender"];
$p_dob		= $_GET["dob"];
$p_mode		= $_GET["mode"];
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
	$sql = "INSERT INTO user_profile VALUES('$p_name', '$p_phone', '$p_email', '$p_gender', '$p_dob')";
}
else if ($p_mode == "UPDATE")
{
	$sql = "UPDATE user_profile 
			SET name = '$p_name', email = '$p_email', gender = '$p_gender', dob = '$p_dob'
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