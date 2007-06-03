<script language="javascript" type="text/javascript">
	function show_hide_picker(divID, catcolor){ldelim}
		if(catcolor != ''){ldelim}var catcolor = document.getElementById('catcolor_' + divID).value.replace('#', '');;{rdelim}
		if(document.getElementById('color_' + divID).style.display == 'none'){ldelim}
			document.getElementById('color_' + divID).innerHTML = 'The textbox will update when you click the image again. <br><applet code="colorpicker.class" width="400" height="450" MAYSCRIPT><param name="js_variable" value="color"><param name="start_value" value="' + catcolor + '"></applet>';
			document.getElementById('color_' + divID).style.display = '';
		{rdelim}else{ldelim}
			document.getElementById('color_' + divID).innerHTML = '';
			document.getElementById('color_' + divID).style.display = 'none';
			document.getElementById('catcolor_' + divID).value = color.replace('#', '');;
		
			document.getElementById('catcolor_' + divID).value = "wait...";
			new Ajax.Request('admin_categories.php', {ldelim}method:'post', postBody:'action=changecolor&id=' + divID + '&color=' + color.replace('#', ''), onSuccess:document.getElementById('catcolor_' + divID).value = color.replace('#', ''){rdelim});
			document.getElementById('catname_' + divID).style.color = '#' + color.replace('#', '');
			
		{rdelim}		
	{rdelim}
</script>

{literal}
	<style type="text/css">
		.eip_editable { background-color: #ff9; padding: 3px; }
		.eip_savebutton { background-color: #36f; color: #fff; }
		.eip_cancelbutton { background-color: #000; color: #fff; }
		.eip_saving { background-color: #903; color: #fff; padding: 3px; }
		.eip_empty { color: #afafaf; }
			
	</style>
{/literal}

<div id = "catmanager" >
<br />
<fieldset><legend>Category Manager</legend>
<br />
<table style="border:none; width:auto;">
	{section name=thecat loop=$cat_array}

		{* show the grey box above the category *}
		{if $cat_array[thecat].auto_id neq 0}
			<tr style="border:none">	
				{$cat_array[thecat].spacercount|repeat_count:'<td></td>'}
				<td style="border:1px solid #ccc; background:#eee">
					<div id = "above_{$cat_array[thecat].auto_id}">
						&nbsp;
					</div>
				</td>
			</tr>
		{/if}
		{* show the grey box above the category *}

		<tr style="border:none;">	
			{$cat_array[thecat].spacercount|repeat_count:'<td></td>'}
			<td>
				<div id = "cat_drop_{$cat_array[thecat].auto_id}">
					{if $cat_array[thecat].auto_id neq 0}<div id = "cat_drag_{$cat_array[thecat].auto_id}">{/if}
					{*$cat_array[thecat].name*}
						
					<a href = "javascript://" onclick="
					var replydisplay=document.getElementById('{$cat_array[thecat].auto_id}').style.display ? '' : 'none';
					document.getElementById('{$cat_array[thecat].auto_id}').style.display = replydisplay;
					">
					name 
					</a>: <span id="catname_{$cat_array[thecat].auto_id}" style="color: #{$cat_array[thecat].color}"><b>{eipItem item=qeip_CatName unique=$cat_array[thecat].auto_id ShowJS=TRUE}</b></span>
						
					<div id="{$cat_array[thecat].auto_id}" style="display:none">
						Id: {$cat_array[thecat].auto_id}<br />
						{*
							Parent: {eipItem item=qeip_CatParent unique=$cat_array[thecat].auto_id ShowJS=TRUE} -- {$cat_array[thecat].parent_name}<br />
							Sort Order: {eipItem item=qeip_CatOrder unique=$cat_array[thecat].auto_id ShowJS=TRUE}<br />
							Items in this category: -coming soon- <br />
						*}
						<a href = "admin_categories.php?action=remove&id={$cat_array[thecat].auto_id}"  onclick="return confirm('Are you sure you want to delete? You cannot undo this.')">Delete This Category</a><br />
					</div>
					{if $cat_array[thecat].auto_id neq 0}</div>{/if}
				</div>
			</td>
		</tr>

		{* show the grey box below the category *}
		{if $cat_array[thecat].auto_id neq 0}
			<tr>	
				{$cat_array[thecat].spacercount|repeat_count:'<td></td>'}
				<td style="border:1px solid #ccc; background:#eee">
					<div id = "below_{$cat_array[thecat].auto_id}">
						&nbsp;
					</div>
				</td>
			</tr>
		{/if}
		{* show the grey box below the category *}

		{* setup the drag/drop *}
		<script language="javascript" type="text/javascript">
			{if $cat_array[thecat].auto_id neq 0}
				var drag_{$cat_array[thecat].auto_id} = new Draggable('cat_drag_{$cat_array[thecat].auto_id}',{ldelim}revert:true{rdelim});
			{/if}

			Droppables.add('cat_drop_{$cat_array[thecat].auto_id}', {ldelim}
	   		onDrop: function(element, droppableElement) 
		     		{ldelim} document.getElementById('catmanager').innerHTML = '<br />Please Wait...'; window.location='admin_categories.php?action=changeparent&id=' + element.id + '&parent=' + droppableElement.id; {rdelim}{rdelim});			

			{if $cat_array[thecat].auto_id neq 0}
				Droppables.add('above_{$cat_array[thecat].auto_id}', {ldelim}
		   		onDrop: function(element, droppableElement) 
			     		{ldelim} document.getElementById('catmanager').innerHTML = '<br />Please Wait...'; window.location='admin_categories.php?action=move_above&moveabove_id=' + droppableElement.id + '&id_to_move=' + element.id; {rdelim}{rdelim});			

				Droppables.add('below_{$cat_array[thecat].auto_id}', {ldelim}
		   		onDrop: function(element, droppableElement) 
			     		{ldelim} document.getElementById('catmanager').innerHTML = '<br />Please Wait...'; window.location='admin_categories.php?action=move_below&movebelow_id=' + droppableElement.id + '&id_to_move=' + element.id; {rdelim}{rdelim});			
			{/if}
		</script>
		{* setup the drag/drop *}
	{/section}
</table>


<br /><br />
<img src="{$my_pligg_base}/templates/{$the_template}/images/new_cat.png" align="absmiddle" /> <a href = "admin_categories.php?action=add">Add a new category</a>
<br />
<br />
<hr />
<br />
 <em>If you're using URLMethod 2, you'll want to use this line in your .htaccess file.<br /><br />
RewriteRule ^({section name=thecat loop=$cat_array}{$cat_array[thecat].safename}{if $cat_array[thecat].index neq $cat_count}|{/if}{/section})/([a-zA-Z0-9-]+)/?$ story.php?title=$2 [L]<br />
RewriteRule ^({section name=thecat loop=$cat_array}{$cat_array[thecat].safename}{if $cat_array[thecat].index neq $cat_count}|{/if}{/section})/?$ ?category=$1 [L]</em>
<br />
<br />
</fieldset>
</div>





{*
			       drag_{$cat_array[thecat].auto_id}.destroy();
*}