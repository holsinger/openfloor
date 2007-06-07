<? 
include_once "apps/admin_session.php";
//include_once './apps/global/global.php';
include_once 'includes/header.php'; 

/* record the zip being searched */
recordZip($_GET['zip']);

if (isset($_GET['defaultzip']))
	makeDefaultZip($_GET['zip']);
?>
  		
  		<div id="content_div">
            <h3>Who's Your Government</h3>	
			<?
			$data = new api_data ();
			$data->zip = $_GET['zip'];
			$data->getData();
			?>

		</div>
  				
  			
<? include_once 'includes/footer.php'; ?>
