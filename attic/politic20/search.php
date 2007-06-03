<?php

require("header.php");

require("includes/searchbox.php");


showSearchBox();


if ($_GET["search"] != "")
{
	$url='http://practice.wikireview.com/api.php?action=opensearch&search='.$_GET['search'];

	//parse results
	$resultsArray = json_decode(file_get_contents($url));

	$searchTerm = array_shift($resultsArray);

	$urlParams = implode("|",$resultsArray[0]);
	$urlParams = str_replace(' ','_',$urlParams);

	//get some desc
	$url="http://practice.wikireview.com/api.php?action=query&format=php&prop=revisions&rvprop=content&titles=".$urlParams;

	//$xml = new SimpleXMLElement(file_get_contents($url));
	$data = unserialize(file_get_contents($url));
	$displayArray = array_pop($data['query']);

	echo "<div class=\"searchTitle\">Results For $searchTerm:</div>";

	foreach ($displayArray as $page) {
		//$page['title']
		//$page['pageid']
		//$page['ns']
		//$page['revisions']
		echo "<a class=\"searchResTitle\" href='topic.php?topic=".$page['title']."'><strong>".$page['title']."</strong></a><br/>";
		//get brief desc first revision record
		$desc = array_shift($page['revisions']);
		//break up parts of the array	
		$contentArray = explode('|',$desc['*']);
		echo "<div class=\"searchDesc\">" . substr(str_replace("DESC=", "", $contentArray[1]),0,250) . "...</div><br>";
	}
}
						
require("footer.php");

?>