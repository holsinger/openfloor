<? 
$data['red_head'] = 'Admin'; 
$data['sub_title'] = "View Content Pages";
?>
<? $data['admin'] = TRUE; ?>
<? $this->load->view('view_includes/header.php',$data); ?>
<div id="admin_content">
		<? foreach ($results as $section_name => $section): ?>
			<? $final_section_name = $section_name ? ucwords(str_replace('_', ' ', $section_name)) : "(No Section Defined)"; ?>
			<strong><?=$final_section_name."<br />"?></strong>
			<div style="margin-left: 20px;">
				<? foreach($section as $cms_data): ?>
					<?=anchor('admin/cms/'.$cms_data['cms_url'],'edit')?>
					&nbsp;&nbsp;<?=$cms_data['cms_name']?>&nbsp;&nbsp;
					<?=anchor('information/view/'.$cms_data['cms_url'], 'view')?>
					<br />
				<? endforeach; ?>
			</div>
		<? endforeach; ?>
</div>
<? $this->load->view('view_includes/footer.php',$data); ?>