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
		$this->site_admin();
	}
	
	/**
	 * Shows the edit page for a cms entry
	 *
	 * @return void
	 * @author Clark Endrizzi, etc
	 **/
	function cms ($cms_url)
	{
		$data['cms_id'] = 0;
		$data['cms_id'] = $this->cms->get_id_from_url($cms_url);

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
				redirect('admin/');
				ob_clean();
				exit();
			} else {
				$this->cms->insert_cms_form();
				redirect('admin/');
				ob_clean();
				exit();
			}
		}
				
		// Need to set variables if they aren't set so errors are not thrown
		$fields['cms_name']	= ( isset($_POST['cms_name']) ) ? $_POST['cms_name']:"";
		$fields['cms_text']	= ( isset($_POST['cms_text']) ) ? $_POST['cms_text']:"";
		$fields['custom_1']	= ( isset($_POST['custom_1']) ) ? $_POST['custom_1']:"";
		$fields['custom_2']	= ( isset($_POST['custom_2']) ) ? $_POST['custom_2']:"";
		$fields['site_section']	= ( isset($_POST['site_section']) ) ? $_POST['site_section']:"";
				
		//get update info
		if ($data['cms_id']>0) $data = $this->cms->get_cms($data['cms_id']);	

		$this->validation->set_fields($fields);
		$this->load->view('cms/view_cms_form',$data);		
	}
	
	/**
	 * Views a cms entry, this is sometimes used a a generic page that can simply use cms content for the page.
	 *
	 * @return void
	 * @author ????
	 **/
	function view () {
		$data['results'] = $this->cms->get_all_cms();
		$this->load->view('cms/view_cms',$data);			
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
	
	/**
	 * Displays the site administration section.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function site_admin($tab)
	{
		$data['tab'] = $tab;
		$this->load->view('admin/site_admin_home',$data);
	}
	
	/**
	 * Displays the site tab ajax stuff
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function site_admin_ajax($tab)
	{
		// Check for permissions
		
		// return info
		if($tab == 1){
			$data['results'] = $this->cms->get_all_cms();
		}elseif($tab == 2){
			$this->db->orderby("user_name", "asc");
			$users = $this->db->get('cn_users')->result_array();
			foreach($users as $k=>$v) 
			{
				if ($this->userauth->isAdmin()) $users[$k]['edit'] = anchor("user/edit_user/{$v['user_id']}", 'Edit');

				if (is_string($users[$k]['user_avatar']) && is_array(unserialize($users[$k]['user_avatar'])) )
				{
					$image_array = unserialize($users[$k]['user_avatar']);

					$users[$k]['avatar_image_name'] = $image_array['file_name'];
					$users[$k]['avatar_image_height'] = 20;
					$users[$k]['avatar_image_width'] = 20;
					$users[$k]['avatar_image_path'] = "./avatars/shrink.php?img=".$image_array['file_name']."&w=20&h=20";
				} 
				else
				{
					$users[$k]['avatar_image_name'] = "image01.jpg";
					$users[$k]['avatar_image_height'] = 20;
					$users[$k]['avatar_image_width'] = 20;
					$users[$k]['avatar_image_path'] = "./avatars/shrink.php?img=image01.jpg&w=20&h=20";   //"./images/image01.jpg";
				}
			}
			$data['users'] = $users;
		}elseif($tab == 3){
		}
		$this->load->view('admin/site_admin_tab_'.$tab ,$data);
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