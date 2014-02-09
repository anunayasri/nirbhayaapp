<?php
require_once 'C:\xampp\htdocs\bachao\vendor\mashape\unirest-php\lib\Unirest.php';

echo "ANUNAYA.................................\n";
echo "<h2>Hello " .$_GET["name"]."</h2>\n";

$dbhost = 'localhost:3306';
$dbuser = 'guest_user';
$dbpass = 'guest123';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}
echo "Connected successfully<br>";

$idVal = $_GET["id"];
$sql = 'SELECT id, name FROM test WHERE id = '.$idVal;

mysql_select_db( 'guest' );

$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  // die('Could not get data: ' . mysql_error());
}

while($row = mysql_fetch_array($retval, MYSQL_ASSOC))
{
    echo "ID :{$row['id']}  <br> ".
         "NAME : {$row['name']} <br> ".
         "--------------------------------<br>";
} 
echo "Fetched data successfully\n";

mysql_close($conn);

//++++++++++++++++++++++++++++++++++
echo "<h3>Trying to send SMS.....</h3><br>";
$user = '8755716980';
$pass = '12345678';
$ph = '9450156402;9475552163';
try{
// $response = Unirest::get(
  // "http://site2sms.p.mashape.com/index.php?uid=9458108749&pwd=12345678&phone=9450156402;9475552163&msg=hey%20anunaya",
  // array(
    // "X-Mashape-Authorization" => "CjrqMh8OVCKAJmaqoGS3S01xqg6YxgqJ"
  // ),
  // null
// );


// header("Location: http://192.168.90.1:8080/examples/sendsms.jsp?uid=$user&pwd=$pass&number_phone=$ph&mssg=new_anu");

/*

// Initialize session and set URL.
$ch = curl_init();
$url = "https://site2sms.p.mashape.com/index.php?uid=$user&pwd=$pass&phone=$ph&msg=new_anu_php";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, true);
// curl_setopt($ch, CURLINFO_HEADER_OUT, true);
curl_setopt($ch,CURLOPT_HTTPHEADER,array('X-Mashape-Authorization: CjrqMh8OVCKAJmaqoGS3S01xqg6YxgqJ'));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Set so curl_exec returns the result instead of outputting it.
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
// Get the response and close the channel.
$response = curl_exec($ch);
curl_close($ch);
*/

// echo $response->__get($body);
echo "<h3>SMS SENT ....</h3><br>";
} catch(Exception $e)
{
	echo "Error:::::: ".$e->getMessage()."\n";
}
?>