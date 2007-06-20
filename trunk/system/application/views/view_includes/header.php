<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	
		
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<base href="<?= $this->config->site_url();?>" />
	<style media="all" type="text/css">@import "css/all.css";</style>
	<style media="all" type="text/css">@import "css/userWindow.css";</style>
	<!--[if lt IE 7]><link rel="stylesheet" type="text/css" href="css/lt7.css" media="screen"/><![endif]-->
	
	<script type="text/javascript" src="javascript/prototype.js"></script>
	<script type="text/javascript" src="javascript/userWindow.js"></script>
	<title>Politic 2.0</title>
	<link rel="icon" href="/p20/favicon.ico" type="image/x-icon"/>
</head>

<body>
<div id="overlay" onclick="hideBox()" style="display:none"></div>

<div id="zipNine" class="box" style="display:none">
    <img id="close" src="images/close.gif" onclick="hideBox('zipNine')" alt="Close" 
         title="Close this window" />
         
         <table width="461" border="0" cellpadding="0" cellspacing="0" summary="This table contains the search by address input fields.">
			<tr>
				<td colspan="4">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="4"><span class="mainBold">A nine digit Zip Code is required to determine "Your Government"</span><br></td>
			</tr>
			<tr>
			  <td colspan="4"><span class="mainBold">Find your nine digit ZIP Code by entering an address.</span><br>
		        <span class="main">(You can also search for a partial address, such as "Main Street, Fairfax, VA.")</span>
		        <span class="main">Politic 2.0 will never use this information for anyhting other then helping you determine your nine digit zip code.</span>
		      </td>
			</tr>

			<tr>
				<td colspan="4" height="30" valign="bottom"><span class="mainRed">*</span> <span class="main">Required Fields</span></td>
			</tr>
			<tr>
				<td width="107"><img src="images/spacer.gif" width="107" height="1" alt="All field labels with a * are required" border="0" /></td>
				<td width="10"><img src="images/spacer.gif" width="10" height="1" alt="" border="0" /></td>
				<td width="289"><img src="images/spacer.gif" width="289" height="1" alt="" border="0" /></td>

				<td width="55"><img src="images/spacer.gif" width="55" height="1" alt="" border="0" /></td>
			</tr>
<!-- *** ADDRESS2 *********************************************************************** -->
			<tr>
				<td height="28" align="right"><span class="mainRed">*</span><span class="main"> Address 1</span></td>
				<td></td>
				<td><input name="address2" tabindex="1" id="address2" style="width:280px;" type="text" maxlength="50" /><div style="display:none;"><label for="address2">* Address 1</label></div></td>

				<td></td>
			</tr>
<!-- *** ADDRESS1 *********************************************************************** -->
			<tr>
				<td height="28" align="right" class="main">Address 2</td>
				<td></td>
			  <td colspan="2"><input tabindex="2" id="address1" style="width:80px;" type="text" name="address1" maxlength="50" /><div style="display:none;"><label for="address1">Address 2. Example Apartment, floor, suite, etc.</label></div><span class="smGray">&nbsp;Apt, floor, suite, etc.</span></td>
			</tr>

<!-- *** CITY *********************************************************************** -->
			<tr>
				<td height="28" align="right"><span class="mainRed">*</span> <span class="main"> City</span></td>
				<td></td>
				<td><input tabindex="3" id="city" style="width:280px;" type="text" name="city" maxlength="50" ><div style="display:none;"><label for="city">* City</label></div></td>
				<td></td>
			</tr>

<!-- *** STATE *********************************************************************** -->
			<tr>
				<td height="28" align="right"><span class="mainRed">*</span> <span class="main"> State</span></td>
				<td></td>
				<td colspan="2"><input onBlur="checkState(form1)" tabindex="4" id="state" style="width:38px;" type="text" name="state" onKeyPress="return validate_for_characters(this, event)" maxlength="2" />
				&nbsp;<span class="smGray" style="padding-right:15px;"><a title="Find state abbreviation" href="zcl_0_landing_state.htm" onClick="return statePopup(this, 'states');" tabindex="5" >Find state abbreviation</a></span>
				<div style="display:none"><label for="state">* State. Press Tab to go to State Abbreviation List</label></div>

<!-- *** URBANIZATION *********************************************************************** -->

				<input type="hidden" name="urbanization" value=""><div style="display:none;"><label for="urbanization"> * Urbanization</label></div>


				</td>
			</tr>
<!-- *** ZIP5 *********************************************************************** -->
			<tr>
				<td height="28" align="right" class="main">ZIP Code</td>

				<td></td>
				<td><input tabindex="7" id="zip5" style="width:75px;" type="text" name="zip5" maxlength="10" onKeyPress="return validate_for_integers(this, event, zip5)" /><div style="display:none;"><label for="zip5">ZIP Code</label></div></td>
				<td></td>
			</tr>
			<tr valign="top">
				<td></td>
				<td></td>
				<td height="35" align="left" class="main"><div style="margin-top:20px; margin-bottom:20px;" ><input name="submit" type="image" tabindex="8" value="Find ZIP Code" src="images/button_submit_akqa.gif" title="Submit" width="70" height="17"/></div></td>

				<td></td>
			</tr>
	    </table>
	    
</div>
<? $this->load->view('ajax/view_login.php'); ?>

		<div id="page">
		<!-- header start here -->
		<div id="header">
			<h1><a href="http://www.politic20.com">Politic20</a></h1>
			<? if ($this->session->userdata('user_name')) { ?>
			<div id="userLogin"><br />welcome <a href="index.php/user/profile/<?=$this->session->userdata('user_name');?>"><?=$this->session->userdata('user_name');?></a>&nbsp;|&nbsp;<a href="index.php/user/logout/">Logout</a></div>
			<? } else { ?>
			<div id="userLogin">Customize your P20 experience<br /> <span onClick="showBox('login');">Login</span>&nbsp;|&nbsp;<a href="index.php/user/create/">Create Account</a></div>
			<? } ?>
			<form action="whosyourgovt.php" method="get">
				<div>
					<input type="text" class="txt" name="zip" value="<?= isset($_GET['zip'])?$_GET['zip']:'' ?>"/>
					<input type="image" src="images/btn-go.gif" alt="search" />

				</div>
			</form>
		</div>
		<!-- top navigation start here -->
		<div class="body">
      <ul class="top-nav">
  			<li><span><a href="http://www.politic20.com">Home</a></span></li>
  			<li><a href="#">Events</a></li>
  			<li><a href="#">About Us</a></li>
  			<li><a href="http://blog.politic20.com">Blog</a></li>
  
  		</ul>
  		<div class="slogan"><strong class="slogan">populace politic change</strong></div>
  		
  		<div id="pagewidth">
  			
  			<div class="frame">
