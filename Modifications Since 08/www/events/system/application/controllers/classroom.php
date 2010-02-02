<?php
/**
 * This controller has to do with classroom.
 *
 * @author Jianbo Li
 * @version none
 * @copyright 6 January, 2010
 * @package default
 * 
 **/

/*
	TODO Could probably be combined with the forums controller.  The forums controller may be the better name too since events is too specific.
*/


class Classroom extends Controller
{
	public function __construct()
	{
		parent::Controller();
		$this->load->helper('url');
		
		$this->load->model('Classroom_model','classroom');
		
		$this->load->library('validation');
		
	}
	
	/**
	 * Default function.  This will call this just passes to view_events(below)
	 *
	 * @return void
	 * @author (????)
	 **/
	public function index()
	{
		// $this->create_event();
	}
	
	public function add()
	{
		if(!empty($_POST))
		{
			$rules['class_name'] 	= "trim|required|max_length[100]|xss_clean";
			$rules['description'] 	= "trim|max_length[65535]";
			$this->validation->set_rules($rules);
			
			if ($this->validation->run()){
				$arg_data = array('name' => $this->input->post('class_name'),
									'description' => $this->input->post('description'),
									'fk_creator_id' => $this->userauth->user_id);
				$this->classroom->insert($arg_data);
			}
			redirect('');
		}
		else 
		{
			$this->load->view('classroom/add_classroom');
		}
	}
	
	public function delete($classroom_id)
	{
		$this->classroom->delete($classroom_id);
		$this->classroom->delete_idx_cls_stu($classroom_id);
		redirect('');
	}
	
	public function view($classroom_id)
	{
		$data['classroom'] = $this->classroom->get($classroom_id);
		$data['students'] = $this->classroom->get_students($classroom_id);
		
		$this->load->view('classroom/view_classroom', $data);
	}
	
	public function delete_stu($classroom_id, $student_id)
	{
		$this->classroom->delete_student($classroom_id, $student_id);
		$this->view($classroom_id);
	}
	
	public function enroll_stu($classroom_id, $user_id = '')
	{
		if($_POST)
		{
			$users = $this->input->post('user_id');
			foreach ($users as $k => $user)
			{
				$this->classroom->insert_cls_stu(array('fk_classroom_id' => $classroom_id, 'fk_student_id' => $user));
			}
		}
		if (!empty($user_id))
		{
			$this->classroom->insert_cls_stu(array('fk_classroom_id' => $classroom_id, 'fk_student_id' => $user_id));
		}
		$data['users'] = $this->classroom->get_other_students($classroom_id);
		$data['classroom'] = $this->classroom->get($classroom_id);
		
		$this->load->view('classroom/enroll_students', $data);
	}
	
	public function list_class()
	{
		$user_id = $this->userauth->user_id;
		$classes = $this->classroom->list_all();
	}
}
?>