<?php

class Your_government extends Controller {

	function __construct()
	{
		parent::Controller();
		$this->load->library('ApiData');
		$this->load->helper('url');
	}
	
	
	function index()
	{
		if ( isset($_POST) ) {
			redirect('your_government/zip/'.$_POST['zip']);
			ob_clean();
			exit();
		} else {
			//do the default
			$this->zip();
		}
	}
	
	function zip () {
		//set zip
		$this->apidata->zip = $this->uri->segment(3);
		$this->setData ();
	}
	
	function state () {
		//set the state
		$this->apidata->state = $this->uri->segment(3);
		$this->setData ();
	}
	
	function city () {
		//set the state
		$this->apidata->city = $this->uri->segment(3);
		$this->setData ();
	}
	
	function county () {
		//set the state
		$this->apidata->county = $this->uri->segment(3);
		$this->setData ();
	}
	
	function setData () {
		//$this->output->cache(60);
		//get the data send to view
		$data['html'] = $this->apidata->getData();		
		$this->load->view('view_your_government',$data);
	}

	function politician ($id) {
		//$this->output->cache(60);
		//get the data send to view
		$data['html'] = $this->apidata->whatUp($id);		
		$this->load->view('view_your_government',$data);
	}	
	
	
}
?>