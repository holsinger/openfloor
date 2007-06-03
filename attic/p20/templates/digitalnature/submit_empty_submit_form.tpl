<br />
<form action="{$URL_submit}" method="post" id="thisform">
  <fieldset>
  <legend>{#PLIGG_Visual_Submit1_NewsSource#}</legend>
  <br />
  <label for="url">{#PLIGG_Visual_Submit1_NewsURL#}:</label>
  <input type="text" name="url" id="url" value="http://" size=55 class="form-full" />
 
  <input type="hidden" name="phase" value=1>
  <input type="hidden" name="randkey" value="{$submit_rand}">
  <input type="hidden" name="id" value="c_1"> <br />
  <input type="submit" value="{#PLIGG_Visual_Submit1_Continue#}" class="submit-s" />
  <br />
  </fieldset>
</form>
<br />
{if $Submit_Require_A_URL neq 1}{#PLIGG_Visual_Submit_Editorial#}{/if} 