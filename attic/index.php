<?php
/*
 * Created on Apr 2, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 if ( isset($_POST['email']) ) {
 	$handle = fopen("emails.txt", "r");
	if ( ($data = fgetcsv($handle, 10000, ",")) !== FALSE ) {
		if ( !in_array($_POST['email'],$data) ) {
		 	//save data
			$fp = fopen("emails.txt", "a");
			fwrite ($fp, $_POST['email'].", ");
			fclose ($fp);			
		}
	} 
	fclose ($handle);
 }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250">
  <LINK REL="stylesheet" TYPE="text/css" HREF="style.css">
 <!--[if lt IE 7]>
 <script defer type="text/javascript" src="pngfix.js"></script>
 <![endif]--> 	  
  </head>
  <BODY>
  	<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="100%">
		<TR>	
			<TD VALIGN="top" WIDTH="35" class='ticker'><img src="images/spc.gif" width="35"></TD>
			<TD VALIGN="top" WIDTH="100%">
				<!-- OPEN CONTENT TABLE -->
				<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" WIDTH="100%" height="100%">
					<TR><TD VALIGN="top" align='center'><img src="images/spc.gif" width="35" height="35"></TD></TR>
					<TR><TD ALIGN='center' valign="top">
						<TABLE CELLPADDING="0" CELLSPACING="0" BORDER="0" class='whiterounded'>
							<TR>
								<TD align="center">
									<img src='images/logo.png' width='483' height='222'>
									<hr>
									<p>Enter your email address below to sign up for our newsletter<br>
									to find out <span class='red'>what</span> we're about, <span class='red'>when</span> we're launching, and <span class='red'>how</span> <span class='blue'>Politic</span><span class='red'>2</span><span class='blue'>.</span><span class='red'>0</span><SUP><SMALL class='blue'>TM</SMALL></SUP><br>
									will change the face of politics forever...
									</p>
									<hr>
									<br />									
									<img src='images/quote.png' width='254' height='44'>
									<div id='flag'>
									<br /><br />
									<? if ( isset($_POST['email']) ) echo '<span class="blue">Your email address was added.</spam><br />';
									else echo '<br />'; ?>
									<form method='post'>									
									<input id='contactInput' type='text' name='email'>&nbsp;&nbsp;
									<input id='contactButton' type='submit' name='submit' value='Subscribe'>
									<br /><br />
									<span class='small'><span class='blue'>**</span>Privacy Policy: We won't sell or share your email address ever. Period.'<span class='blue'>**</span></span>
									</div>
								</TD>
							</TR>
						</TABLE>
					</TD></TR>
					<TR><TD VALIGN="top" align='center'><img src="images/tagline.png" width="368"></TD></TR>			
					<TR><TD VALIGN="top" align='center'><br><br><br><p class='small'>Copyright &#169; 2007 Politic20.com. All Rights Reservec. Reproduction in whole<br>or part in any form or medium without express written permission is strictly prohibited.</p></TD></TR>
					<TR><TD VALIGN="top" align='center' height='100%'><br><br><br></TD></TR>
				</TABLE>
			</TD>
			<TD VALIGN="top" WIDTH="35" BGCOLOR="0157AC"><img src="images/spc.gif" width="35"></TD>
		</TR>
	</TABLE>
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
	</script>
	<script type="text/javascript">
	_uacct = "UA-1010094-3";
	urchinTracker();
	</script>
  </BODY>
</html>