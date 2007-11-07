<? 
$data['sub_title'] = $cms_name;
$this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
            <div style="margin-left:10px;margin-right:30px;">
            <?=$cms_text;?>
            </div>
			<br /><br />
            <? if ($this->userauth->isSuperAdmin()) echo "<div>".anchor('admin/cms/'.$cms_url, 'edit')."</div>"; ?>
</div>
<? $this->load->view('view_includes/footer.php'); ?>  				