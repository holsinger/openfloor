<? $data['red_head'] = 'Admin'; ?>
<? $data['admin'] = TRUE; ?>
<? $this->load->view('view_includes/header.php',$data); ?>
<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="javascript/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	// Notice: The simple theme does not use all options some of them are limited to the advanced theme
	tinyMCE.init({
		mode : "textareas",		
		theme : "advanced",
		plugins : "inlinepopups,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,zoom,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras",
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,|,visualchars,nonbreaking",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : true,
	});
</script>
<!-- /tinyMCE -->
<div id="admin_content">
    <h3>Manage Content</h3>
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
    <?
		$format = array(
              'name'        => 'cms_text',
              'id'          => 'cms_text',
              'value'       => (isset($cms_text))?$cms_text:$this->validation->cms_text,
              'rows'        => '15',
              'cols'        => '90',
              'class'       => 'txt'
            );
		echo form_format("Content: ",form_textarea($format),'' ); 
		?>
		<br />
		<?= form_hidden('cms_id',$cms_id); ?>
		<?= form_submit('','Submit','class="button"'); ?>
		<?= form_close(); ?>
</div>
<? $this->load->view('view_includes/footer.php',$data); ?>  	