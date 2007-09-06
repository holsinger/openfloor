<? $data['red_head'] = 'Welcome'; ?>
<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
            <h3><?=$cms_name;?></h3>
            <div style="margin-left:10px;margin-right:30px;">
            <?=$cms_text;?>
            </div>
            <? if ($this->userauth->isAdmin()) echo "<div>".anchor('admin/cms/'.$cms_url, 'edit')."</div>"; ?>
</div>
<? $this->load->view('view_includes/footer.php'); ?>  				