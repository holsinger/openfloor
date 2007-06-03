<?php

class FileBackup {
	var $Success = 0;

	function MakeBackup() {
		
		include ('zip.php');
		
		$xlist = array();
		$files = $this->filelist("./",1,0); // call the function
		foreach ($files as $list) {//print array
		   //echo "Directory: " . $list['dir'] . " => Level: " . $list['level'] . " => Name: " . $list['name'] . " => Path: " . $list['path'] ."<br>";
		   // If the entry is just the name of a directory, don't include it
		   // because the ZIP will take EVERYTHING inside of that subfolder
		   // and will get stuck in a loop trying to include the .zip file thats being created
		   // it gets stuck trying to add itself into itself
		   // it eventually breaks the loop, but takes a long time and sometimes timesout.
		  
		  	
		   // exclude the backup folder so we don't add in old backups.
		   // exclude the dbconnect.php file because it stores our passwords.
		   // exclude avatars (we just want a code backup)
		   // avatars are backed up seperately
		   if($list['dir'] == 0 && $list['path'] != "./backup/" && $list['path'] != "./avatars/" && $list['path'] != "./avatars/user_uploaded/" && $list['name'] != "dbconnect.php"){
		   		//echo $list['path'] . $list['name'] . "<BR>";
			   	$xlist[] = $list['path'] . $list['name'];
		   }
		}
		
		// code from http://www.phpit.net/article/creating-zip-tar-archives-dynamically-php/
		
		$zipname = 'FileBackup'."-".date("Y-m-d H-i-s").'.zip';
		$zipfile = New Archive_Zip('./backup/' . $zipname);
		//$list = array("../../");
		
		$zipfile->create($xlist);
		
		echo 'Zip file created -- <a href = "' . './backup/' . $zipname . '">'.$zipname.'</a>';
		$this->success = 1;

	}


	function MakeAvatarBackup() {
		include ('zip.php');
		$xlist = array();
		$files = $this->filelist("./avatars/",1,0); // call the function
		foreach ($files as $list) {//print array
		   if($list['dir'] == 0){
			   	$xlist[] = $list['path'] . $list['name'];
		   }
		}
		// code from http://www.phpit.net/article/creating-zip-tar-archives-dynamically-php/
		$zipname = 'AvatarBackup'."-".date("Y-m-d H-i-s").'.zip';
		$zipfile = New Archive_Zip('./backup/' . $zipname);
		$zipfile->create($xlist);
		echo 'Zip file created -- <a href = "' . './backup/' . $zipname . '">'.$zipname.'</a>';
		$this->success = 1;
	}

	// http://www.php.net/manual/en/function.opendir.php#60127
	/* The below function will list all folders and files within a directory
	It is a recursive function that uses a global array.  The global array was the easiest
	way for me to work with an array in a recursive function
	*This function has no limit on the number of levels down you can search.
	*The array structure was one that worked for me.
	ARGUMENTS:
	$startdir => specify the directory to start from; format: must end in a "/"
	$searchSubdirs => True/false; True if you want to search subdirectories
	$directoriesonly => True/false; True if you want to only return directories
	$maxlevel => "all" or a number; specifes the number of directories down that you want to search
	$level => integer; directory level that the function is currently searching
	*/
	function filelist ($startdir="./", $searchSubdirs=1, $directoriesonly=0, $maxlevel="all", $level=1) {
	   //list the directory/file names that you want to ignore
	   $ignoredDirectory[] = ".";
	   $ignoredDirectory[] = "..";
	   $ignoredDirectory[] = "_vti_cnf";
	   $ignoredDirectory[] = ".svn";
	   $ignoredDirectory[] = "templates_c";
	   global $directorylist;    //initialize global array
	   if (is_dir($startdir)) {
	       if ($dh = opendir($startdir)) {
	           while (($file = readdir($dh)) !== false) {
	               if (!(array_search($file,$ignoredDirectory) > -1)) {
	                 if (filetype($startdir . $file) == "dir") {
	                       //build your directory array however you choose;
	                       //add other file details that you want.
	                       $directorylist[$startdir . $file]['level'] = $level;
	                       $directorylist[$startdir . $file]['dir'] = 1;
	                       $directorylist[$startdir . $file]['name'] = $file;
	                       $directorylist[$startdir . $file]['path'] = $startdir;
	                       if ($searchSubdirs) {
	                           if ((($maxlevel) == "all") or ($maxlevel > $level)) {
	                               $this->filelist($startdir . $file . "/", $searchSubdirs, $directoriesonly, $maxlevel, $level + 1);
	                           }
	                       }
	                   } else {
	                       if (!$directoriesonly) {
	                           //if you want to include files; build your file array 
	                           //however you choose; add other file details that you want.
	                         $directorylist[$startdir . $file]['level'] = $level;
	                         $directorylist[$startdir . $file]['dir'] = 0;
	                         $directorylist[$startdir . $file]['name'] = $file;
	                         $directorylist[$startdir . $file]['path'] = $startdir;
	     }}}}
	           closedir($dh);
	}}
	return($directorylist);
	}

}
?>
