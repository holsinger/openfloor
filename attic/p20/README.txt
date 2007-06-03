Pligg Content Management System
Beta 9.1
02.18.2007


Homepage:
http://www.pligg.com

Support Forum:
http://www.pligg.com/forum/




#######################################################
################## INSTALLING #########################
#######################################################

1. Create a mysql database. Example "pligg."
   Note - Have your database name, username, password, and 
   host handy before installing

2. Rename settings.php.default to settings.php. Do the same 
   for /libs/dbconnect.php.default.

3. Upload the files to your server.

4. chmod 777
 
	/avatars/user_uploaded
	/backup
	/cache	
	/rss/templates_c	
	/templates
	/templates_c

5. chmod 666

	/libs/dbconnect.php
	/libs/lang.conf
	/libs/options.php	
	settings.php
6. chmod 655 

	config.php

7. Open www.<yoursite>.com/install/ in your web browser.
     Step 1: Make sure to read the entire page and click continue 
             at the bottom when finished
     Step 2: Fill out your database name, username, password, host, 
             and your desired table prefix.
     Step 3: Make sure there are no error messages!

8. Delete your /install folder.

9. chmod 644 libs/dbconnect.php

10. Open www.<yoursite>.com

11. Use the god account. Login: god - Password: 12345 to make the changes needed.

12. Change the password from 12345 to something different as soon as possible.




#######################################################
################## UPGRADING ##########################
#######################################################

******************************************************
Please be sure to make a backup of your MySQL databases
and files before upgrading to the newest version of Pligg.
Some upgrades might require that you upgrade your MySQL
database, so please keep backups available.
******************************************************

Note: Upgrading is supported for versions beta 8 and newer 

1. Make a backup copy of your config.php and settings.php 
   (or config2.php for older versions) file.

2. Upload the new build over current build. Make sure all directories 
   have the same chmod as mentioned in the installation instructions above.

3. If upgrading from beta 8 or below, Rename config2.php to settings.php.

4. Set permissions on config.php to 655.

5. Set permissions on settings.php and /avatar/user_uploaded to 777.

6. Run /install/upgrade.php.

7. Delete everything inside your templates_c directory.

8. Login to pligg, go into the admin panel, and set pligg to your liking.

Note: here is currently no way to import an existing config.php file. 
      Any manual changes to settings.php will be overwritten the next 
      time you use the admin panel, so use t to make your changes 
      instead of manually.





#######################################################
##################  BACKUP  ###########################
#######################################################

1. Log into your site as admin

2. Click on admin panel

3. Click on File and MySQL backup

4. Backup your file (and avatars) or your database






#######################################################
################## Thanks and Such ####################
#######################################################

This code was originally written by Ricardo Galli
You can see his blog at http://mnm.uib.es/gallir/
and the original Meneame at http://meneame.net/
This code is published under the Affero General Public 
License.  You can view the license in the file
LICENSE.txt.

Questions/Comments?
-Contact us using the Pligg forum http://www.pligg.com/forum/

Many thanks to those who have donated their time and
money to the Pligg project.

 Special thanks to (in no particular order):
 - AshDigg
 - Yankidank
 - Kbeeveer46
 - Savant
 - Jitgos
 - ChuckRoast
 - Beatniak
