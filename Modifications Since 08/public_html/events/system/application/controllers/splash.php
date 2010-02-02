<?

class Splash extends Controller {

	function __construct()
	{
		parent::Controller();
		
		$this->load->model('Cms_model','cms');

	}
	
	
	function index()
	{		
		$this->failSafe();
	}
	
	function failSafe()
	{
		$this->view('home');
	}
	
	function view ($cms_string)
	{
		$data['cms_id'] = 0;
		if ( is_string($cms_string) ) {
			$data['cms_id'] = $this->cms->get_id_from_url($cms_string);
			if ($data['cms_id']>0) 
				$data = $this->cms->get_cms($data['cms_id']);	
		}
		
		$this->load->view('view_splash',$data);
	}
	
}
?>