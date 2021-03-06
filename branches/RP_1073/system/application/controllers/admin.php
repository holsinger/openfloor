<?php

class Admin extends Controller {
	
	private $event_id;
	
	function __construct()
	{
		parent::Controller();
		$this->load->library('tag_lib');
		$this->load->library('wordcloud');
		$this->load->model('tag_model', 'tag');
		$this->load->model('Cms_model','cms');
		
		$this->load->model('event_model', 'event');
		$this->load->model('user_model', 'user');
		$this->load->model('flag_model', 'flag');
		$this->load->model('question_model', 'question');
		
		$this->load->library('validation');
		$this->load->helper('url');//for redirect
		$this->load->helper('form');

		$this->load->scaffolding('cms');
		$this->userauth->check(SL_ADMIN);

	}
	
	function index()
	{
		$this->cms();
	}
	
	function cms ()
	{
		$data['cms_id'] = 0;
		if ( is_string($this->uri->segment(3)) ) {
			$data['cms_id'] = $this->cms->get_id_from_url($this->uri->segment(3));
			//$data['cms_name'] = $this->uri->segment(3);
		}
		$rules['cms_name'] = "trim|xss_clean";
		$rules['custom_1'] = "trim|xss_clean";
		$rules['custom_2'] = "trim|xss_clean";
		$rules['cms_text'] = "trim";		
		$this->validation->set_rules($rules);
		
		if ($this->validation->run() == FALSE) {
			$data['error'] = $this->validation->error_string;
		} else {
			if ($_POST['cms_id']) {				
				$this->cms->update_cms($_POST);
				redirect('admin/view/');
				ob_clean();
				exit();
			} else {
				$this->cms->insert_cms_form();
				redirect('admin/view/');
				ob_clean();
				exit();
			}
		}
				
		// Need to set variables if they aren't set so errors are not thrown
		$fields['cms_name']	= ( isset($_POST['cms_name']) ) ? $_POST['cms_name']:"";
		$fields['cms_text']	= ( isset($_POST['cms_text']) ) ? $_POST['cms_text']:"";
		$fields['custom_1']	= ( isset($_POST['custom_1']) ) ? $_POST['custom_1']:"";
		$fields['custom_2']	= ( isset($_POST['custom_2']) ) ? $_POST['custom_2']:"";
				
		//get update info
		if ($data['cms_id']>0) $data = $this->cms->get_cms($data['cms_id']);	

		$this->validation->set_fields($fields);
		$this->load->view('view_cms_form',$data);		
	}
	
	function view () {
		$data['results'] = $this->cms->get_all_cms();
		$this->load->view('view_cms',$data);			
	}
	
	public function dashboard($event = 'presidential_debate', $ajax = null)
	{
		#TODO Make it so that the flags & questions actually pull by event
		
		// ========
		// = init =
		// ========
		if(!$this->userauth->isAdmin()) redirect();
		$data['event'] = $event;
		
		$data['event_id'] = $this->event_id = $this->event->get_id_from_url($event);
		if(!$data['event_id']) exit();
		
		// ==========
		// = output =
		// ==========
		if(isset($ajax)) // AJAX
		{
			switch($ajax)
			{
			case 'current_question':
				$this->_current_question($data);
				$this->load->view('admin/current_question.php', $data);
				break;
			case 'upcoming_question':
				$this->_upcoming_question($data);
				$this->load->view('admin/upcoming_question.php', $data);
				break;
			case 'last_10_users':
				$this->_last_10_users($data);
				$this->load->view('admin/last_10_users.php', $data);
				break;
			case 'last_10_flags':
				$this->_last_10_flags($data);
				$this->load->view('admin/last_10_flags.php', $data);
				break;
			case 'last_10_questions':
				$this->_last_10_questions($data);
				$this->load->view('admin/last_10_questions', $data);
				break;
			default:
				break;
			}
		} else { // NO AJAX
			$this->_current_question($data);
			$this->_upcoming_question($data);
			$this->_last_10_users($data);
			$this->_last_10_flags($data);
			$this->_last_10_questions($data);
			$this->load->view('admin/dashboard', $data);
		}
	}
	
	private function _current_question(&$data)
	{
		$data['current_question'] = $this->question->current_question($this->event_id);
	}

	private function _upcoming_question(&$data)
	{
		$data['upcoming_question'] = $this->question->upcoming_question($this->event_id);
	}
	
	private function _last_10_users(&$data)
	{
		$data['last_10_users'] = $this->user->last_10();
	}
	
	private function _last_10_flags(&$data)
	{
		$data['last_10_flags'] = $this->flag->last_10();
	}
	
	private function _last_10_questions(&$data)
	{
		$data['last_10_questions'] = $this->question->last_10();
	}
}
?>