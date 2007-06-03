{config_load file="/libs/lang.conf"}
<div id="comments">
    <h2>{#PLIGG_Visual_Story_WhoVoted#}</h2>
    <div class = "whovotedwrapper" id = "idwhovotedwrapper">
        <ol
        {section name=nr loop=$voter}
            ><li>{if $UseAvatars neq "0"}<span><img src="{$voter[nr].Avatar_ImgSrc}" alt="Avatar" align="absmiddle"/></span>{/if} <a href = "{$user_url}{$voter[nr].user_login}">{$voter[nr].user_login}</a><br/></li
        {/section}
        ></ol><br/>
    </div>
</div>

{php}
?>
<style type="text/css">
  /* allow room for 3 columns */
  div#idwhovotedwrapper ol
  {
    width: 35em;
    list-style-type: none;
  }

  /* float & allow room for the widest item */
  div#idwhovotedwrapper ol li
  {
    float: left;
    width: 10em;
  }

  /* stop the float */
  div#idwhovotedwrapper br
  {
    clear: left;
  }

  /* separate the list from subsequent markup */
  div#idwhovotedwrapper div.whovotedwrapper
  {
    margin-bottom: 1em;
  }
</style>
<?php
{/php}