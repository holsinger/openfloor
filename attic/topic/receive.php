<?

// define current working directory


error_reporting(E_ALL);
ini_set('display_errors',true);
$string = '';
$first = true;
foreach ($_GET as $key=>$value) {
	if ($first) {
  $string .= "\n$key=$value";
  $first = false;
  } else $string .= ",$key=$value"; 
}
//add refer
$string .= ",refer=".$_SERVER["HTTP_REFERER"];
$string .= ",time=".date('Y-m-d H:i:s');
$string .= "<br>";
//echo $string;


//see if we have this user
$userID = $_GET['valid'];
$userName = $_GET['user'];
$userPass = $_GET['session'];
$key = $_GET['key'];

$keyCheck = date('dm').'493'.$_GET['session'];

if ( $key !== $keyCheck ) exit();

function loggin($userID,$userName) {
    
    //@session_start();
    setcookie('wikidevUserID',$userID,time()+3600, "/",'');
    setcookie('wikidevUserName',ucfirst($userName),time()+3600, "/",'');
    setcookie('wikidev_key',md5($userID,ucfirst($userName)),0,'/', '' );
  	
    
    //echo session_id();
}

$conn = mysql_connect("localhost", "wikidev", "fl0w3r");

if (!$conn) {
    echo "Unable to connect to DB: " . mysql_error();
    exit;
}
 
if (!mysql_select_db("wikidev")) {
    echo "Unable to select wikidev: " . mysql_error();
    exit;
}

echo $sql = "SELECT * FROM   user WHERE user_name = '".ucfirst($userName)."' and user_password = '{$userPass}'";

$result = mysql_query($sql);

if (!$result) {
    echo "Could not successfully run query ($sql) from DB: " . mysql_error();
    exit;
}

if (mysql_num_rows($result) > 0) {
    //log the user in
    $row = mysql_fetch_assoc($result);
    loggin($row['user_id'],$row['user_name']);
} else {
    //insert a new record
    echo $sql = 'INSERT INTO `user` (`user_id`, `user_name`, `user_real_name`, `user_password`, `user_newpassword`, `user_newpass_time`, `user_email`, `user_options`, `user_touched`, `user_token`, `user_email_authenticated`, `user_email_token`, `user_email_token_expires`, `user_registration`, `user_editcount`) VALUES (NULL, \''.ucfirst($userName).'\', \'\', \''.$userPass.'\', \'\', NULL, \'\', \'\', \'\', \'\', NULL, NULL, NULL, NULL, NULL);';
    $result = mysql_query($sql);
    if (!$result) {
      echo "Could not successfully run query ($sql) from DB: " . mysql_error();
      exit();
    }
    
    loggin(mysql_insert_id(),$userName);
}





mysql_free_result($result);
/*
//save data
$fp = fopen("data.txt", "a");
fwrite ($fp, $string."\n\n");
fclose ($fp);*/

//return blank image
//header("Content-type: image/pjpeg");
//$content = '';
//echo("$content");



?>
