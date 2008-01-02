<? 
$data['sub_title'] = $contact_page_name;
$this->load->view('view_layout/header.php',$data); ?>
<div id="content_div">
    <h3>Thank You!</h3>
	<p><?=$thank_you_desc?></p>
</div>
<? $this->load->view('view_layout/footer.php',$data); ?>