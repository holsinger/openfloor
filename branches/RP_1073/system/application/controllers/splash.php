<?

class Mainpage extends Controller {

	function __construct()
	{
		parent::Controller();

	}
	
	
	function index()
	{		
		$this->view();
	}
	
	function view() { 
		$this->load->view('view_splash',$data);
	}
	
}
?>