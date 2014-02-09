<?php

/********************************************************************************************
*							Save the file received in the disk								*
*********************************************************************************************/

echo "Calling socket.php .......debug(";

$log = fopen("files/log.txt","wb");

$uploads_dir = "files"; //Directory to save the file that comes from client application.
fwrite($log, "Before if \n");
// fwrite($log, ">>>".$_FILES["file"]["name"]);


// $name = date('Y-m-d H:i:s').".jpg";
// echo "directory : $uploads_dir\\$name\n";


if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) 
{
	echo "\nInside if.......debug(";
	fwrite($log, "Inside if.......\n");
	
    $tmp_name = $_FILES["file"]["tmp_name"];
   $name = date('Y_m_d_H_i_s').".jpg";			// $_FILES["file"]["name"];
	
	fwrite($log, $name);
	
	echo "tmp_name : $tmp_namedebug("."directory : $uploads_dir\$namedebug(";
	fwrite($log, "tmp_name : $tmp_name\n"."directory : "."$uploads_dir\\$name"."\n");
	
    $moved = move_uploaded_file($tmp_name, "$uploads_dir\\$name");
	
	if($moved)
		fwrite($log, "\nMove Success\n");
	else
		fwrite($log, "\nMove Failed\n");
}

fclose($log);


// echo ">>>> ".date('Y-m-d H:i:s'); 

// $host = "127.0.0.1";
// $port = 5353;
// No Timeout 
// set_time_limit(0);

// $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
// $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");

// $result = socket_listen($socket, 3) or die("Could not set up socket listener\n");
// $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");

// $input = socket_read($spawn, 1024) or die("Could not read input\n");


?>