{literal}
	<style type="text/css">
		.eip_editable { background-color: #ff9; padding: 3px; }
		.eip_savebutton { background-color: #36f; color: #fff; }
		.eip_cancelbutton { background-color: #000; color: #fff; }
		.eip_saving { background-color: #903; color: #fff; padding: 3px; }
		.eip_empty { color: #afafaf; }	
	</style>
{/literal}

	<script type="text/javascript">
		Event.observe(window, 'load', init, false);
		function init() {ldelim}{foreach from=$editinplace_init item=html}{$html}{/foreach}{rdelim}
	</script>

<fieldset><legend>Modify Language</legend>
<br /><br />
filter for text: <input type="text" id="filterfor">
<input type="button" name="filter" value="filter" onclick="filtertotext();">
<input type="button" name="clearfilter" value="clear filter" onclick="showall();">
<br /><br /><br /><br />
<hr />

{foreach from=$outputHtml item=html}
	{$html}
{/foreach}

{literal}
	<script type="text/javascript">
function filtertotext(){
		var rows = document.getElementsByTagName("tr"); 
		var filterfor = document.getElementById('filterfor').value;
		
		for (var i = 0; i < rows.length; i++) { 
			var x = rows[i].id;
			
			if(x.substr(0, 4) == 'row_'){
				var y = x.substr(4, 1000);
				if(y.indexOf(filterfor)==-1){
					rows[i].style.display='none';
				} else {
					rows[i].style.display='';
				}
			}
		}
}

function showall(){
		var rows = document.getElementsByTagName("tr"); 
		for (var i = 0; i < rows.length; i++) { 
			rows[i].style.display='';
		}

}
	</script>
{/literal}
