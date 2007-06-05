<? 
include_once "apps/admin_session.php";
include_once 'includes/header.php'; 


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
