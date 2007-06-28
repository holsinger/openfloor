<? $data['red_head'] = 'Results'; ?>
<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
  <h3>Who's Your Government</h3>	
	<?= $html; ?>
</div>

<div id="zip_form">
	<h2>Want to search a different zip code?</h3>
	<form action="whosyourgovt.php" method='get'>
		<div>
			<input type="text" name='zip' class="txt" />
			<input type="image" src="images/btn-go.gif" alt="search" />
			<br /><br />
			<input type="checkbox" name="defaultzip" value="true" /> Make this my default zip code.
		</div>
	</form>            
</div> 
<? $this->load->view('view_includes/footer.php'); ?>  				