{config_load file="/libs/lang.conf"}
<h2>{$page_header}</h2>
{if $register_error eq true}
	<div class="form-error">
	<p>{$register_error_text}</p>
	</div>

{else}
	<br style="clear:both" />
	<div id="contents-wide">
		<form action="{$URL_register}" method="post" id="thisform">
			<fieldset><legend><span class="sign">{#PLIGG_Visual_Register_Validation#}</span></legend>
		
				{#PLIGG_Visual_Register_Enter_Number#}<br />
				
				<input type="hidden" name="ts_random" value="{$ts_random}" /><br />
				<img src="{$my_pligg_base}/ts_image.php?ts_random={$ts_random}" class="ch2" />
				<p><input type="text" size="20" name="ts_code" /><br /><br />			
				<input type="submit" name="submit" value="{#PLIGG_Visual_Register_Continue#}" class="submit" /></p>
				<input type="hidden" name="process" value="2" />
				<input type="hidden" name="email" value="{$templatelite.post.email}" />
				<input type="hidden" name="username" value="{$templatelite.post.username}" />
				<input type="hidden" name="password" value="{$templatelite.post.password}" />
				<input type="hidden" name="reghash" value="{$reghash}" />
				{*<input type="hidden" name="charset_check" value="�.�" />*}
			</fieldset>
		</form>
	</div>
{/if}
