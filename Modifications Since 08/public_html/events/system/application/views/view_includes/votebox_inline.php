<?php
if ($voted < 0) {
	echo "<img src='./images/thumbsUp.png' border='0'>";
	#echo " <img src='./images/votedCheckBox.png' border='0'>";
	echo " <div class='checkbox'></div>";
} else if ($voted > 0) {
	#echo " <img src='./images/votedCheckBox.png' border='0'>";
	echo " <div class='checkbox'></div>";
	echo " <img src='./images/thumbsDown.png' border='0'>";
} else {
	echo anchor("/comment/voteUp/", "<img src='./images/thumbsUp.png' border='0'>");
	echo " ".anchor("/comment/voteDown/", "<img src='./images/thumbsDown.png' border='0'>");
}