<? $data['red_head'] = 'Welcome'; ?>
<? $this->load->view('view_includes/header.php',$data); ?>
<? $this->load->view('view_includes/view_question_pod.php', $question_record); ?>

<div class="news-summary">
<? foreach ($votes as $vote): $vote_value = ($vote['vote_value'] > 0) ? 'voted in favor' : 'voted against' ;?>
<?= $vote['user_name'] . ' ' . $vote_value . ' on ' . $vote['timestamp'] ?>
<? endforeach ?>
</div>

<? $this->load->view('view_includes/footer.php'); ?>