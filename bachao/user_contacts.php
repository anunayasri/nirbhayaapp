<?php
/*
Function : To insert or update uer_contacts table
Parameters 	: 	phone
				// con_name
				con_phone
				con_email
				mode		INSERT or UPDATE
				debug
sample url :		
http://localhost/user_contacts.php?phone=11111111&con_phone=43433443&con_email=contact_email@gmail.com&mode=INSERT				
*/

$p_phone 		= $_GET["phone"];
// $p_con_name		= $_GET["con_name"];
$p_con_phone	= $_GET["con_phone"];
$p_con_email	= $_GET["con_email"];
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
echo "Connected successfullydebug(";

if($p_mode == "INSERT")
{
	$sql = "INSERT INTO user_contacts_phone VALUES('$p_phone', '$p_con_phone');
			INSERT INTO user_contacts_email VALUES('$p_phone', '$p_con_email')";
}
/*
else if ($p_mode == "UPDATE")
{
	$sql = "UPDATE user_contacts 
			SET con_name = '$p_con_name', con_phone = '$p_con_phone', con_email = '$p_con_email'
			WHERE phone = '$p_phone'
			";
}
*/
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
    echo "ID :{$row['id']}  debug( ".
         "NAME : {$row['name']} debug( ".
         "--------------------------------debug(";
} 
*/

echo "Data updated successfully\n";

mysql_close($conn);


?>