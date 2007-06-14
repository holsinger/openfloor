<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	
		
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<div id="login" class="box" style="display:none">
    <img id="close" src="images/close.gif" onclick="hideBox('login')" alt="Close" 
         title="Close this window" />
         
<form name="userlogin" method="post" action="/index.php?title=Special:Userlogin&amp;action=submitlogin&amp;type=login&amp;returnto=Special:Userlogin">

	<h2>Log in</h2>
	<p id="userloginlink">Don't have a login? <a href="/index.php?title=Special:Userlogin&amp;type=signup&amp;returnto=Special:Userlogin">Create an account</a>.</p>
	<div id="userloginprompt"><p>You must have cookies enabled to log in to WikiReview.
</p></div>
		<table>
		<tr>
			<td align='right'><label for='wpName1'>Username:</label></td>

			<td align='left'>
				<input type='text' class='loginText' name="wpName" id="wpName1"
					tabindex="1"
					value="" size='20' />
			</td>
		</tr>
		<tr>
			<td align='right'><label for='wpPassword1'>Password:</label></td>
			<td align='left'>
				<input type='password' class='loginPassword' name="wpPassword" id="wpPassword1"
					tabindex="2"
					value="" size='20' />

			</td>
		</tr>
			<tr>
			<td></td>
			<td align='left'>
				<input type='checkbox' name="wpRemember"
					tabindex="4"
					value="1" id="wpRemember"
										/> <label for="wpRemember">Remember my login on this computer</label>
			</td>
		</tr>

		<tr>
			<td></td>
			<td align='left' style="white-space:nowrap">
				<input type='submit' name="wpLoginattempt" id="wpLoginattempt" tabindex="5" value="Log in" />&nbsp;<input type='submit' name="wpMailmypassword" id="wpMailmypassword"
					tabindex="6"
									value="E-mail password" />
							</td>
		</tr>
	</table>
</form>
         
</div>
<div id="createAccount" class="box" style="display:none">
    <img id="close" src="images/close.gif" onclick="hideBox('createAccount')" alt="Close" 
         title="Close this window" />
    
    <form name="userlogin2" id="userlogin2" method="post" action="/index.php?title=Special:Userlogin&amp;action=submitlogin&amp;type=signup&amp;returnto=Special:Home" onSubmit="if (validate(this) == false) return false; else { hideButton('button','text');}">

	<h2>Create account</h2>
	
			<div id='errorArea'></div>
	<table>
		<tr>
			<td align='right'><label for='wpName2'>Username:</label></td>

			<td align='left'>
				<input type='text' class='loginText' name="wpName" id="wpName2"
					tabindex="1"
					value="" size='20' />
			</td>
			
		</tr>
		<tr>

			<td align='right'><label for='wpPassword2'>Password:</label></td>
			<td align='left'>
				<input type='password' class='loginPassword' name="wpPassword" id="wpPassword2"
					tabindex="2"
					value="" size='20' />
			</td>
		</tr>
			<tr>
			<td align='right'><label for='wpRetype'>Retype password:</label></td>
			<td align='left'>

				<input type='password' class='loginPassword' name="wpRetype" id="wpRetype"
					tabindex="4"
					value=""
					size='20' />
			</td>
		</tr>
		<tr>
							<td align='right'><label for='wpEmail'>E-mail :</label></td>
				<td align='left'>
					<input type='text' class='loginText' name="wpEmail" id="wpEmail"
						tabindex="5"
						value="" size='20'  alt='email,required'/>
				</td>

								</tr>
		<tr>
<td align='right'><label for='wpRetype'>Zip:</label></td>
<td align='left'>
<input type='text' name='zip'   value=''id='zip' alt='alphanum,required' tabindex='7'></td>
</tr>
<tr>
<td align='right'><label for='wpRetype'>Age:</label></td>
<td align='left'>
<select name='age'  id='age' title='select,required' tabindex='8'><option value='0'>- Select One-</option>
<option value='7'>14-17</option>

<option value='8'>18-24</option>
<option value='9'>25-34</option>
<option value='10'>35-44</option>
<option value='11'>45-54</option>
<option value='12'>55-64</option>
<option value='13'>65-74</option>
<option value='14'>75+</option>
</select></td>
</tr>
<tr>

<td align='right'><label for='wpRetype'>Sex:</label></td>
<td align='left'>
<select name='sex'  id='sex' title='select,required' tabindex='9'><option value='0'>- Select One-</option>
<option value='15'>Male</option>
<option value='16'>Female</option>
<option value='30'>Transgender</option>
</select></td>
</tr>
<tr>
<td align='right'><label for='wpRetype'>Race:</label></td>
<td align='left'>

<select name='race'  id='race' title='select,required' tabindex='10'><option value='0'>- Select One-</option>
<option value='17'>No Answer</option>
<option value='18'>Asian</option>
<option value='19'>Black / African descent</option>
<option value='20'>White / Caucasian</option>
<option value='21'>Other</option>
<option value='31'>Hispanic or Latino</option>
<option value='32'>American Indian or Alaska Native</option>
<option value='33'>Native Hawaiian or Other Pacific Islander</option>

<option value='34'>Multiracial</option>
</select></td>
</tr>
<tr>
<td align='right'><label for='wpRetype'>Professional field:</label></td>
<td align='left'>
<select name='professional+field'  id='professional+field' title='select,required' tabindex='11'><option value='0'>- Select One-</option>
<option value='22'>Owner/Proprietor</option>
<option value='23'>Technical</option>
<option value='24'>Sales</option>
<option value='25'>Student</option>

<option value='35'>Admin/office</option>
<option value='36'>Art</option>
<option value='37'>Business</option>
<option value='38'>Customer Service</option>
<option value='39'>Education</option>
<option value='40'>Engineering</option>
<option value='41'>Etcetera</option>
<option value='42'>Finance</option>
<option value='43'>Food/Bev/Hosp</option>

<option value='44'>General Labor</option>
<option value='45'>Government</option>
<option value='46'>Healthcare</option>
<option value='47'>Human Resource</option>
<option value='48'>Legal</option>
<option value='49'>Manufacturing</option>
<option value='50'>Marketing</option>
<option value='51'>Media</option>
<option value='52'>Nonprofit</option>

<option value='53'>Real Estate</option>
<option value='54'>Retail/Wholesale</option>
<option value='55'>Salon/Spa/Fitness</option>
<option value='56'>Science</option>
<option value='57'>Security</option>
<option value='58'>Skilled Trades</option>
<option value='59'>Transport</option>
<option value='60'>Writing</option>
<option value='61'>Other</option>

</select></td>
</tr>
<tr>
<td align='right'><label for='wpRetype'>Yearly income:</label></td>
<td align='left'>
<select name='yearly+income'  id='yearly+income' title='select,required' tabindex='12'><option value='0'>- Select One-</option>
<option value='26'>Less than $20,000</option>
<option value='27'>$20,000 - $34,999</option>
<option value='28'>$35,000 - $49,999</option>
<option value='29'>$50,000 - $74,999</option>
<option value='62'>$75,000 - $99,999</option>

<option value='63'>$100,000 - $499,999</option>
<option value='64'>$499,999 or more</option>
</select></td>
</tr>
				<tr>
			<td></td>
			<td align='left'>
				<input type='checkbox' name="wpRemember"
					tabindex="17"
					value="1" id="wpRemember"
										/> <label for="wpRemember">Remember my login on this computer</label>
			</td>

		</tr>
		<tr>
			<td></td>
			<td align='left'>
			<div id="text" style="padding-right: 20px; float: left; display: none;">
	          <br>
	          Please Wait..
	        </div>
	        <div id="button" style="padding-right: 20px; float: left;">

				<input type='submit' name="wpCreateaccount" id="wpCreateaccount"
					tabindex="18"
					value="Create account" />
							</div>
			</td>
		</tr>
	</table></form>
	
</div>

			<div id="page">
		<!-- header start here -->
		<div id="header">
			<h1><a href="http://www.politic20.com">Politic20</a></h1>
			<form action="whosyourgovt.php" method="get">
				<div>
					<input type="text" class="txt" name="zip" value="<?= $_GET['zip']; ?>"/>
					<input type="image" src="images/btn-go.gif" alt="search" />

				</div>
			</form>
		</div>
		<!-- top navigation start here -->
		<div class="body">
      <ul class="top-nav">
  			<li><span><a href="http://www.politic20.com">Home</a></span></li>
  			<li><a href="#">About Us</a></li>
  			<li><a href="http://blog.politic20.com">Blog</a></li>
  
  		</ul>
  		<div class="slogan"><strong class="slogan">populace politic change</strong></div>
  		
  		<div id="pagewidth">
  			<div id="userWindow" onClick="showBox();">Customize your P20 experiance<br /> <a href="#" onClick="showBox('login');">Login</a> <a href="#" onClick="showBox('createAccount');">Create Account</a></div>
  			<div class="frame">
