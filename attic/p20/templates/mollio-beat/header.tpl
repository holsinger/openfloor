{config_load file="/libs/lang.conf"}

	<div id="site-name">{#PLIGG_Visual_Name#}</div>
		<div id="search">
			<form action="{$my_base_url}{$my_pligg_base}/search.php" method="get" name="thisform" id="thisform">			
			{if $templatelite.get.search neq ""}
				{assign var=searchboxtext value=$templatelite.get.search|sanitize:2}
			{else}
				{assign var=searchboxtext value=#PLIGG_Visual_Search_SearchDefaultText#}
			{/if}
			<input type="text" size="20" name="search" id="searchsite" value="{$searchboxtext}" onfocus="if(this.value == '{$searchboxtext}') {ldelim}this.value = '';{rdelim}" onblur="if (this.value == '') {ldelim}this.value = '{$searchboxtext}';{rdelim}"/>
			<input type="submit" value="{#PLIGG_Visual_Search_Go#}" class="submit" />
			</form>
		</div>
		<ul id="nav">
  		<li class="first"><a href="{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Home#}</a></li>
      {if $user_authenticated eq true}
        <li><a href="{$URL_userNoVar}">{#PLIGG_Visual_Profile#}</a>
		
		<ul>
			<li class="first"><a href="{$URL_userNoVar}">{#PLIGG_Visual_Profile_2#}</a></li>
			<li class="last"><a href="{$URL_profile}">{#PLIGG_Visual_Profile_3#}</a></li>
		</ul>		
		
		{checkActionsTpl location="tpl_header_just_after_profile"}
		
		</li>

				{if $isadmin eq 1}
					<li><a href="{$URL_admin}">{#PLIGG_Visual_Header_AdminPanel#}</a>
						<ul>
							<li class="first"><a href="{$my_pligg_base}/admin_users.php">{#PLIGG_Visual_Header_AdminPanel_1#}</a></li>
							{if $isgod eq 1}
								<li><a href="{$my_pligg_base}/admin_categories.php">{#PLIGG_Visual_Header_AdminPanel_2#}</a></li>
								<li><a href="{$my_pligg_base}/admin_backup.php">{#PLIGG_Visual_Header_AdminPanel_4#}</a></li>
								<li><a href="{$my_pligg_base}/modules/modules_manage.php">{#PLIGG_Visual_Header_AdminPanel_6#}</a></li>
								{checkActionsTpl location="tpl_header_admin_links"}
								<li><a href="{$my_pligg_base}/admin_config.php">{#PLIGG_Visual_Header_AdminPanel_5#}{#PLIGG_Visual_Name#}</a></li>
								<li class="last"><a href="{$my_pligg_base}/rss/rss_main.php" target="_blank">{#PLIGG_Visual_Header_AdminPanel_RSSImport#}</a></li>
							{/if}
						</ul>				
					</li>
				{/if}

				<li class="last"><a href="{$URL_logout}">{#PLIGG_Visual_Logout#}</a></li>
			{else}
				<li><a href="{$URL_login}">{#PLIGG_Visual_Login#}</a></li>
				<li class="last"><a href="{$URL_register}">{#PLIGG_Visual_Register#}</a></li>
			{/if}
		</ul>
	</div>