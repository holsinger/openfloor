{literal}
	<style type='text/css' media='screen,projection'>
	<!--
	fieldset { border:0;margin:0;padding:0; }
	label { display:block; }
	input.text,textarea { width:300px;font:12px/12px 'courier new',courier,monospace;color:#333;padding:3px;margin:1px 0;border:1px solid #ccc; }
	input.submit { padding:2px 5px;font:bold 12px/12px verdana,arial,sans-serif; }
	-->
	</style>
{/literal}

	<h2>Contact Form</h2>
	<p id="loadBar" style="display:none;">
		<strong>Sending Email</strong> <img src="{$ajaxcontact_path}img/loading.gif" alt="Loading..." title="Sending Email" align="absmiddle" />
		<br /><br />
	</p>
	<p id="emailSuccess" style="display:none;">
		<strong style="color:green;">Success! Your Email has been sent.</strong>
		<br /><br />
	</p>
	
	<div id="contactFormArea">
		<form action="{$ajaxcontact_path}scripts/contact.php" method="post" id="cForm">
			<fieldset>
				Name:<br />
				<input class="text" type="text" size="25" name="posName" id="posName" /><br /><br />
				Email:<br />
				<input class="text" type="text" size="25" name="posEmail" id="posEmail" /><br /><br />
				Regarding:<br />
				<input class="text" type="text" size="25" name="posRegard" id="posRegard" /><br /><br />
				Message:<br />
				<textarea cols="50" rows="5" name="posText" id="posText"></textarea><br /><br />
				<label for="selfCC">
					<input type="checkbox" name="selfCC" id="selfCC" value="send" /> Send CC to self
				</label><br />
				<label>
					<input class="submit" type="submit" name="sendContactEmail" id="sendContactEmail" value=" Send Email " />
				</label>
			</fieldset>
		</form>
	</div>
