<? $data['red_head'] = 'Admin'; ?>
<? $data['left_nav'] = 'admin'; ?>
<? $data['admin'] = TRUE; ?>

<? $this->load->view('view_includes/header.php',$data); ?>
<? include("./fckeditor/fckeditor.php"); ?>
<div id="admin_content">
    <h3>Manage Content</h3>
    <?echo anchor('forums/create/candidate','Add Candidate');?><br/>
    <?echo anchor('admin/view','view all');?>
    <br />
	<?= form_open('admin/'); ?>
    <?
		$format = array(
              'name'        => 'cms_name',
              'id'          => 'cms_name',
              'value'       => (isset($cms_name))?$cms_name:$this->validation->cms_name,
              'size'        => '50',
              'class'       => 'txt',
            );
		echo form_format("Name: ",form_input($format),'The name of the page of content, will be used in the URL' ); 
		?>
		<br />
		<br />
		<br />
	    <?
	     $oFCKeditor = new FCKeditor('cms_text') ;
	     $sBasePath = 'fckeditor/';
	     $oFCKeditor->BasePath = $sBasePath ;
	     $oFCKeditor->Height = '400';
		 $oFCKeditor->Value		= (isset($cms_text))?$cms_text:$this->validation->cms_text;
		 $oFCKeditor->Create() ;
		
		$format1 = array(
              'name'        => 'custom_1',
              'id'          => 'custom_1',
              'value'       => (isset($custom_1))?$custom_1:$this->validation->custom_1,
              'size'        => '50',
              'class'       => 'txt',
        );
		echo form_format("Custom 1: ",form_input($format1),'Additional field to store information if needed' );
		
		$format2 = array(
              'name'        => 'custom_2',
              'id'          => 'custom_2',
              'value'       => (isset($custom_2))?$custom_2:$this->validation->custom_2,
              'size'        => '50',
              'class'       => 'txt',
        );
		echo form_format("Custom 2: ",form_input($format2),'Additional field to store information if needed' ); 
		?>
		
		<br /><br />
		<?= form_hidden('cms_id',$cms_id); ?>
		<?= form_submit('','Submit','class="button"'); ?>
		<?= form_close(); ?>
</div>
<? $this->load->view('view_includes/footer.php',$data); ?>  	