<li>
  <div class="box" id="loggedinbox">
    <div class="box2" id="loggedin">
      <div class="wrap">
        <div class="content">
          <div style="padding:10px 6px;">
            <h3><img class="welcome-avatar" src="{$Current_User_Avatar_ImgSrc}"/> {#PLIGG_Visual_Welcome_Back#} {$user_logged_in}</h3>
            <br clear="all" />
            <ul>
			  <li> <a href="{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Home#}</a></li>
			
              <li> <a href="{$URL_userNoVar}">{#PLIGG_Visual_Profile#}</a> </li>
			  
			  {checkActionsTpl location="tpl_sidebar_logged_in_just_below_profile"}
			  
              {if $isadmin eq 1}
              <li> <a href="{$URL_admin}">{#PLIGG_Visual_Header_AdminPanel#}</a> </li>
              {/if}
              <li> <a href="{$URL_logout}">{#PLIGG_Visual_Logout#}</a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

</li>