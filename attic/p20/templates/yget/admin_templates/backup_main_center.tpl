{if $isAdmin eq 1}
	{php}
		
		$canIhaveAccess = 0;
		$canIhaveAccess = $canIhaveAccess + checklevel('god');
		
		if($canIhaveAccess == 1)
		{
			if($_REQUEST['dobackup'] == "files"){
				include ('./libs/backup/file_backup/backup.php');
				$FileBackup = new FileBackup;
				$FileBackup->MakeBackup();
				//echo "<HR>";
				header("Location: admin_backup.php");
			}
			if($_REQUEST['dobackup'] == "avatars"){
				include ('./libs/backup/file_backup/backup.php');
				$FileBackup = new FileBackup;
				$FileBackup->MakeAvatarBackup();
				//echo "<HR>";
				header("Location: admin_backup.php");
			}
			if($_REQUEST['dobackup'] == "database"){
				//require_once("./libs/backup/mysql_backup/init.php");
				//$b = new backup;
				//$b->dbconnect($GonxAdmin["dbhost"],$GonxAdmin["dbuser"],$GonxAdmin["dbpass"],$GonxAdmin["dbname"],"", $GonxAdmin["dbtype"]);
				//echo $b->generate();
				//echo $b->tablesbackup();
				require("./libs/backup/mysql_backup/backup.php");
				
			}
			if($_REQUEST['dobackup'] == "clearall"){
				
				// http://www.phpbbstyles.com/viewtopic.php?t=2278
			 $files = array();  
			 $dir = opendir('./backup');  
			 while(($file = readdir($dir)) !== false)  
			 {  
			  if($file !== '.' && $file !== '..' && !is_dir($file) && $file !== 'index.htm')  
			  {  
			    $files[] = $file;  
			  }  
			 }  
			 closedir($dir);  
			 sort($files);  
			 for($i=0; $i<count($files); $i++)  
			 {  
			  unlink('./backup/'.$files[$i]);
			 }  
				header("Location: admin_backup.php");
			}
			
			// v1.0 was the base
			// v1.1 added avatar backup seperately.
			
			echo "<fieldset><legend>";{/php}{#PLIGG_Visual_Header_AdminPanel_4#}{php}echo "</legend>";
			echo '<h3>';{/php}{#PLIGG_Visual_View_Backup#}{php}echo':</h3><a href = "?dobackup=files">';{/php}{#PLIGG_Visual_View_Backup_Files#}{php} echo'</a><br>';
			echo '<a href = "?dobackup=avatars">';{/php}{#PLIGG_Visual_View_Backup_Avatars#}{php}echo'</a><br>';
			echo '<a href = "?dobackup=database">';{/php}{#PLIGG_Visual_View_Backup_Database#}{php}echo'</a><br><br>';
			echo "<h4 style='border:none'>";{/php}{#PLIGG_Visual_View_Backup_Previous#}{php}echo"</h4>";
			echo '<a href = "?dobackup=clearall">';{/php}{#PLIGG_Visual_View_Backup_Remove#}{php}echo'</a><hr><br>';
			
			
			// http://www.phpbbstyles.com/viewtopic.php?t=2278
		 $files = array();  
		 $dir = opendir('./backup');  
		 while(($file = readdir($dir)) !== false)  
		 {  
		  if($file !== '.' && $file !== '..' && !is_dir($file) && $file !== 'index.htm')  
		  {  
		    $files[] = $file;  
		  }  
		 }  
		 closedir($dir);  
		 sort($files);  
		 for($i=0; $i<count($files); $i++)  
		 {  
		  echo '<a href = "./backup/' . $files[$i] . '">' . $files[$i] . '</a><BR>';  
		 }  
		echo '</fieldset>';	
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
			if ( $good )
				$yesno = '<b><font color="green">Yes</font></b>';
			else
			{
				$yesno = '<b><font color="red">No</font></b>';
				echo $message .'</td><td>'. $yesno .'<BR/>';
			}
		}
		
	{/php}



{else}
	{#PLIGG_Visual_Header_AdminPanel_NoAccess#}
{/if}
