<? $data['red_head'] = 'Welcome'; ?>
<? $this->load->view('view_includes/header.php',$data); ?>

<div id="content_div">
            <h3><?=$cms_name;?></h3>
            <div style="margin-left:10px;margin-right:30px;">
            <?=$cms_text;?>
            </div>
			<br /><br />
			<!--
				TODO Make this look nice.  It's fugly.
			-->
			Custom 1:<br />
            <div style="margin-left:10px;margin-right:30px;">
            <?=$custom_1;?>
            </div>
			Custom 2:<br />
            <div style="margin-left:10px;margin-right:30px;">
            <?=$custom_2;?>
            </div>
            <? if ($this->userauth->isSuperAdmin()) echo "<div>".anchor('admin/cms/'.$cms_url, 'edit')."</div>"; ?>
</div>
<? $this->load->view('view_includes/footer.php'); ?>  				