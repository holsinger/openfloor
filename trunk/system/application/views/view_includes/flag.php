<?
switch ($this->flag_lib->type) {
	case 'question':
		$fk_id = $question_id;
		break;
	case 'user':
		$fk_id = $question_id;
		break;
	default:
		show_error('flag.php::type: invalid type');
		break;
} 
$html = $this->flag_lib->createFlagHTML($fk_id, $event_name);
?>

<? if($this->flag_lib->type == 'user'): ?>
	<? if($this->userauth->isUser()): ?>
		<img class="img-flag-<?=$this->flag_lib->type?>" style="cursor:pointer;" src="./images/RP_Questions_flag.png" <? if(!empty($html)) echo "onclick=\"javascript:queueUpdater.toggleVisibility('flag_{$this->flag_lib->type}$fk_id');queueUpdater.toggleQueue();\"" ?>/>
	<? else: ?>
		<img class="img-flag-<?=$this->flag_lib->type?>" style="cursor:pointer;" src="./images/RP_Questions_flag.png" onclick="showBox('login');" />
	<? endif; ?>
<? endif; ?>
<?=$html?>

<?//new Effect.toggle('flag_{$this->flag_lib->type}$fk_id','blind', {queue: 'end'});?>