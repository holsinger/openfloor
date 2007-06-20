<?php

class Welcome extends Controller {

	function __construct()
	{
		parent::Controller();
		$this->load->helper('form');

	}
	
	
	function index()
	{
		$this->load->view('welcome_message');
	}
}
?>