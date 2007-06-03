	<?php
	$page = array_shift($displayArray);
	//$page['title']
	//$page['pageid']
	//$page['ns']
	//$page['revisions']
	echo "<a href='topic.php?topic=".$page['title']."'><strong>".$page['title']."</strong></a><br/>";
	//get brief desc first revision record
	$desc = array_shift($page['revisions']);
	//break up parts of the array	
	$contentArray = explode('|',$desc['*']);
	?>
	
	<table cellpadding="0" cellspacing="4">
	<tr><td valign="top">

	<table cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="2" align="right"><img src="images/procon_header.png"></td>
	</tr>
	<tr>
		<td><img src="images/pro_header.png"></td>
		<td><img src="images/con_header.png"></td>
	</tr>
	<tr>
		<td>
			<div id="pro" class="proBox" valign="top" onClick="expandtab('maintab', 1);">
				<?php echo str_replace("PRO=", "", $contentArray[2]); ?>
			</div>
		</td>
		<td>
			<div id="con" class="conBox" valign="top" onClick="expandtab('maintab', 1);">
				<?php echo str_replace("CON=", "", $contentArray[3]); ?>
			</div>
		</td>
	</tr>
	</table>

	</td><td valign="top">

	<?php
	$url = "http://www.tagjungle.com/feed/".str_replace(" ", "*", $_GET["topic"])."/20";
	require_once("rss/rss_fetch.inc");
	$rss = fetch_rss($url);
	?>

	<table cellpadding="0" cellspacing="0">
	<tr>
		<td align="right"><img src="images/tagjungle_header.png"></td>
	</tr>
	<tr>
		<td>
			<div valign="top" class="tjBox"  onClick="expandtab('maintab', 2);">
				<?php
				foreach ($rss->items as $item)
				{
					echo "<h4><a target=\"_new\" href=\"".$item["link"]."\">".$item["title"]."</a></h4>";
					echo $item["summary"];
				//echo "<pre>";
				//print_r($rss);
				//echo "</pre>";
				}
				?>
			</div>
		</td>
	</tr>
	</table>

	</td></tr>
	</table>