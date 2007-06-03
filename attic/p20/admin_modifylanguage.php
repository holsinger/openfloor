<?php
//savant: I do not want to break this code, so using an array to send the data to smarty.
include_once('Smarty.class.php');
$smarty = new Smarty;

include('config.php');
include(mnminclude.'html1.php');
include(mnminclude.'ts.php');
include(mnminclude.'link.php');
include(mnminclude.'tags.php');
$main_smarty = $smarty;
include(mnminclude.'smartyvariables.php');
$smarty = $main_smarty;

// Steef: Templated linkadmin
// To do: $my_pligg_base line 20 isn't working
/*
  echo '<html>';
	$main_smarty->display($the_template . '/head.tpl');
  echo '<body><div id="wrap"><div id="header">';
	$main_smarty->display($the_template . '/header.tpl');
	echo '</div><div id="content-wrap"><div id="sidebar">';
	$main_smarty->display($the_template . '/sidebar.tpl');
	echo '</div><div id="contentbox"><div id="breadcrumb"><a href="' . $my_pligg_base . '/">' . $server_name . '</a> &#187; <a href="' . $my_pligg_base . '/admin_index.php">Admin Panel</a> &#187; Modify Language</div>';
  echo '<div id="inside"><div id="contents"><fieldset><legend>Modify Language</legend><br />';
  */
// -------------------------------------------------------------------------------------
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
		$outputHtml[] = "<table class='listing'>";
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
						$outputHtml[] = "<tr><td></td></tr>";
						$outputHtml[] = "<tr><td></td></tr>";
						$outputHtml[] = "<tr><td></td></tr>";
						$outputHtml[] = "<tr><th><b>Section</b>: " . $section . "</th></tr>";
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
					$outputHtml[] = "<tr><td></td></tr>";
					if ($added <= $myversion) {$grey = "grey1";} else {$grey = "grey2";}
					$outputHtml[] = "<tr><td class='$grey'><b>" . $tabA . trim(substr($line, 0, $x));
					if ($added > $myversion) {$outputHtml[] = $tabA . 'NEW!!';}
					$outputHtml[] = "</b></td></tr>";
					$outputHtml[] = "<tr><td>" . $tabA . $tabA . '<a href = "?mode=edit&edit=' . trim(substr($line, 0, $x)) . '">Edit</a> Value: ' . trim(substr($line, $x + 1, 10000)) . "</td></tr>";
				}
			}
		}
	}
	$outputHtml[] = "</table>";
	$outputHtml[] = "</form>";
	$smarty->assign('outputHtml', $outputHtml);
	
	            // breadcrumbs
					$navwhere['text1'] = $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel');
					$navwhere['link1'] = getmyurl('admin', '');
					$navwhere['text2'] = "Modify Language";
					$navwhere['link2'] = my_pligg_base . "/admin_modifylanguage.php";
					$smarty->assign('navbar_where', $navwhere);
					$smarty->assign('posttitle', " / " . $main_smarty->get_config_vars('PLIGG_Visual_Header_AdminPanel'));
				// breadcrumbs
	
	define('pagename', 'admin_modifylanguage'); 
    $main_smarty->assign('pagename', pagename);
	
	$smarty->assign('tpl_center', The_Template . '/admin_templates/admin_modifylanguage_main');
	$smarty->display(The_Template . '/pligg.tpl');
}
else
{
	echo "Access denied";
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