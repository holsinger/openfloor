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
		$this->userauth->check(SL_ADMIN);
	}
	
	
	function index()
	{
		//default show create account form
		$this->view_karma();
	
	}
	
	function view_karma()
	{
			//set latest time
			$history_time = time() - 3600*24*7*52*2;#one week

			$data['output'] = $this->karmacalc->set_coeff();
			$data['output'] .= $this->karmacalc->set_time($history_time);
			//get user states array
			$user_array = @$this->user->get_stats($history_time);
			//var_dump($user_array);

			$data['output'] .= "<br/>User's karma scores\n<br />";
			foreach ($user_array as $user) {
				$user_karma= @$this->karmacalc->user_karma($user);
				$data['output'] .=  "{$user['user_id']} => {$user_karma}\n<br />";
				//set user karma
				$this->user->set_karma($user['user_id'],$user_karma);
			}
			
			$this->load->view('view_karma',$data);
			
	}
	
}

?>