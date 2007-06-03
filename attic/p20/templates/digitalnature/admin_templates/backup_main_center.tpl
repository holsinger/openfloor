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
			
			echo "<fieldset style=padding:10px 10px 10px 10px><legend>Backup</legend>";
			echo '<br/><h3>Backup Function v1.1</h3><a href = "?dobackup=files">Backup all files (except avatars)</a><br>';
			echo '<a href = "?dobackup=avatars">Backup avatars</a><br>';
			echo '<a href = "?dobackup=database">Backup the database</a><br><br>';
			echo "<h4 style='border:none'> Previously created backups</h4>";
			echo '<a href = "?dobackup=clearall">Remove all the backups listed below</a><hr><br>';
			
			
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

	<br />
	
	 <input type=button onclick="window.history.go(-1)" value="back" class="log2">


{else}
	{#PLIGG_Visual_Header_AdminPanel_NoAccess#}
{/if}
