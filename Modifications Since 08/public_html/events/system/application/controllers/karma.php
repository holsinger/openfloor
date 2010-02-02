<?php
class Karma extends Controller {

	var $error = '';
	
	function __construct()
	{
		parent::Controller();
		
		$this->load->library('KarmaCalc');	
		$this->load->model('User_model','user');
		$this->load->scaffolding('cn_users');
		
		#check that user is allowed
		//$this->userauth->check(USER);
	}
	
	
	function index()
	{
		//default show create account form
		$this->view_karma();
	
	}
	
	function view_karma()
	{
		//set latest time
		$history_time = time() - 3600*24*2;#48 hour

		//$data['output'] = $this->karmacalc->set_coeff();
		$data['output'] .= $this->karmacalc->set_time($history_time);
		//get user states array
		$user_array = @$this->user->get_stats($history_time, $this->userauth->user_id);
//		echo "<pre>";
//		print_r($user_array);
//		echo "</pre>";
		//var_dump($user_array);
		$data['output'] .= "<br/>User's karma scores\n<br />";
		$user_karma= @$this->karmacalc->user_karma($user_array);

		//$data['output'] .=  "{$user_karma}\n<br />";
		$data['output'] .= "{$user_karma}\n<br />";
		$this->user->set_karma($this->userauth->user_id,$user_karma);
		
		//$this->load->view('view_karma',$data);
	}
}

?>