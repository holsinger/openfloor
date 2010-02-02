<?php

class Flag extends Controller {
	
	function __construct()
	{
		parent::Controller();
		$this->load->model('flag_model', 'flag');
		$this->load->model('Question_model','question');
		$this->load->model('user_model','user');
		$this->load->model('event_model','event');
		$this->load->model('vote_model','vote');
		$this->load->model('reaction_model','reaction');
		$this->load->model('tag_model','tag');
		$this->load->model('comments_model','comment');
		$this->load->model('alerts_model','alert');
	}
	
	public function flagQuestion($question_id, $reporter_id)
	{
		$this->flag->type = 'question';
		$flag = $this->uri->segment(5);
		$question = $this->question->get_question($question_id);
		$event_id = $question['fk_event_id'];
		$this->event->id = $event_id;
		$event_creator_id = $this->event->get('creator_id');
		$other_questions = $this->question->getQuestions($event_id);
		$data['question'] = $question;
		$data['other_questions'] = $other_questions;
		$parameters = array();
		$result_question_id = NULL;
		$other_questions_id = array();
		$merge_radio = '';
		if(!empty($flag)){
			if($this->flag->flagged($question_id))
				return;
			$type_id = $_POST['flag_radio_' . $question_id];
			if (!$this->userauth->isAdmin()){
				if ($type_id == 1) $type_id = 5;
				if ($type_id == 2) $type_id = 6; 
			}
			if($type_id == 3){
				$parameters = array('flag_reason' => 'other', 'flag_reason_other' => 'private');
			}
			elseif ($type_id == 4){
				$parameters = array('flag_reason' => 'other', 'flag_reason_other' => 'promoted');
			}
			elseif ($type_id == 1){
				$parameters = array('question_status' => 'deleted','flag_reason' => 'inappropriate', 'flag_reason_other' => '');
			}
			elseif ($type_id == 2){
				$parameters = array('question_status' => 'deleted','flag_reason' => 'other', 'flag_reason_other' => 'duplicate');
				$result_question_id = $_POST['result_question_' . $question_id];
				$merge_radio = $_POST['merge_radio_' . $question_id];
				if ($merge_radio == 2){
					$other_questions_id = $_POST['other_questions_' . $question_id . '_'];
				}
			}elseif ($type_id == 5){
				$parameters = array('flag_reason' => 'inappropriate', 'flag_reason_other' => 'student_flag');
				$this->question->updateQuestion($question_id,$parameters);
				$this->alert->insertAlert(array('fk_user_id' => $event_creator_id, 
												'fk_question_id' => $question_id, 
												'alert_type' => 'flag_inappropriate_student'));
				if ($this->flag->checkStudentFlag($question_id,$type_id)){
					$type_id -= 4;
					$parameters = array('question_status' => 'deleted','flag_reason' => 'inappropriate', 'flag_reason_other' => '');
				}
			}elseif ($type_id == 6){
				$parameters = array('flag_reason' => 'other', 'flag_reason_other' => 'duplicate_student');
				$this->question->updateQuestion($question_id,$parameters);
				$this->alert->insertAlert(array('fk_user_id' => $event_creator_id, 
												'fk_question_id' => $question_id, 
												'alert_type' => 'flag_duplicate_student'));
				$result_question_id = $_POST['result_question_' . $question_id];
				$merge_radio = $_POST['merge_radio_' . $question_id];
				if ($merge_radio == 2){
					$other_questions_id = $_POST['other_questions_' . $question_id . '_'];
				}
				foreach ($other_questions_id as $k => $id){
					if($id != $result_question_id && !$this->flag->alreadyFlagged($id, $reporter_id) && !$this->flag->flagged($question_id)){
						$this->question->updateQuestion($id,$parameters);
						$this->alert->insertAlert(array('fk_user_id' => $event_creator_id, 
														'fk_question_id' => $id, 
														'alert_type' => 'flag_duplicate_student'));
						$this->flag->flag($id, $type_id, $reporter_id, $result_question_id);
					}
				}
				if ($this->flag->checkStudentFlag($question_id,$type_id)){
					$type_id -= 4;
					$parameters = array('question_status' => 'deleted','flag_reason' => 'other', 'flag_reason_other' => 'duplicate');
				}
			}
			if(!$this->flag->alreadyFlagged($question_id, $reporter_id)){
				$this->flag->flag($question_id, $type_id, $reporter_id, $result_question_id);
				if ($type_id < 5)
					$this->question->updateQuestion($question_id,$parameters);
				if ($type_id == 1 && $this->flag->checkStrikeAgainst($question['fk_user_id'])){
					$this->user->freezeUser($question['fk_user_id']);
				}
				if ($type_id == 3){
					$this->alert->insertAlert(array('fk_user_id' => $event_creator_id, 
													'fk_question_id' => $question_id, 
													'alert_type' => 'flag_private'));
				}
				elseif ($type_id == 2){
					$this->alert->insertAlert(array('fk_user_id' => $question['fk_user_id'], 
													'fk_question_id' => $question_id, 
													'alert_type' => 'flag_duplicate'));
					$this->vote->updateVoteForMerge($question_id, $result_question_id);
					$this->reaction->updateReactionForMerge($question_id, $result_question_id);
					$this->tag->updateTagsForMerge($question_id, $result_question_id);
					$this->comment->updateCommentsForMerge($question_id, $result_question_id);
					if ($merge_radio == 2){
						$this->vote->updateVoteForMerge($question_id, $result_question_id);
						$this->reaction->updateReactionForMerge($question_id, $result_question_id);
						$this->tag->updateTagsForMerge($question_id, $result_question_id);
						$this->comment->updateCommentsForMerge($question_id, $result_question_id);
						foreach ($other_questions_id as $k => $id){
							if($id != $result_question_id){
								$question = $this->question->get_question($id);
								$this->question->updateQuestion($id,$parameters);
								$this->alert->insertAlert(array('fk_user_id' => $question['fk_user_id'], 
																'fk_question_id' => $id, 
																'alert_type' => 'flag_duplicate'));
								$this->flag->flag($id, $type_id, $reporter_id);
								$this->vote->updateVoteForMerge($id, $result_question_id);
								$this->reaction->updateReactionForMerge($id, $result_question_id);
								$this->tag->updateTagsForMerge($id, $result_question_id);
								$this->comment->updateCommentsForMerge($id, $result_question_id);
							}
						}
					}
				}
//				redirect('forums/cp/' . url_title($event['event_name']));
			}
		}
		$this->load->view('question/flag_question',$data);
	}
	
	public function attentionOption($question_id, $flag_id, $type_id, $option, $object_question_id)
	{
		$this->flag->type = 'question';
		if ($type_id == 5) $alert_type = 'flag_inappropriate_student';
		elseif ($type_id == 6) $alert_type = 'flag_duplicate_student';
		$alert = $this->alert->getAlert($question_id, $alert_type);
		$this->alert->id = $alert[0]['alert_id'];
		$this->alert->updateAlert(array('respond_time' => date("Y-m-d H:i:s", time()), 'status' => '1'));
		if ($option == 'agree'){
			$this->flag->flag($question_id, $type_id - 4, $this->userauth->user_id);
			if ($type_id == 5){
				$parameters = array('question_status' => 'deleted','flag_reason' => 'inappropriate', 'flag_reason_other' => '');
			}elseif ($type_id == 6){
				$parameters = array('question_status' => 'deleted','flag_reason' => 'other', 'flag_reason_other' => 'duplicate');
				$this->vote->updateVoteForMerge($question_id, $object_question_id);
				$this->reaction->updateReactionForMerge($question_id, $object_question_id);
				$this->tag->updateTagsForMerge($question_id, $object_question_id);
				$this->comment->updateCommentsForMerge($question_id, $object_question_id);
				$this->flag->deleteStudentFlag($flag_id);
			}
			$this->question->updateQuestion($question_id,$parameters);
		}
		else {
			$this->flag->flag($question_id, 0, $this->userauth->user_id);
			$this->flag->deleteStudentFlag($flag_id);
		}
		redirect('user/profile/' . $this->userauth->user_name);
	}
	
	public function flagUser($user_id, $type_id, $reporter_id)
	{
		$this->flag->type = 'user';
		if(!$this->flag->alreadyFlagged($user_id, $reporter_id))
			$this->flag->flag($user_id, $type_id, $reporter_id);
	}
}
?>