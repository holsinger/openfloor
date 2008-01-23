<?php

class Url extends Controller {

	private $debug = true;

	function __construct()
	{
		parent::Controller();
		$this->load->model('event_model','event');
		$this->load->model('User_model','user');
		$this->load->helper('url');//for redirect
	}

	function index()
	{
		$this->clean(func_get_args());
	}
	
	function tiny()
	{		
		$numargs = func_num_args();
		
		//turn debug on to see what is going on
		if ($this->debug) {
	     	echo "Number of arguments: $numargs<br />\n";
	     	for ($i=0;$i<$numargs;$i++) {
	     		echo "# {$i} argument is: " . func_get_arg($i) . "<br />\n";
	     	}
		}
			
		if ($numargs === 1) {
		  	$value = func_get_arg(0);
			switch (true) {
				case is_numeric($this->event->get_id_from_url($value)):
						redirect('forums/cp/'.$value);
						ob_clean();
						exit();
					break;
				case $this->user->is_username($value):
						redirect('user/profile/'.$value);
						ob_clean();
						exit();
					break;
				default:
						redirect('');
						ob_clean();
						exit();
					break;
			}
			
			
		} else {
			//we could build special cases here if we want
			#for now just going to go home
			redirect('');
			ob_clean();
			exit();			
		}
	}
	
	/**
	 * this function will get the data and template needed to build the array
	 *
	 * @param array $life_line array of the pages lifeline
	 * @author james kleinschnitz
	 */
	function _build_page ($life_line) 
	{
		//get page template
	}
}
?>
