<? $data['red_head'] = 'Admin'; ?>
<? $data['admin'] = TRUE; ?>
<? $this->load->view('view_includes/header.php',$data); ?>
<div id="admin_content">
    <h3>View Content Pages</h3>
		<?
		//var_dump ($results);
		foreach ($results as $key => $val)
		{
			echo anchor('admin/cms/'.$val['cms_url'],'edit');
			echo "&nbsp;&nbsp;".$val['cms_name']."&nbsp;&nbsp;"; 
			echo anchor('welcome/view/'.$val['cms_url'], 'view');
			echo '<br />';
		}
		?>
</div>
<? $this->load->view('view_includes/footer.php',$data); ?>  	