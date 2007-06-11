<? 
include_once "apps/admin_session.php";
//include_once './apps/global/global.php';
include_once 'includes/header.php'; 

/* record the zip being searched */
$libZip->recordZip($_GET['zip']);

if (isset($_GET['defaultzip']))
	$libZip->makeDefaultZip($_GET['zip']);
?>
  		
  		<div id="content_div">
            <h3>Who's Your Government</h3>	
			<?
			$data = new api_data ();
			$data->zip = $_GET['zip'];
			$data->getData();
			?>

		</div>
		
		<div id="zip_form">
			<h2>Want to search a different zip code?</h3>
			<form action="whosyourgovt.php" method='get'>
				<div>
					<input type="text" name='zip' class="txt" />
					<input type="image" src="images/btn-go.gif" alt="search" />
					<input type="checkbox" name="defaultzip" value="true" /> Make this my default zip code.
				</div>
			</form>            
		</div>  				
  			
<? include_once 'includes/footer.php'; ?>
