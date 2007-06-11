#! /bin/bash
# checkout from SVN into this directory ...
#
#  practice.politic20.com

# Change to the root directory above the source ...
cd /home/politic20

#echo "Removing app/config/database*.php files ...<br><br>"
#rm -f httpdocs/app/config/database.php
#rm -f httpdocs/app/config/database_staging.php

echo "Running SVN CHECKOUT:<br><br>"
echo "<TEXTAREA NAME="SVN Update Output" COLS=80 ROWS=20>"
pwd
svn co http://engeb.svnrepository.com/svn/politic20/trunk/ practice/
echo "</TEXTAREA><br>"
echo "<b>NOTE:</b> Make sure to look and see that it worked!<br>"

#echo "Restoring database_dev.php to database.php for dev.ridemybike.com ...<br>"
#cp httpdocs/app/config/database_staging.php httpdocs/app/config/database.php

echo "... check out completed."
