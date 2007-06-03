{php}
	include_once(mnminclude.'tags.php');
	global $main_smarty;
	
	$cloud=new TagCloud();
	$cloud->smarty_variable = $main_smarty; // pass smarty to the function so we can set some variables
	$cloud->word_limit = 5;
	$cloud->min_points = 6; // the size of the smallest tag
	$cloud->max_points = 15; // the size of the largest tag
	
	$cloud->show();
	$main_smarty = $cloud->smarty_variable; // get the updated smarty back from the function
{/php}


<H3>{#PLIGG_Visual_Top_5_Tags#}</H3>
<div style="line-height: {$tags_max_pts}pt;">
	{section name=customer loop=$tag_number}
	
		{* --- to change the way the words are displayed, change this part --- *}
			<span style="font-size: {$tag_size[customer]}pt">
				<a href="{$tag_url[customer]}" style="text-decoration:none">{$tag_name[customer]}</a>&nbsp;
			</span>
		{* ---		--- *}
		
	{/section}
</div>