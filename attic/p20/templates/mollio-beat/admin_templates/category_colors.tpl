<br>
<fieldset><legend>Category Colors CSS auto-generated for Pligg</legend>
<br>
<strong>Simply copy and paste this into /templates/{$the_template}/css/catcolors.css and replace what is already there</strong>
<br><br>

Code:
<div style="background:#eee; padding: 15px 15px 5px 15px; border:1px solid #ccc;">
{section name=treeitem loop=$tree_array}
			
		/* category: {$tree_array[treeitem].name} */ <br>
		.cat{$tree_array[treeitem].auto_id}  {ldelim}
		border-left:5px solid #{$tree_array[treeitem].color};
		{rdelim}	<br>
		
		#catcol{$tree_array[treeitem].auto_id}   {ldelim}border-top:5px solid #{$tree_array[treeitem].color};{rdelim} <br>
	  #cat{$tree_array[treeitem].auto_id}  {ldelim}background:#{$tree_array[treeitem].color};{rdelim} <br>
	  <br />

{/section}
</div>

<hr>

<a href="{$my_pligg_base}/admin_categories.php">Back to Category Manager</a>