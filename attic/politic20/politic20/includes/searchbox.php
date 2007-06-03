<?php

function showSearchBox()
{
	?>

	<form method='get' action='search.php'>
	<p style="float:right;"><input class='inputp20' value="<?= $_GET["search"]?>" type="text" name="search" size="20">
	<input class='button' type="submit" value="Search Politic 2.0"></p>
	</form>

	<?php
}

?>