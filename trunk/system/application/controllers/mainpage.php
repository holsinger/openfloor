<?

class Mainpage extends Controller {

	function __construct()
	{
		parent::Controller();
		$this->load->model('Mainpage_model','mpDB');
		$this->load->library('validation');
		$this->load->library('Mainpage');
		$this->load->helper('url');//for redirect
		$this->load->helper('form');

		//$this->load->scaffolding('mainpage');
	}
	
	
	function index()
	{		
		$this->view();
	}
	
	function view() {
		$data['center'] = $this->mainpage->getCol(1,'html');
		$data['right'] = $this->mainpage->getCol(2,'html'); 
		$this->load->view('view_mainpage',$data);
	}
	
	function admin() {
		$data['center'] = $this->mainpage->getCol(1,'form');
		$data['right'] = $this->mainpage->getCol(2,'form'); 
		$this->load->view('view_mainpage',$data);
	}
	
	function edit($rc,$ajax=false) {
		//delete old pod
		$col = substr($rc,0,1);
		$row = substr($rc,1);
		$this->mpDB->detele($col,$row);
		//serialize data
		$serialized = $_POST;
		unset($serialized['delete']);
		$serialized = serialize($serialized);
		$this->mpDB->insert($col,$row,$serialized);
		if ($ajax) return $this->mainpage->getHTML($serialized);
		else $this->admin();
	}
	
}
?>