<? $data['red_head'] = 'Users'; ?>
<? $this->load->view('view_layout/header.php',$data); ?>

<div id="content_div">

	<? if (!$this->userauth->isAdmin()) { ?>
  	<? } ?>
  
  <h3>View Users</h3>	
  


	<p><? if ($this->userauth->isAdmin()) echo anchor('/user/createAccount','Create a new user account');?></p>
	<p class='errorArea'><?=(isset($error)?$error:'')?></p>
	<? //echo $this->table->generate($events)?>
	<? foreach ($users as $key => $array) {?>
		<div id='user<?=$array['user_id'];?>' class='user-summary'>
		<br /><?=anchor('user/profile/'.url_title($array['user_name']),'<strong>'.$array['user_name'].'</strong>');?>
		
		<span style"float:right;"><img src="<?=$array['avatar_image_path'];?>"></span>
		<!--  <br /><b>Email:</b> <?=$array['user_email'];?>  -->
		<?// if ($this->userauth->isAdmin()) echo "<br />".$array['edit'];?>
		</div>
	<? }?>



</div>

<? $this->load->view('view_layout/footer.php'); ?>