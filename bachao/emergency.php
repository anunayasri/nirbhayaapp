<?php

$log = fopen("files\\log.txt", "wb");
function debug($text){
	global $log;
	fwrite($log, $text."\n");
}

/*
Function : To execute required statements when emergency is pressed
Parameters 	: 	p_phone
				p_latitude
				p_longitude
sample url :		
http://localhost/emergency.php?phone=9475552163&latitude=47.63&longitude=-122.26
*/

require_once('..\PHPMailer_5.2.4\class.phpmailer.php');
// require 'haversineGreatCircleDistance.php';

$p_phone 		= $_GET["phone"];
$p_latitude		= $_GET["latitude"];
$p_longitude	= $_GET["longitude"];
// $p_debug	= $_GET["debug"];

debug("Calling emergency from $p_phone ........");

// Connect to databse
$dbhost = 'localhost:3306';
$dbuser = 'guest_user';
$dbpass = 'guest123';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
	debug('Could not connect: ' . mysql_error());
	die('Could not connect: ' . mysql_error());
}
debug( "Connected successfully\n");

// Select database to use
mysql_select_db( 'bachao' );

$update_location_query = 	"UPDATE user_location 
							SET latitude = '$p_latitude', longitude = '$p_longitude', last_updated = CURRENT_TIMESTAMP()
							WHERE phone = '$p_phone'
							";
$retval1 = mysql_query( $update_location_query, $conn );
if(!$retval1 )
{
	debug('retval1 : Could not get data: ' . mysql_error());
	die('retval1 : Could not get data: ' . mysql_error());
}

$dist_query = "SELECT con_email AS x_email
				FROM user_contacts_email 
				WHERE phone = $p_phone
				UNION
				SELECT email AS x_email
				FROM user_profile AS up,
					user_location AS ul
				WHERE up.phone = ul.phone
				AND ul.phone <> '$p_phone'
				AND	(6378.10 * ACOS(COS(RADIANS($p_latitude))
					 * COS(RADIANS(ul.latitude))
					 * COS(RADIANS($p_longitude) - RADIANS(ul.longitude))
					 + SIN(RADIANS($p_latitude))
					 * SIN(RADIANS(ul.latitude)))) <= 1.500
				";
$retval_dist = mysql_query( $dist_query, $conn );
if(!$retval_dist )
{
	debug('retval_dist : Could not get data: ' . mysql_error());
	die('retval_dist : Could not get data: ' . mysql_error());
}				

debug( "update_location_query : $update_location_query \n"."dist_query : $dist_query \n");

$user_query = "SELECT name, email, gender, dob FROM user_profile WHERE phone = $p_phone";
$retval_user_query = mysql_query( $user_query, $conn );
if(!$retval_user_query )
{
	debug('retval_user_query : Could not get data: ' . mysql_error());
	die('retval_user_query : Could not get data: ' . mysql_error());
}

$row = mysql_fetch_array($retval_user_query, MYSQL_ASSOC);
$user_name = $row['name'];
$user_email = $row['email'];
$user_gender = $row['gender'];
$user_dob = $row['dob'];


/********************************************************************************************
*							Save the file received in the disk								*
*********************************************************************************************/

$uploads_dir = "files"; //Directory to save the file that comes from client application.
$name = $p_phone.".jpg";	//date('Y_m_d_H_i_s').".jpg";
$jpg_file = "$uploads_dir\\$name";

if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) 
{	
    $tmp_name = $_FILES["file"]["tmp_name"];
	
    $moved = move_uploaded_file($tmp_name, $jpg_file);
	
	if($moved)
		debug( "File successfully saved.\n");
	else
		debug( "Failed to save file.\n");
}


/********************************************************************************************
*								SEND SMS AND EMAIL											*
*********************************************************************************************/
/******* Configure email ********/
debug( "Setting up email..... \n");
$mail = new PHPMailer(true);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPAuth = true; // enable SMTP authentication
$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
$mail->Port = 465; // set the SMTP port for the GMAIL server
$mail->Username = "nirbhaya.app@gmail.com"; // GMAIL username
$mail->Password = "nirbhaya123"; // GMAIL password

// $v_email = "anunayasri@gmail.com";
// $v_name = "NirbhayaApp";
$v_email_from = "fake_email@gmail.com";
$v_name_from = "$user_name";
$v_attach_path = "$jpg_file";

//Typical mail data
$mail->SetFrom($v_email_from, $v_name_from);
$mail->Subject = "URGENT !! YOUR FRIEND $user_name NEEDS IMMEDIATE HELP";
$mail->Body = 	"THIS MAIL IS FOR TESTING PURPOSE. PLEASE IGNORE THIS MAIL.\n\n".
				"Your friend $user_name is in danger and needs immediate rescue. Please reach the place given below.\n".
				"Phone : $p_phone\n".
				"EMail : $user_email\n".
				"Gender : $user_gender\n".
				"Date of birth : $user_dob\n".
				"Latitude : $p_latitude\n".
				"Longitude : $p_longitude\n\n\n".
				"Regards,\n".
				"NirbhayaApp Team";
$mail->AddAttachment($v_attach_path);

/******* Configure sms ********/
// debug( "<h3>Trying to send SMS.....</h3>\n");
$v_sms_user = '8755716980';
$v_sms_pass = '12345678';
$v_sms_ph = '';
$v_sms_msg = 'SMS msg';

while($row = mysql_fetch_array($retval_dist, MYSQL_ASSOC))
{
	// Send sms to each contact
	if($v_sms_ph == '')
		$v_sms_ph = $row['x_phone'];
	else
		$v_sms_ph = $v_sms_ph.';'.$row['x_phone'];
	
	debug( "v_sms_ph : $v_sms_ph \n");
	// Send email to each contact
	debug( "Adding address..... \n".
         "NAME : {$row['x_name']} \n".
		 "EMAIL :{$row['x_email']} \n".
		 "PHONE :{$row['x_phone']}\n".
         "--------------------------------"); 
	$mail->AddAddress($row['x_email'], $row['x_name']);
} 

mysql_close($conn);

try{
    $mail->Send();
    debug( "Success..... mail sent\n");
} catch(Exception $e){
    //Something went bad
    debug( "Fail..... cannot send email :( \n");
}

try{
	// header("Location: http://192.168.90.1:8080/examples/sendsms.jsp?uid=$v_sms_user&pwd=$v_sms_pass&number_phone=$v_sms_ph&mssg=new_anu");
	debug( "Success..... SMS sent\n");
} catch(Exception $e){
    //Something went bad
    debug( "Fail..... cannot send SMS :( \n");
}

fclose($log);

?>