{php}
	global $main_smarty, $current_user;
	if($current_user->user_login == 'god'){

			$file = 'http://www.pligg.com/pliggversion.php';
			$r = new HTTPRequest($file);
			$xxx = $r->DownloadToString();
			
			if(strlen($xxx) > 10){$xxx = "0";}else{$xxx = trim($xxx) * 1;}
			// we're running beta 9
			$curver = "0.9";
			// we'll eventually move this into the database instead of keeping the version variable in a file here.
			
			if($xxx > $curver){
				//$main_smarty->display(version_check_tpl_path . 'version_check_above_center.tpl');
				echo '<h3><center>There is a new version of Pligg available. Please visit <a href = "http://www.pligg.com" target = "_blank">Pligg.com</a> for more information.</center></h3>';
			}
	}
{/php}