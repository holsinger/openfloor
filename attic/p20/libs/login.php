<?php
// The source code packaged with this file is Free Software, Copyright (C) 2005 by
// Ricardo Galli <gallir at uib dot es>.
// It's licensed under the AFFERO GENERAL PUBLIC LICENSE unless stated otherwise.
// You can get copies of the licenses here:
// 		http://www.affero.org/oagpl.html
// AFFERO GENERAL PUBLIC LICENSE is also included in the file called "COPYING".



class UserAuth {
	var $user_id  = 0;
	var $user_login = "";
	var $md5_pass = "";
	var $authenticated = FALSE;


	function UserAuth() {
		global $db;

		if(isset($_COOKIE['mnm_user']) && isset($_COOKIE['mnm_key']) && $_COOKIE['mnm_user'] !== '') {
			// Si ya está autentificado de antes, rellenamos la estructura.
			$userInfo=explode(":", base64_decode($_REQUEST['mnm_key']));
			if(crypt($userInfo[0], 22)===$userInfo[1] 
				&& $_COOKIE['mnm_user'] === $userInfo[0]) {
				$dbusername = $db->escape($_COOKIE['mnm_user']);
				$dbuser=$db->get_row("SELECT user_id, user_pass, user_level FROM " . table_users . " WHERE user_login = '$dbusername'");
				if($dbuser->user_id > 0 && md5($dbuser->user_pass)==$userInfo[2]) {
					$this->user_id = $dbuser->user_id;
					$this->user_level = $dbuser->user_level;
					$this->user_login  = $userInfo[0];
					$this->md5_pass = $userInfo[2];
					$this->authenticated = TRUE;
				}
			}
		}
	}


	function SetIDCookie($what, $remember) {
		switch ($what) {
			case 0:	// Borra cookie, logout
				setcookie ("mnm_user", "", time()-3600, "/"); // Expiramos el cookie
				setcookie ("mnm_key", "", time()-3600, "/"); // Expiramos el cookie
				break;
			case 1: //Usuario logeado, actualiza el cookie
				// Atencion, cambiar aqu�cuando se cambie el password de base de datos a MD5
				$strCookie=base64_encode(join(':',
					array(
						$this->user_login,
						crypt($this->user_login, 22),
						$this->md5_pass)
					)
				);
				if($remember) $time = time() + 3600000; // Lo dejamos v�idos por 1000 horas
				else $time = 0;
				setcookie("mnm_user", $this->user_login, $time, "/");
				setcookie("mnm_key", $strCookie, $time, "/");
				break;
		}
	}

	function Authenticate($username, $pass, $remember=false) {
		global $db;
		$dbusername=$db->escape($username);
		
		$user=$db->get_row("SELECT user_id, user_pass, user_login FROM " . table_users . " WHERE user_login = '$dbusername'");
		$saltedpass=generateHash($pass, substr($user->user_pass, 0, SALT_LENGTH));
		if ($user->user_id > 0 && $user->user_pass === $saltedpass) {
			$this->user_login = $user->user_login;  
			$this->user_id = $user->user_id;
			$this->authenticated = TRUE;
			$this->md5_pass = md5($user->user_pass);
			$this->SetIDCookie(1, $remember);
			$lastip=$_SERVER['REMOTE_ADDR'];			
			mysql_query("UPDATE " . table_users . " SET user_lastip = '$lastip' WHERE user_id = {$user->user_id} LIMIT 1");
            mysql_query("UPDATE " . table_users . " SET user_lastlogin = now() WHERE user_id = {$user->user_id} LIMIT 1");
			return true;
		}
		return false;
	}

	function Logout($url='./') {
		$this->user_login = "";
		$this->authenticated = FALSE;
		$this->SetIDCookie (0, '');

		define('wheretoreturn', $url);
		check_actions('logout_success');

		//header("Pragma: no-cache");
		header("Cache-Control: no-cache, must-revalidate");
		header("Location: $url");
		header("Expires: " . gmdate("r", time()-3600));
		header("ETag: \"logingout" . time(). "\"");
		die;
	}

}

$current_user = new UserAuth();
?>