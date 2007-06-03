<?php

function admin_language_showpage(){
	global $main_smarty, $the_template;

	include_once('config.php');
	include_once(mnminclude.'html1.php');
	include_once(mnminclude.'ts.php');
	include_once(mnminclude.'link.php');
	include_once(mnminclude.'tags.php');
	include_once(mnminclude.'smartyvariables.php');
	
	$main_smarty = do_sidebar($main_smarty);
	
	if($_REQUEST['var_id'] != ""){
		
				$lines = file('./libs/lang.conf');
 	
				$filename = './libs/lang.conf';
				if($handle = fopen($filename, 'w')) {
					foreach ($lines as $line_num => $line)
					{
	
						if(substr($line, 0, 2) != "//")
						{
							if (strlen(trim($line)) > 2)
							{
								$x = strpos($line, "=");
								if (trim(substr($line, 0, $x)) == str_replace('emptytext_', '', $_REQUEST["var_id"]))
								{
									$y = trim(substr($line, $x + 1, 10000));
									$y = str_replace('"', '', $y);
									$line = trim(substr($line, 0, $x)) . ' = "' . $_REQUEST["var_value"] . '"' . "\n";
									$returnVal = $_REQUEST["var_value"];
								}
							}
						}
	
						if(fwrite($handle, $line)) {
						} else {
							echo "<b>Could not write to '$filename' file</b>";
						}
					}
					fclose($handle);
					//header('Location: admin_modifylanguage.php');
				} else {
					echo "<b>Could not open '$filename' file for writing</b>";
				}

		echo $returnVal;
		die();
	}
	
	
	
	
	
	force_authentication();
	$canIhaveAccess = 0;
	$canIhaveAccess = $canIhaveAccess + checklevel('god');
	
	if($canIhaveAccess == 1)
	{
		$canContinue = 1;
		$canContinue = isWriteable ( $canContinue, './libs/lang.conf', 0777, './libs/lang.conf' );
	
		if (!$canContinue)
		{
			echo 'File is not writeable. Please CHMOD /libs/lang.conf to 777 and refresh this page.<br /><br /><br />';
			die;
		}
		$version = file('./libs/lang.conf.version');
		$myversion = $version[0] * 1;
	
		$lines = file('./libs/lang.conf');
		$section = "x";
		$lastsection = "";
	
		$tabA = "&nbsp;&nbsp;&nbsp;&nbsp;";
		
		if(isset($_GET["mode"]))
		{
			if($_GET["mode"] == "edit")
			{
				$outputHtml[] = "<form>";
				$outputHtml[] = "<table class='listing'>";
				$outputHtml[] = "Editing <b>" . $_GET["edit"] . "</b><br /><br />";
				foreach ($lines as $line_num => $line) {
					if(substr($line, 0, 2) != "//")
					{
						if (strlen(trim($line)) > 2)
						{
							$x = strpos($line, "=");
							if (trim(substr($line, 0, $x)) == $_GET["edit"])
							{
								$y = trim(substr($line, $x + 1, 10000));
								$y = str_replace('"', "", $y);
								$outputHtml[] = "Current Value: " . $y . "<br />";
								$outputHtml[] = '<input type = "hidden" name = "edit" value = "'.$_GET["edit"].'">';
								$outputHtml[] = '<input type = "hidden" name = "mode" value = "save">';
								$outputHtml[] = '<input name = "newvalue" value = "'.$y.'" size=75><br />';
								$outputHtml[] = '<input type = "submit" name = "save" value = "save" class = "log2">';
							}
						}
					}
				}
			}
			if($_GET["mode"] == "save")
			{
				$outputHtml[] = "saving <b>" . $_GET["edit"] . "</b><br />";
	
				$filename = './libs/lang.conf';
				if($handle = fopen($filename, 'w')) {
					foreach ($lines as $line_num => $line)
					{
	
						if(substr($line, 0, 2) != "//")
						{
							if (strlen(trim($line)) > 2)
							{
								$x = strpos($line, "=");
								if (trim(substr($line, 0, $x)) == $_GET["edit"])
								{
									$y = trim(substr($line, $x + 1, 10000));
									$y = str_replace('"', '', $y);
									$line = trim(substr($line, 0, $x)) . ' = "' . $_GET["newvalue"] . '"' . "\n";
								}
							}
						}
	
						if(fwrite($handle, $line)) {
	
						} else {
							$outputHtml[] = "<b>Could not write to '$filename' file</b>";
						}
					}
					fclose($handle);
					header('Location: admin_modifylanguage.php');
				} else {
					$outputHtml[] = "<b>Could not open '$filename' file for writing</b>";
				}
	
			}
		}
		else 
		{
			$outputHtml = array();
			$outputHtml[] = "<form>";
			$outputHtml[] = '<table id="mytable" class="listing">';
			foreach ($lines as $line_num => $line) {
				if(substr($line, 0, 2) == "//")
				{
					$x = strpos($line, "<LANG>");
					if ($x === false){}else
					{
						$y = strpos($line, "</LANG>");
						$lang = substr($line, $x + 6, $y);
					}
	
					$x = strpos($line, "<TITLE>");
					if ($x === false){}else
					{
						$y = strpos($line, "</TITLE>");
						$outputHtml[] = "<tr><td bgcolor = BFBFBF><b>Title:</b>" . substr($line, $x + 7, $y) . "</td></tr>";
					}
	
					$x = strpos($line, "<SECTION>");
					if ($x > 0)
					{
						$y = strpos($line, '</SECTION>');
						$section = substr($line, $x + 9, $y - $x);
						if ($section != $lastsection)
						{
							$lastsection = $section;
							$outputHtml[] = '<tr id="row_ASDFGHJK"><td></td></tr>';
							$outputHtml[] = '<tr id="row_ASDFGHJK"><td></td></tr>';
							$outputHtml[] = '<tr id="row_ASDFGHJK"><td></td></tr>';
							$outputHtml[] = '<tr id="row_ASDFGHJK"><th><b>Section</b>: ' . $section . '</th></tr>';
						}
					}
					$x = strpos($line, "<VERSION>");
					if ($x === false){}else
					{
						$y = strpos($line, "</VERSION>");
						$version = substr($line, $x + 9, $y);
					}
					$x = strpos($line, "<ADDED>");
					if ($x === false){}else
					{
						$y = strpos($line, "</ADDED>");
						$added = substr($line, $x + 7, $y) * 1;
					}
	
				}
				else
				{
					if (strlen(trim($line)) > 2)
					{
						$x = strpos($line, "=");
						$outputHtml[] = '<tr id = "row_' . str_replace('"', '', trim(substr($line, $x + 1, 10000))) . '"><td><br />';
						if ($added <= $myversion) {$grey = "grey1";} else {$grey = "grey2";}
						$outputHtml[] = "<b>" . $tabA . trim(substr($line, 0, $x));
						if ($added > $myversion) {$outputHtml[] = $tabA . 'NEW!!';}
						$outputHtml[] = "</b><br />";
						$outputHtml[] = "" . $tabA . $tabA;
						$outputHtml[] = 'Value: <span id="emptytext_'.trim(substr($line, 0, $x)).'">' . str_replace('"', '', trim(substr($line, $x + 1, 10000))) . '</span>';
						$outputHtml[] = "</td></tr>";
						
						$editinplace_init[] = "EditInPlaceAL.makeEditable({ id: 'emptytext_".trim(substr($line, 0, $x))."', on_blur: 'cancel'});";
						
					}
				}
			}
		}
		$outputHtml[] = "</table>";
		$outputHtml[] = "</form>";
		$main_smarty->assign('outputHtml', $outputHtml);
		
		            // breadcrumbs
						$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
						$navwhere['link1'] = getmyurl('admin', '');
						$navwhere['text2'] = "Modify Language";
						$navwhere['link2'] = my_pligg_base . "/module.php?module=admin_language";
						$main_smarty->assign('navbar_where', $navwhere);
						$main_smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
					// breadcrumbs
		
		define('pagename', 'admin_modifylanguage'); 
	   $main_smarty->assign('pagename', pagename);

	   $main_smarty->assign('editinplace_init', $editinplace_init);
		
		//$main_smarty->assign('tpl_center', The_Template . '/admin_templates/admin_modifylanguage_main');
		//$main_smarty->display(The_Template . '/pligg.tpl');

		$main_smarty->assign('tpl_center', admin_language_tpl_path . 'admin_language_main');
		$main_smarty->display($the_template . '/pligg.tpl');

	}
	else
	{
		echo "Access denied";
	}
		

}	




function isWriteable ( $canContinue, $file, $mode, $desc )
{
	@chmod( $file, $mode );
	$good = is_writable( $file ) ? 1 : 0;
	Message ( $desc.' is writable: ', $good );
	return ( $canContinue && $good );
}
function Message( $message, $good )
{
	global $outputHtml;
	if ( $good )
		$yesno = '<b><font color="green">Yes</font></b>';
	else
	{
		$yesno = '<b><font color="red">No</font></b>';
		$outputHtml[] = $message .'</td><td>'. $yesno .'<br />';
	}
}

?>