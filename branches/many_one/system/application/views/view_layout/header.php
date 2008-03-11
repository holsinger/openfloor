<? 
//set vars the will detemine the head tag 
$data['browser'] = $this->agent->browser();
$data['browserVer'] = $this->agent->version();

//setup onLoad array
if (isset($data['js_onload']) && is_array($data['js_onload'])) {
	$onload = implode('();',$data['js_onload']).'();';
}else{
	$onload = 'init();';
} 
$this->load->view('view_layout/view_head_setup.php',$data);

$this->load->view('themes/'.$this->config->item('custom_theme')."/header.php");
?>