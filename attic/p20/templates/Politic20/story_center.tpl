{config_load file="/libs/lang.conf"}
														<div id="center">
															<div class="ce-l">
																<div class="ce-r">
																	<div class="ce-lt">
																		<div class="ce-br">
																			<div class="text">
																				<!-- list topics start here -->
    {php}
        Global $db, $main_smarty, $link;
        $link->print_summary();
    {/php}
	
    <div id="comments">
        <h2>{#PLIGG_Visual_Story_Comments#}</h2>

        {php}
			Global $db, $main_smarty, $current_user, $CommentOrder;
			get_comments();
			// the get_comments function is in the /story.php file
        {/php}

        {if $user_authenticated neq ""}
            {include file=$the_template."/comment_form.tpl"}
        {else}
            <br/>
            <div id="commentform" align="center" style="clear:both;margin-left:auto;font-weight:bold;margin-right:auto;border-color:#ccc; border-style:solid; border-width:1px;width:400px;text-align:center; padding-bottom: 8px;">
                <a href="{$login_url}">{#PLIGG_Visual_Story_LoginToComment#}</a> {#PLIGG_Visual_Story_Register#} <a href="{$register_url}">{#PLIGG_Visual_Story_RegisterHere#}</a>.
            </div>
        {/if}

    </div>
    {include file=$the_template."/story_who_voted.tpl"}
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="pagers">
															<div class="pbg">
																<div class="list">
																</div>
															</div>
														</div>