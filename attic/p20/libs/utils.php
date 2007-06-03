<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".

function safeAddSlashes($string)
{
 if (get_magic_quotes_gpc()) {
   return $string;
 } else {
   return addslashes($string);
 }
}

function unixtimestamp($timestamp){
	if(strlen($timestamp) == 14)
	{
		$time = substr($timestamp,0,4)."-".substr($timestamp,4,2)."-".substr($timestamp,6,2);
		$time .= " ";
		$time .=  substr($timestamp,8,2).":".substr($timestamp,10,2).":".substr($timestamp,12,2);
		return strtotime($time);
	}else{
		return strtotime($timestamp);
	}
}

function user_exists($username) {
	global $db;
	$res=$db->get_var("SELECT count(*) FROM " . table_users . " WHERE user_login='$username'");
	if ($res>0) return true;
	return false;
}

function email_exists($email) {
	global $db;
	$res=$db->get_var("SELECT count(*) FROM " . table_users . " WHERE user_email='$email'");
	if ($res>0) return $res;
	return false;
}

function check_email($email) {
	return preg_match('/^[a-z0-9_\-\.]+@[a-z0-9_\-\.]+\.[a-z]{2,4}$/', $email);
}

function check_email_address($email) {
	//from http://www.ilovejackdaniels.com/php/email-address-validation/
  // First, we check that there's one @ symbol, and that the lengths are right
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
     if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
      return false;
    }
  }  
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}

function txt_time_diff($from, $now=0){
	$txt = '';
	if($now==0) $now = time();
	$diff=$now-$from;
	$days=intval($diff/86400);
	$diff=$diff%86400;
	$hours=intval($diff/3600);
	$diff=$diff%3600;
	$minutes=intval($diff/60);

	if($days>1) $txt  .= " $days "._(PLIGG_Visual_Story_Times_Days);
	else if ($days==1) $txt  .= " $days "._(PLIGG_Visual_Story_Times_Day);

	if($days < 2){
		if($hours>1) $txt .= " $hours "._(PLIGG_Visual_Story_Times_Hours);
		else if ($hours==1) $txt  .= " $hours "._(PLIGG_Visual_Story_Times_Hour);
	
		if($hours < 3){
			if($minutes>1) $txt .= " $minutes "._(PLIGG_Visual_Story_Times_Minutes);
			else if ($minutes==1) $txt  .= " $minutes "._(PLIGG_Visual_Story_Times_Minute);
		}
	}
	
	if($txt=='') $txt = ' '. _(PLIGG_Visual_Story_Times_FewSeconds) . ' ';
	return $txt;
}

function txt_shorter($string, $len=80) {
	if (strlen($string) > $len)
		$string = substr($string, 0, $len-3) . "...";
	return $string;
}

function save_text_to_html($string) {
	$string = strip_tags(trim($string));
	$string= htmlspecialchars($string);
	$string= text_to_html($string);
	$string = preg_replace("/[\r\n]{2,}/", "<br /><br />\n", $string);
	return $string;
}

function text_to_html($string) {
	return preg_replace('/([hf][tps]{2,4}:\/\/[^ \t\n\r]+[^ .\t,\n\r\(\)"\'])/', '<a href="$1">$1</a>', $string);
}

function check_integer($which) {
	if(isset($_REQUEST[$which])){
		if (intval($_REQUEST[$which])>0) {
			return intval($_REQUEST[$which]);
		} else {
			return false;
		}
	}
	return false;
}

function check_string($which) {
	if (!empty($_REQUEST[$which])) {
		return intval($_REQUEST[$which]);
	} else {
		return false;
	}
}

function get_current_page() {
	if(($var=check_integer('page'))) {
		return $var;
	} else {
		return 1;
	}
    // return $_GET['page']>0 ? $_GET['page'] : 1;
}


function get_date($epoch) {
    return date("Y-m-d", $epoch);
}

function get_date_time($epoch) {
	    return date("Y-m-d H:i", $epoch);
}

function get_server_name() {
	global $server_name;
	if(empty($server_name)) 
		return $_SERVER['SERVER_NAME'];
	else
		return $server_name;
}

function get_base_url($url){
   $req = $url;
  
   $pos = strpos($req, '://');
   $protocol = strtolower(substr($req, 0, $pos));
  
   $req = substr($req, $pos+3);
   $pos = strpos($req, '/');
   if($pos === false)
	   $pos = strlen($req);
   $host = substr($req, 0, $pos);
	
	return $host;
}


function get_permalink($id) {
	return getmyFullurl("story", $id);
}

function get_trackback($id) {
	return getmyurl("trackback", $id);
}

function checklevel($levl)
{
	global $current_user;
	if(isset($current_user->user_level)){
		if ($current_user->user_level == $levl)
		{
			return 1;
		}
	}
}


function makeUrlFriendly($input) {
	// this function taken from http://us2.php.net/manual/en/function.preg-replace.php#54517
	// then modified with the help of "j0zf" and "caomhin"
	Global $db;

	//steef: remove strange characters in friendly URLs (code by jalso)
	//w3c: escape the url using urlencode() when it has to be displayed.
	//$input = remove_error_creating_chars(utf8_substr($input, 0, 240));
	$input = utf8_substr($input, 0, 240);
	
	$output = preg_replace("/\b(an?d?|f?o(r|f)|the)\b/i" , "" , $input);

	$output = trim($output);

	// Replace spaces with underscores
	$output = preg_replace("/\s/e" , "_" , $output);

	// Remove non-word characters // this will break unicode chars
	//$output = preg_replace("/\W/e" , "" , $output);

	//$output = preg_replace( '/(_a_|_an_|_the_|_and_|_or_|_of_|_for_)/i', '_', $output );

	$output = str_replace("_", "-", $output);
	$output = str_replace("--", "-", $output);
	$output = str_replace("\"", "", $output);
	$output = str_replace("'", "", $output);
	$output = str_replace(",", "", $output);
	$output = str_replace(";", "", $output);
	$output = str_replace(":", "", $output);
	$output = str_replace(".", "-", $output);
	$output = str_replace("?", "", $output);
	$output = str_replace("=", "-", $output);
	$output = str_replace("+", "", $output);

	$n = $db->get_var("SELECT count(*) FROM " . table_links . " WHERE link_title_url like '$output%'");
	if ($n > 0)
	{return $output . "-$n";}
	else
	{return $output;}

}


function makeCategoryFriendly($input) {
	// this function taken from http://us2.php.net/manual/en/function.preg-replace.php#54517
	// then modified with the help of "j0zf" and "caomhin"
	
	//steef: remove strange characters in friendly URLs (code by jalso)
	//$input = remove_error_creating_chars(utf8_substr($input, 0, 240));
	$input = utf8_substr($input, 0, 240);

	$output = preg_replace("/\b(an?d?|f?o(r|f)|the)\b/i" , "" , $input);

	$output = trim($output);

	// Replace spaces with underscores
	$output = preg_replace("/\s/e" , "" , $output);

	// Remove non-word characters
	//$output = preg_replace("/\W/e" , "" , $output);

	//	$output = preg_replace( '/(_a_|_an_|_the_|_and_|_or_|_of_|_for_)/i', '_', $output );

	$output = str_replace("_", "", $output);
	$output = str_replace("--", "", $output);
	$output = str_replace("'", "", $output);
	$output = str_replace('"', '', $output);
	
	return $output;	   
}

function remove_error_creating_chars($chars) { 
//Steef: adapted from code by jalso
  $replace=array( 
  "’" => "'",
  "—" => "-",
  "“" => "\"",
  "”" => "\"",
  'Á' => 'A',
  'Å' => 'A', 
  'ä' => 'a',
  'á' => 'a2',
  'à' => 'a3',
  'â' => 'a4',
  'ã' => 'a5',
  'ä' => 'a',
  'å' => 'a',
  'æ' => 'ae',
  'æ' => 'ae',
  'é' => 'e',
  'È' => 'E',
  'É' => 'E',
  'Ì' => 'I', 
  'ì' => 'i', 
  'Í' => 'I',
  'í' => 'i',
  '¼' => '',
  '¾' => '',
  '¿' => '',
  'ñ' => 'n',
  'Ñ' => 'N',
  'Ò' => 'O',
  'ò' => 'o',
  'Ö' => 'O',
  'Õ' => 'O',
  'Ó' => 'O',
  'ô' => 'o',
  'ó' => 'o',
  'õ' => 'o',
  'ö' => 'o',
  'Š' => 's',
  'š' => 's',
  '?' => '',
  '?' => '',
  'Û' => 'U',
  'Ú' => 'U',
  'Ü' => 'U',
  'û' => 'u',
  'ú' => 'u',
  'ü' => 'u',
  'Ý' => 'Y',
  'ý' => 'y',
  'Ž' => 'Z', 
  'ž' => 'z', 
  '€' => '',
  );

  foreach ($replace as $key => $value) {
    $chars = str_replace($key, $value, $chars );
  }
  return $chars;
}

function loghack($page, $extradata, $silent=false){
	// This function will be used for logging hacking attempts.
	// you'd also want IP Address
	// - date / time
	// email or log to file
	if($silent == false){
		die("Hacking attempt on ". $page);
	}
}

function checkforfield($fieldname, $table)
{
	$result = mysql_query('select * from ' . $table);
	if (!$result) {
		//die('Query failed: ' . mysql_error());
		echo "<HR />ERROR! The table " . $table . " is missing! Are you sure you should be doing an upgrade?<HR />";
		return true;
	}
	$i = 0;
	while ($i < mysql_num_fields($result)) {
	   $meta = mysql_fetch_field($result, $i);
	   if (!$meta) {
		   echo "No information available<br />\n";
	   }
	   else {
			if(strtolower($meta->name) == strtolower($fieldname)){
				return true;
			}
	   }
	   $i++;
	}
	return false;
}

function object_2_array($result)
{
		// using this because i'm not sure if (array)$user will work in php 4
		// i'm not sure if we even need all this but it makes my code work 
    $array = array();
    foreach ($result as $key=>$value)
    {
        if (is_object($value))
        {
            $array[$key]=object_2_array($value);
        }
        elseif (is_array($value))
        {
            $array[$key]=object_2_array($value);
        }
        else
        {
            $array[$key]=$value;
        }
    }
    return $array;
} 

function phpnum() {
	$version = explode('.', phpversion());
	return (int) $version[0];
}
?>