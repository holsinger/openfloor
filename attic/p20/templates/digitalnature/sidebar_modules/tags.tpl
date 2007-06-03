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
<li>
  <div class="box" id="tagbox">
        <h1><span class="expand"><a id="exptags" class="expand-up"></a></span><a class="htitle">{#PLIGG_Visual_Top_5_Tags#}</a></h1>
        <div class="box2" id="tags">
      <div class="wrap">
            <div class="content">
          <div style="padding:10px 6px;line-height: {$tags_max_pts}pt;"> {section name=customer loop=$tag_number}
                
                {* --- to change the way the words are displayed, change this part --- *} <span style="font-size: {$tag_size[customer]}pt"> <a href="{$tag_url[customer]}">{$tag_name[customer]}</a> </span> {* ---		--- *}
                
                {/section} </div>
        </div>
          </div>
    </div>
   </div>
</li>
