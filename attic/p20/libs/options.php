<?php

//Story times
define ('PLIGG_Visual_Story_Times_Days', 'days');
define ('PLIGG_Visual_Story_Times_Day', 'day');
define ('PLIGG_Visual_Story_Times_Hours', 'hours');
define ('PLIGG_Visual_Story_Times_Hour', 'hour');
define ('PLIGG_Visual_Story_Times_Minutes', 'minutes');
define ('PLIGG_Visual_Story_Times_Minute', 'minute');
define ('PLIGG_Visual_Story_Times_FewSeconds', 'few seconds');

define ('PLIGG_Visual_Pligg_Today', 'Top Today');

// Queued news header in sidebar
define ('PLIGG_Visual_Pligg_Queued', 'Queued News');


// Published news header in sidebar
define ('PLIGG_Visual_Published_News', 'Published News');


// Podcast - Devs, why is this duplicated in lang.conf?
define ('PLIGG_Visual_Podcast_Title', 'Pligg Podcast');
define ('PLIGG_Visual_Podcast_Description', 'Pligg Web 2.0 Podcast Content Management System');
define ('PLIGG_Visual_Podcast_Link', 'http://www.pligg.com/forum/');
define ('PLIGG_Visual_Podcast_Language', 'en-us');
define ('PLIGG_Visual_Podcast_Copyright', 'Copyright 2006');
define ('PLIGG_Visual_Podcast_Webmaster', 'podcast@pligg.com');
define ('PLIGG_Visual_Podcast_iTunes_Author', 'Yankidank');
define ('PLIGG_Visual_Podcast_iTunes_Subtitle', 'A podcast powered by Pligg');
define ('PLIGG_Visual_Podcast_iTunes_Summary', 'Make your own Pligg Podcast by visiting www.pligg.com/forum/');
define ('PLIGG_Visual_Podcast_iTunes_Owner', 'Yankidank');
define ('PLIGG_Visual_Podcast_iTunes_Owner_Email', 'podcast@pligg.com');
define ('PLIGG_Visual_Podcast_iTunes_Image', 'http://www.pligg.com/img/logo.png');
define ('PLIGG_Visual_Podcast_iTunes_Explicit', 'No');
define ('PLIGG_Visual_Podcast_Category', 'Technology');
define ('PLIGG_Visual_Podcast_Subcategory', 'Podcast'); 


// Forgotten Password page
define ('PLIGG_PassEmail_Subject', 'Your password change request.');
define ('PLIGG_PassEmail_Body', 'Your password change request confirmation code is: ');
define ('PLIGG_PassEmail_From', 'webmaster@pligg.com');
define ('PLIGG_PassEmail_SendSuccess', 'Message successfully sent! Please check your email for your confirmation code.');
define ('PLIGG_PassEmail_LimitPerSecond', 60);
define ('PLIGG_PassEmail_LimitPerSecond_Message', "ERROR - We're sorry, you can only make one request per minute. Thank you.");


//Profile Page
define ('PLIGG_Visual_Profile_BadEmail', 'the email address provided is not correct');
define ('PLIGG_Visual_Profile_BadPass', 'the passwords provided did not match, your password was not changed');
define ('PLIGG_Visual_Profile_BadOldPass', 'the old password you provided is wrong');
define ('PLIGG_Visual_Profile_PassUpdated', 'your password has been updated');
define ('PLIGG_Visual_Profile_DataUpdated', 'data updated');


//Voting
define ('PLIGG_Visual_Menealo_NoAnon', 'anonymous votes are temporarily disabled');
define ('PLIGG_Visual_Menealo_BadUser', 'incorrect user');
define ('PLIGG_Visual_Menealo_BadKey', 'incorrect key');
define ('PLIGG_Visual_Menealo_AlreadyVoted', 'You have already voted for this article');


//Edit a comment
define ('PLIGG_Visual_EditComment_NotYours', 'This does not appear to be your comment.');
define ('PLIGG_Visual_EditComment_Click', 'Click ');
define ('PLIGG_Visual_EditComment_Here', 'here');
define ('PLIGG_Visual_EditComment_ToReturn', ' to return to the story');
define ('PLIGG_Visual_EditComment_Removed', 'Removed_by_a_moderator.');
define ('PLIGG_Visual_EditComment_ReplaceWithRemoved', 'Replace comment with "Removed by a moderator"');


//Edit a link / story
define ('PLIGG_Visual_EditLink_NotYours', 'Not your link.');


//Submitting a new story.
define ('PLIGG_Var_Submit_MinTitleLen', 10);  //Title must be at least X characters long
define ('PLIGG_Var_Submit_MinContentLen', 10);  //Description (content) must be at least X characters long


//The page links at the bottom of the index + upcoming pages.
define ('PLIGG_Visual_Page_Previous', 'previous');
define ('PLIGG_Visual_Page_Next', 'next');


//Login -- Forgotten Password
define ('PLIGG_Visual_Login_Forgot_Error', 'ERROR - please enter your username');
define ('PLIGG_Visual_Login_Forgot_PassReset', 'Your password has been reset to "password". Please login and change your password.'); //DO NOT CHANGE THE "password" PART
define ('PLIGG_Visual_Login_Forgot_ErrorBadCode', 'ERROR - Confirmation code does not match.');


//Trackback
define ('PLIGG_Visual_Trackback', 'trackbacks');
define ('PLIGG_Visual_Trackback_AlreadyPing', 'We already have a ping from that URL for this post.');
define ('PLIGG_Visual_Trackback_BadURL', 'The provided URL does not seem to work.');
define ('PLIGG_Visual_Trackback_NoReturnLink', 'The provided URL does not have a link back to us.');


 //checkfield.php 	 
define ('PLIGG_Visual_CheckField_UserShort', 'username is too short'); 	 
define ('PLIGG_Visual_CheckField_InvalidChars', 'invalid characters'); 	 
define ('PLIGG_Visual_CheckField_UserExists', 'the username provided already exists'); 	 
define ('PLIGG_Visual_CheckField_EmailInvalid', 'the email address provided is not valid'); 	 
define ('PLIGG_Visual_CheckField_EmailExists', 'another user with that email has registered');


// RSS 	 
define ('PLIGG_Visual_Name', 'Pligg beta 9');
define ('PLIGG_Visual_RSS_Published', 'published'); 	 
define ('PLIGG_Visual_RSS_Queued', 'queued'); 	 
define ('PLIGG_Visual_RSS_All', 'all');
define ('PLIGG_Visual_RSS_Voted', 'voted');
define ('PLIGG_Visual_RSS_Commented', 'commented'); 	 
define ('PLIGG_Visual_RSS_Recent', 'recent'); 	 
define ('PLIGG_Visual_RSS_RSSFeed', 'RSS Feed'); 	 
define ('PLIGG_Visual_RSS_OriginalNews', 'original news'); 	 
define ('PLIGG_Visual_RSS_Description', 'Pligg Web 2.0 Content Management System');
?>