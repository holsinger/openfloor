<? 
include_once "apps/admin_session.php";
//include_once './apps/global/global.php';
include_once 'includes/header.php'; 


?>
  		
  				<div id="content_div">
            <h3>Welcome</h3>
            <p style="margin-left:10px;margin-right:10px;">
            <span class='red'>Politic2.0</span> Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Morbi consequat pulvinar erat. Curabitur scelerisque, massa nec aliquam cursus, lacus metus accumsan risus, quis viverra tellus ligula non neque. Aliquam vel felis. Fusce mattis, quam eu rutrum malesuada, tortor tortor nonummy augue, nec malesuada velit neque id eros. Ut tortor. Ut at tortor a augue semper volutpat. Aenean nonummy egestas lacus. Donec sagittis, risus vel rutrum sollicitudin, velit ligula sollicitudin turpis, a fermentum libero est a ante. Pellentesque feugiat. Quisque ut est.</p>
            <p style="margin-left:10px;margin-right:10px;">
            Donec quis libero. Duis mattis pulvinar nisl. Mauris et sem. Sed aliquet. Donec sit amet tellus. Praesent et lacus ac justo pellentesque viverra. Vivamus neque ante, fermentum eu, tempus sed, tincidunt a, pede. Quisque eu dolor. Donec elementum dapibus arcu. Phasellus porttitor consequat nisi. Etiam non tellus sed ligula dapibus mollis. Etiam eget dolor at massa commodo adipiscing. Morbi pretium pellentesque magna. Sed at elit. Ut gravida rhoncus augue. Integer imperdiet, ipsum nec imperdiet varius, odio leo porta ante, nec imperdiet pede nisl et dolor. Phasellus euismod placerat enim. Integer placerat faucibus urna. </p>
            
            <br><br>
            <div id="zip_form">
              <h2>Start by entering your zip code below.</h3>
              <form action="whosyourgovt.php" method='get'>
        				<div>
        					<input type="text" name='zip' class="txt" />
        					<input type="image" src="images/btn-go.gif" alt="search" />
        					<input type="checkbox" name="defaultzip" value="true" /> Make this my default zip code.
        				</div>
        			</form>            
            </div><!-- end zip -->
					</div>
  				
  			
<? include_once 'includes/footer.php'; ?>
