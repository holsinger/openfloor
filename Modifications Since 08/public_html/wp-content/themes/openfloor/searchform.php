<div id="search">
<form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<p>
		<input type="text" name="s" id="s" value="search here..." onfocus="if (this.value == 'search here...') {this.value = '';}" 
		onblur="if (this.value == '') {this.value = 'search here...';}" class="input"  />
		<input type="submit" name="Submit"  value="Go" class="button" />
	</p>
</form>
</div><!--Search End -->