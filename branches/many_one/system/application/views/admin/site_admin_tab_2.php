<? foreach ($users as $key => $array) {?>
	<br />
	<div id='user<?=$array['user_id'];?>' class='user-summary'>
		<span style"float:right; "><img src="<?=$array['avatar_image_path'];?>"></span>
		<?=anchor('user/profile/'.url_title($array['user_name']),'<strong>'.$array['user_name'].'</strong>');?>
	</div>
<? }?>