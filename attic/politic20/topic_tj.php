<? /*
<iframe src ="http://www.tagjungle.com/feed/<?= str_replace(" ",'*',$_GET['topic']); ?>/20" width="100%" height="700px"></iframe>
*/
?>

<?php
	$url = "http://www.tagjungle.com/feed/".str_replace(" ", "*", $_GET["topic"])."/20";
	require_once("rss/rss_fetch.inc");
	$rss = fetch_rss($url);
	?>

	<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td align="right"><img src="images/tagjungle_header.png"></td>
	</tr>
	<tr>
		<td>
			<div valign="top" class="tjBox">
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