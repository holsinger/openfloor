<?php

if ($_GET["topic"] == "") {
	header("Location: search.php");
}

$custom_head = "<link rel=\"stylesheet\" type=\"text/css\" href=\"ajaxtabs/ajaxtabs.css\" />\n";
$custom_head .= "<script type=\"text/javascript\" src=\"ajaxtabs/ajaxtabs.js\">\n";
$custom_head .= "/***********************************************\n";
$custom_head .= "* Ajax Tabs Content script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)\n";
$custom_head .= "* This notice MUST stay intact for legal use\n";
$custom_head .= "* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code\n";
$custom_head .= "***********************************************/\n";
$custom_head .= "</script>";

require("header.php");

require("includes/searchbox.php");

echo "<center>";
showSearchBox();
echo "</center><br><br>";

if ($_GET["topic"] != "")
{
	//get some desc
	$url="http://practice.wikireview.com/api.php?action=query&format=php&prop=revisions&rvprop=content&titles=".str_replace(" ",'_',$_GET["topic"]);

	$data = unserialize(file_get_contents($url));
	$displayArray = array_pop($data['query']);
?>
	<a href='topic.php?topic=<?= $_GET["topic"]; ?>'><strong><?= $_GET["topic"]; ?></strong></a><br/>
	<div id='area'>
	<ul id="maintab" class="shadetabs">
	<li class="selected"><a href="#default" rel="ajaxcontentarea">Overview</a></li>
	<li class="nonSelected"><a href="topic_wr.php?topic=<?= str_replace(" ",'_',$_GET['topic']); ?>" rel="ajaxcontentarea">WikiReview</a></li>
	<li class="nonSelected"><a href="topic_tj.php?topic=<?= $_GET['topic']; ?>" rel="ajaxcontentarea">TagJungle</a></li>
	</ul>
	<div id="ajaxcontentarea" class="contentstyle">
	
	<?php require("topic_ovr.php"); ?>

	</div>
	</div>

	<script type="text/javascript">
	//Start Ajax tabs script for UL with id="maintab" Separate multiple ids each with a comma.
	startajaxtabs("maintab");
	</script>

<?php
}
						
require("footer.php");

?>