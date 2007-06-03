<li>
  <div class="box" id="sidenavbox">
    <h1><span class="expand"><a id="expnav" class="expand-up"></a></span><a class="htitle">{#PLIGG_Visual_Name#}</a></h1>
    <ul id="sidenav">
     
      <li><a href="{$URL_upcoming}">{#PLIGG_Visual_Pligg_For_Stories#}</a></li>

      <li><a href="{$URL_submit}">{#PLIGG_Visual_Submit_A_New_Story#}</a></li>

	  {if $Enable_Live eq 'true'}
      <li><a href='{$URL_live}'>{#PLIGG_Visual_Live#}</a></li>
      {/if}
      
      {if $Enable_Tags eq 'true'}
      <li><a href='{$URL_tagcloud}'>{#PLIGG_Visual_Tags#}</a></li>
      {/if}
	  
      <li><a href='{$URL_topusers}'>{#PLIGG_Visual_Top_Users#}</a></li>
	  
    </ul>
  </div>
</li>