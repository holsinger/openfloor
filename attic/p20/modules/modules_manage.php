<?php
include_once('../Smarty.class.php');
$main_smarty = new Smarty;

include('../config.php');
include(mnminclude.'html1.php');

force_authentication();

$thispage = 'modules_manage.php';

$canIhaveAccess = 0;
$canIhaveAccess = $canIhaveAccess + checklevel('god');
if($canIhaveAccess == 1){

	echo 'Module Manager v0.1 <br />This page is not inside a template because we dont want to have a bad module break it!<br />';
	echo '<a href = "' . my_base_url . my_pligg_base . '">return to your pligg site</a><hr />';
	
	if(isset($_REQUEST['action'])){$action = $_REQUEST['action'];}else{$action = 'main';}
	
	if($action == 'main'){
		
		echo '<b>installed modules</b><hr/>';
		
		$modules = $db->get_results('SELECT * from ' . table_modules . ';');
		if($modules){
			foreach($modules as $module) {
				
				if(file_exists('./' . $module->folder . '/' . $module->folder . '_readme.htm')){
					echo '<a href = "?action=readme&module=' . $module->folder . '">' . $module->name . '</a>' . ' v' . $module->version;
				} else {
					echo $module->name . ' v' . $module->version;
				}
				
				if($module->enabled == 1){
					echo ' - <a href = "?action=disable&module=' . $module->name . '">disable</a>';
				} else {
					echo ' - <a href = "?action=enable&module=' . $module->name . '">enable</a> -- <a href = "?action=remove&module=' . $module->name . '">remove</a>';
				}	
				 
				echo '<br />';
				if($module_info = include_module_settings($module->folder)){
					echo '&nbsp;&nbsp;&nbsp; desc: ' . $module_info['desc'] . '<br />';
					if(isset($module_info['requires'])){
						$requires = $module_info['requires'];
						if(is_array($requires)){
							foreach($requires as $requirement){
								echo '&nbsp;&nbsp;&nbsp; requires: ' . $requirement[0] . ' version ' . $requirement[1];
								if(check_for_enabled_module($requirement[0], $requirement[1])){
									echo " - pass";
								} else {
									echo " - <b>fail</b>";
								}
								echo '<br />';
							}
						}
					}
				}
			}
		} else {
			echo 'There are no modules installed';
		}
		echo '<hr /><b>available (but not installed)</b><hr />';
		
		
		// find all the folders in the modules folder
		$dir = './';
		if (is_dir($dir)) {
		   if ($dh = opendir($dir)) {
		       while (($file = readdir($dh)) !== false) {
		       		if(is_dir($dir . $file)){
		       			if($file != '.' && $file != '..'){
		       				$foundfolders[] = $file;
		           	}
		          }
		       }
		       closedir($dh);
		   }
		}
		
		
		// for each of the folders found, make sure they're not already in the database
		$modules = $db->get_results('SELECT * from ' . table_modules . ';');
		if($modules){
			foreach($modules as $module) {
				foreach($foundfolders as $key => $value){
					if ($module->folder == $value){
						unset($foundfolders[$key]);
					}
				}
			}
		}		
		
		foreach($foundfolders as $key => $value){
			$text = '';
			if($module_info = include_module_settings($value)){
				$text[] = '&nbsp;&nbsp;&nbsp; desc: ' . $module_info['desc'] . '<br />';
				$version = $module_info['version'];
				$name = $module_info['name'];
				if(isset($module_info['requires'])){
					$requires = $module_info['requires'];
					if(is_array($requires)){
						foreach($requires as $requirement){
							$text[] = '&nbsp;&nbsp;&nbsp; requires: ' . $requirement[0] . ' version ' . $requirement[1];
							if(check_for_enabled_module($requirement[0], $requirement[1])){
								$text[] = " - pass";
							} else {
								$text[] = " - <b>fail</b>";
							}
							$text[] = '<br />';
						}
					}
				}
				$thename = $name . ' v ' . $version;
				
				if(file_exists('./' . $value . '/' . $value . '_readme.htm')){
					echo '<a href = "?action=readme&module=' . $value . '">' . $thename . '</a>';
				} else {
					echo $thename;
				}
				
				echo ' - <a href = "?action=install&module=' . $value . '">install</a><br />';
	
				if(is_array($text)){foreach($text as $tex){echo $tex;}}

			} else {
				// this is where folders are found but don't have the install file.
			}
		}
	}
	
	
	
	
	
	if($action == 'install'){
		$module = $_REQUEST['module'];

		if($module_info = include_module_settings($module))
		{
			$version = $module_info['version'];
			$name = $module_info['name'];
			$requires = $module_info['requires'];
			check_module_requirements($requires);
			
			process_db_requirements($module_info);
			
		} else {
			die('no install file exists');
		}
			
		$db->query("INSERT INTO " . table_modules . " (`name`, `version`, `folder`, `enabled`) values ('".$name."', '" . $version . "', '".$module."', 1);");
		header('Location: ' . $thispage);
	}	
	
	
	
	

	if($action == 'disable'){
		$module = $_REQUEST['module'];
		$sql = "UPDATE " . table_modules . " set enabled = 0 where `name` = '" . $module . "';";
		//echo $sql;
		$db->query($sql);
		header('Location: ' . $thispage);
	}	

	if($action == 'enable'){
		$module = $_REQUEST['module'];
		$sql = "UPDATE " . table_modules . " set enabled = 1 where `name` = '" . $module . "';";
		//echo $sql;
		$db->query($sql);
		header('Location: ' . $thispage);
	}	
	
	if($action == 'remove'){
		$module = $_REQUEST['module'];
		$sql = "Delete from " . table_modules . " where `name` = '" . $module . "';";
		//echo $sql;
		$db->query($sql);
		header('Location: ' . $thispage);
	}	
	
	if($action == 'readme'){
		$module = $_REQUEST['module'];
		echo '<a href = "' . $thispage . '">return to the module manager</a><br>';
		include_once('./' . $module . '/' . $module . '_readme.htm');		
		
		
	}
}
?>
