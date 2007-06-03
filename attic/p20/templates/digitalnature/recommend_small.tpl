<form name="email_to" method="get" action="{$my_base_url}{$my_pligg_base}/recommend.php">
  <fieldset>
  <legend>{#PLIGG_Visual_Recommend_FormTitle#}</legend>
  <br />
  <p>{#PLIGG_Visual_Recommend_EnterAddress#}</p>

    <input type="text" name="email_address_1" size = "35" id="email_address_1_{$link_shakebox_index}" value="">
    <br>
    <input type="text" name="email_address_2" size = "35" id="email_address_2_{$link_shakebox_index}" value="">
    <br>
    <input type="text" name="email_address_3" size = "35" id="email_address_3_{$link_shakebox_index}" value="">
    <br>
  <p>{#PLIGG_Visual_Recommend_Comment#}</p>
  <textarea name="email_message{$link_shakebox_index}" id="email_message{$link_shakebox_index}" cols="40" rows="5">{$Default_Message}</textarea>
  <br />
  <input type="button" name="email_to_submit" value="Submit" onclick="emailto ({$link_id}, {$link_shakebox_index}, '{$instpath}', 3);" class="log2">
  <br />
  </fieldset>
</form>

