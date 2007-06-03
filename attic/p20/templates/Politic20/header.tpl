	<div id="page">
		<!-- header start here -->
		<div id="header">
			<h1><a href="{$my_base_url}{$my_pligg_base}">Politic20</a></h1>
			<form action="{$my_base_url}{$my_pligg_base}">
				<div>
					<input type="text" class="txt" />
					<input type="image" src="{$my_pligg_base}/templates/Politic20/images/btn-search.gif" alt="search" />
				</div>
			</form>
		</div>
		<!-- top navigation start here -->
		<ul class="top-nav">
			<li><span><a href="#">Home</a></span></li>
			<li><a href="#">Events</a></li>
			<li><a href="#">ConventionNext</a></li>
		</ul>
		<div class="slogan"><strong class="slogan">populace politic change</strong></div>
		<div id="pagewidth">
			<div class="frame">
				<div class="top">
					<!-- main navigation start here -->
					<ul class="nav">
					{if $user_authenticated eq true}
						{if $isadmin eq 1}<li><a href="{$URL_admin}">{#PLIGG_Visual_Header_AdminPanel#}</a></li>{/if}
						<li><a href="{$my_base_url}{$my_pligg_base}">ConventionNext Home</a></li>
						<li><a href="{$URL_userNoVar}">{#PLIGG_Visual_Profile#}</a></li>
						{if $user_authenticated neq true}<li><a href="{$my_pligg_base}/register.php">{#PLIGG_Visual_Register#}</a></li>{/if}
						{if $Enable_Live eq 'false'}<li><a href='#'>{#PLIGG_Visual_Live#}</a></li>{/if}
						<li><a href='{$URL_topusers}'>{#PLIGG_Visual_Top_Users#}</a></li>
						{if $Enable_Tags eq 'true'}<li><a href="{$URL_tagcloud}">{#PLIGG_Visual_Tags#}</a></li>{/if}
						{if $user_authenticated eq true}<li class="last"><a href="{$URL_logout}">{#PLIGG_Visual_Logout#}</a></li>{/if}
					{else}
						<li><a href="{$my_base_url}{$my_pligg_base}">ConventionNext Home</a></li>
						<li><a href='{$URL_login}'>{#PLIGG_Visual_Login_Title#}</a></li>
						{if $user_authenticated neq true}<li><a href="{$my_pligg_base}/register.php">{#PLIGG_Visual_Register#}</a></li>{/if}
						{if $Enable_Live eq 'false'}<li><a href='#'> {#PLIGG_Visual_Live#}</a></li>{/if}
						<li><a href='{$URL_topusers}'>{#PLIGG_Visual_Top_Users#}</a></li>
						<li class="last">{if $Enable_Tags eq 'true'}<a href="{$URL_tagcloud}">{#PLIGG_Visual_Tags#}</a>{/if}</li>
					{/if}
					</ul>
					<strong class="convention-next">Convention next</strong>
					<ul class="breadcrumb">
						<li><a href = "{$my_base_url}{$my_pligg_base}">{#PLIGG_Visual_Breadcrumb_SiteName#}{#PLIGG_Visual_Breadcrumb_Home#}</a></li>
						<li>{if $navbar_where.link1 neq ""}&gt; <a href="{$navbar_where.link1}">{$navbar_where.text1}</a>{elseif $navbar_where.text1 neq ""}&gt; {$navbar_where.text1}{/if}</li>
						<li>{if $navbar_where.link2 neq ""}&gt; <a href="{$navbar_where.link2}">{$navbar_where.text2}</a>{elseif $navbar_where.text2 neq ""}&gt; {$navbar_where.text2}{/if}</li>   	
						<li>{if $navbar_where.link3 neq ""}&gt; <a href="{$navbar_where.link3}">{$navbar_where.text3}</a>{elseif $navbar_where.text3 neq ""}&gt; {$navbar_where.text3}{/if}</li>      	
						<li>{if $navbar_where.link4 neq ""}&gt; <a href="{$navbar_where.link4}">{$navbar_where.text4}</a>{elseif $navbar_where.text4 neq ""}&gt; {$navbar_where.text4}{/if}</li>
					</ul>
				</div>
				<!-- search box start here -->
				<div class="search">			
					<form action="{$my_base_url}{$my_pligg_base}/search.php" method="get" id="thisform">
						<ul>
							<li><label>Search</label></li>
							{if $templatelite.get.search neq ""}
								{assign var=searchboxtext value=$templatelite.get.search|sanitize:2}
							{else}
								{assign var=searchboxtext value=""}			
							{/if}
							<li><input type="text" class="txt" name="search" id="searchsite"  value="{$searchboxtext}" /></li>
							<li><input type="image" src="{$my_pligg_base}/templates/Politic20/images/btn-go.gif" alt="go" /></li>
						</ul>
					</form>
				</div>
				<div id="content">
					<div class="c-frame">
						<div class="c-bl">
							<div class="c-br">
								<div class="ct-l">
									<div class="c-tr">
										<div class="bg2">
											<div class="bg3">
												<div class="bg">
													<div class="top-box">
														<strong class="questions">Questions</strong>
														<!-- local (sub) navigation start here -->
														<ul class="local-nav">
														{if $pagename eq "upcoming"}
																<li><a href="{$my_base_url}{$my_pligg_base}" class="published-questions">{#PLIGG_Visual_Published_News#}</a></li>
																<li class="active"><a href="{$URL_upcoming}" class="unpublished-questions">{#PLIGG_Visual_Pligg_Queued#}</a></li>
																<li><a href="{$URL_submit}" class="submit-questions">{#PLIGG_Visual_Submit_A_New_Story#}</a></li>
														{elseif $pagename eq "index"}
																<li class="active"><a href="{$my_base_url}{$my_pligg_base}" class="published-questions">{#PLIGG_Visual_Published_News#}</a></li>
																<li><a href="{$URL_upcoming}" class="unpublished-questions">{#PLIGG_Visual_Pligg_Queued#}</a></li>
																<li><a href="{$URL_submit}" class="submit-questions">{#PLIGG_Visual_Submit_A_New_Story#}</a></li>
														{elseif $pagename eq "submit"}
																<li><a href="{$my_base_url}{$my_pligg_base}" class="published-questions">{#PLIGG_Visual_Published_News#}</a></li>
																<li><a href="{$URL_upcoming}" class="unpublished-questions">{#PLIGG_Visual_Pligg_Queued#}</a></li>
																<li class="active"><a href="{$URL_submit}" class="submit-questions">{#PLIGG_Visual_Submit_A_New_Story#}</a></li>
														{else}
																<li><a href="{$my_base_url}{$my_pligg_base}" class="published-questions">{#PLIGG_Visual_Published_News#}</a></li>
																<li><a href="{$URL_upcoming}" class="unpublished-questions">{#PLIGG_Visual_Pligg_Queued#}</a></li>
																<li><a href="{$URL_submit}" class="submit-questions">{#PLIGG_Visual_Submit_A_New_Story#}</a></li>   
														{/if}
														</ul>
														<ul class="sort-questions">
														{if $pagename eq "upcoming"}
															<li><strong>{#PLIGG_Visual_Pligg_Sort_News_By#}:</strong></li>
															<li>{if $paorder eq "" || $paorder eq "newest"}{#PLIGG_Visual_Pligg_Newest_St#}{else}<a href="{$upcoming_url_newest}">{#PLIGG_Visual_Pligg_Newest_St#}</a>{/if}</li>
															<li>{if $paorder eq "oldest"}{#PLIGG_Visual_Pligg_Oldest_St#}{else}<a href="{$upcoming_url_oldest}">{#PLIGG_Visual_Pligg_Oldest_St#}</a>{/if}</li>
															<li>{if $paorder eq "mostpopular"}{#PLIGG_Visual_Pligg_Most_Pop#}{else}<a href="{$upcoming_url_mostpopular}">{#PLIGG_Visual_Pligg_Most_Pop#}</a>{/if}</li>
															<li>{if $paorder eq "leastpopular"}{#PLIGG_Visual_Pligg_Least_Pop#}{else}<a href="{$upcoming_url_leastpopular}">{#PLIGG_Visual_Pligg_Least_Pop#}</a>{/if}</li>
															<li class="rss"><a href="{$URL_rss2queued}">rss</a></li>
														{elseif $pagename neq "story"}
															{if $Voting_Method eq 1}
															<li><strong>{#PLIGG_Visual_Pligg_Sort_News_By#}:</strong></li>
															<li>{if $setmeka eq "" || $setmeka eq "recent"}{#PLIGG_Visual_Recently_Pop#}{else}<a href="{$index_url_recent}">{#PLIGG_Visual_Recently_Pop#}</a>{/if}</li>
															<li>{if $setmeka eq "today"}{#PLIGG_Visual_Top_Today#}{else}<a href="{$index_url_today}">{#PLIGG_Visual_Top_Today#}</a>{/if}</li>
															<li>{if $setmeka eq "yesterday"}{#PLIGG_Visual_Yesterday#}{else}<a href="{$index_url_yesterday}">{#PLIGG_Visual_Yesterday#}</a>{/if}</li>
															<li>{if $setmeka eq "week"}{#PLIGG_Visual_This_Week#}{else}<a href="{$index_url_week}">{#PLIGG_Visual_This_Week#}</a>{/if}</li>
															<li>{if $setmeka eq "month"}{#PLIGG_Visual_This_Month#}{else}<a href="{$index_url_month}">{#PLIGG_Visual_This_Month#}</a>{/if}</li>
															{/if}
															<li class="rss"><a href="{$URL_rss2}">rss</a></li>
														{/if}
														</ul>
														{if $pagename eq "upcoming"}
														<h2>{#PLIGG_Visual_Pligg_Queued#} </h2>
														{elseif $pagename eq "index"}
														<h2>{#PLIGG_Visual_Published_News#}</h2>
														{else}
														<h2>&nbsp;</h2>
														{/if}
													</div>