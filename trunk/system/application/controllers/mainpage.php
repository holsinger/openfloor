<?

class Mainpage extends Controller {

	function __construct()
	{
		parent::Controller();
		$this->load->library('tag_lib');
		$this->load->library('wordcloud');
		$this->load->model('tag_model', 'tag');
		$this->load->model('Mainpage_model','mainpage');
		$this->load->library('validation');
		$this->load->library('Mainpagelib');
		$this->load->helper('url');//for redirect
		$this->load->helper('form');

		//$this->load->scaffolding('mainpage');
	}
	
	
	function index()
	{		
		$this->view();
	}
	
	function view() {
		$data['center'] = $this->mainpagelib->getCol(1,'html');
		$data['right'] = $this->mainpagelib->getCol(2,'html'); 
		$this->load->view('view_mainpage',$data);
	}
	
	function admin() {
		$this->userauth->check(SL_ADMIN);
		
		$data['center'] = $this->mainpagelib->getCol(1,'form');
		$data['right'] = $this->mainpagelib->getCol(2,'form'); 
		$this->load->view('view_mainpage',$data);
	}
	
	function edit($rc,$ajax=false) {
		//delete old pod
		$this->delete($rc,true);
		//get row & col
		$col = substr($rc,0,1);
		$row = substr($rc,1);
		//serialize data
		$serialized = $_POST;
		unset($serialized['delete']);
		$serialized = serialize($serialized);
		$this->mainpage->insert($col,$row,$serialized);
		if ($ajax) return $this->mainpagelib->getHTML($serialized);
		else {
			redirect('mainpage/admin');
			ob_clean();
			exit();
		}
	}
	
	function add ($rc,$ajax=false) {
		$col = substr($rc,0,1);
		$row = substr($rc,1);
		$data['name']='';
		$data['feed']='';
		$data['title']='';
		$data['desc']='';
		$data['desc_limit']='';
		$data['items']='';
		$serialized = serialize($data);
		$this->mainpage->insert($col,$row,$serialized);
		if ($ajax) return $this->mainpagelib->getForm($serialized,$rc);
		else {
			redirect('mainpage/admin');
			ob_clean();
			exit();
		}
	}
	
	function delete ($rc,$ajax=false) {
		//delete old pod
		$col = substr($rc,0,1);
		$row = substr($rc,1);
		$this->mainpage->delete($col,$row);
		if ($ajax) return TRUE;
		else {
			redirect('mainpage/admin');
			ob_clean();
			exit();
		}
	}
	
}
?>