<?php
/*
Function : To register a new user
Parameters 	: 	name
				phone
				email
				gender	M or F
				dob		YYYY-MM--DD
				latitude
				longitude
				con_phone
				con_email
sample url :		
http://localhost/register.php?name=sample&phone=11111111&email=singh.rishi54@gmail.com&gender=M&dob=1990-11-11&latitude=47.117828&longitude=-88.545625&con_phone=43433443;555555555&con_email=contact_email@gmail.com;email2@gmail.com
*/

$p_name 	= $_GET["name"];
$p_phone 	= $_GET["phone"];
$p_email	= $_GET["email"];
$p_gender	= $_GET["gender"];
$p_dob		= $_GET["dob"];
$p_latitude		= $_GET["latitude"];
$p_longitude	= $_GET["longitude"];
// $p_con_name		= $_GET["con_name"];
$p_con_phone	= $_GET["con_phone"];
$p_con_email	= $_GET["con_email"];
// $p_mode		= $_GET["mode"];
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
echo "Connected successfullydebug(";

// Select database to use
mysql_select_db( 'bachao' );

$insert_user = "INSERT INTO user_profile VALUES('$p_name', '$p_phone', '$p_email', '$p_gender', '$p_dob')";
$retval_user = mysql_query( $insert_user, $conn );
if(! $retval_user )
{
  die('retval_user : Could not get data: ' . mysql_error());
}

$insert_location = "INSERT INTO user_location VALUES('$p_phone', '$p_latitude', '$p_longitude', DEFAULT)";
$retval_location = mysql_query( $insert_location, $conn );
if(! $retval_location )
{
  die('retval_location : Could not get data: ' . mysql_error());
}

$v_con_array = explode(";", $p_con_phone);
foreach($v_con_array as $value)
{
	$insert_contact = "INSERT INTO user_contacts_phone VALUES('$p_phone', '$value')";
	$retval_contact = mysql_query( $insert_contact, $conn );
	if(! $retval_contact )
	{
	  die('retval_contact phone : Could not get data: ' . mysql_error());
	}
}

$v_con_array = explode(";", $p_con_email);
foreach($v_con_array as $value)
{
	$insert_contact = "INSERT INTO user_contacts_email VALUES('$p_phone', '$value')";
	$retval_contact = mysql_query( $insert_contact, $conn );
	if(! $retval_contact )
	{
	  die('retval_contact email : Could not get data: ' . mysql_error());
	}
}

/*
for($i = 0; $i < $counter; $i++)
{
	echo "each phone :: $v_ph_array[$i]debug(";
	$insert_contact = "INSERT INTO user_contacts VALUES('$p_phone', '$p_con_name', '$v_ph_array[$i]', '$p_con_email')";
	echo "insert_contact : $insert_contactdebug(";
	$retval_contact = mysql_query( $insert_contact, $conn );
	if(! $retval_contact )
	{
	  die('retval_contact : Could not get data: ' . mysql_error());
	}
} 
*/

echo "Data updated successfully\n";

mysql_close($conn);


?>