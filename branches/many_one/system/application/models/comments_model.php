<?php

class Comments_model extends Model
{
	var $order_by = 'date';
	
	public function __construct()
    {
        parent::Model();
    }

	public function getCommentsByQuestion($id)
	{
		#TODO allow for order by date of parent
		#TODO where parent_id is null
		$query = $this->db->query(
			"SELECT 
				comment_id, 
				IFNULL((SELECT 
					cast(format(sum(vote_value)/10,0) as signed) AS number 
				FROM 
					cn_votes 
				WHERE 
					fk_comment_id=comment_id
				AND vote_id IN (SELECT max(vote_id) FROM cn_votes WHERE fk_comment_id = comment_id GROUP BY fk_user_id)	 					
				GROUP BY fk_comment_id), 0) as votes, 
				comment, 
				fk_user_id,
				fk_question_id, 
				cn_comments.timestamp as date,
				user_name,
				user_avatar,
				fk_can_id
			FROM 
				cn_comments,
				cn_users 
			WHERE 
				fk_user_id=user_id
			AND
				fk_question_id = $id
			AND 
				parent_id = 0
			ORDER BY 
				$this->order_by
			ASC");
		
		if($query->num_rows() == 0)
			return false;
			
		return $query->result_array();	
	}
	
	public function getCommentsByVideo($id)
	{
		//$query = $this->db->getwhere('cn_comments', array('fk_question_id' => $id));
		// $query = $this->db->query('select comment_id, user_name, comment, fk_user_id, fk_question_id from cn_comments 
		// 		left join cn_users on user_id = fk_user_id;');
		#TODO allow for order by date of parent
		#TODO where parent_id is null
		$query = $this->db->query(
			"SELECT 
				comment_id, 
				IFNULL((SELECT 
					cast(format(sum(vote_value)/10,0) as signed) AS number 
				FROM 
					cn_votes 
				WHERE 
					fk_comment_id=comment_id 
				GROUP BY fk_comment_id), 0) as votes, 
				comment, 
				fk_user_id,
				fk_video_id, 
				cn_comments.timestamp as date,
				user_name,
				user_avatar
			FROM 
				cn_comments,
				cn_users 
			WHERE 
				fk_user_id=user_id
			AND
				fk_video_id = $id
			AND
				parent_id =0
			ORDER BY 
				votes
			DESC");
		
		if($query->num_rows() == 0)
			return false;
			
		return $query->result_array();	
	}
	
	#TODO get child comments
	public function getChildrenByComment($id)
	{
		$query = $this->db->query(
			"SELECT 
				comment_id, 
				IFNULL((SELECT 
					cast(format(sum(vote_value)/10,0) as signed) AS number 
				FROM 
					cn_votes 
				WHERE 
					fk_comment_id=comment_id
				AND vote_id IN (SELECT max(vote_id) FROM cn_votes WHERE fk_comment_id = comment_id GROUP BY fk_user_id)	 					
				GROUP BY fk_comment_id), 0) as votes,
				comment, 
				fk_user_id,
				fk_video_id, 
				cn_comments.timestamp as date,
				user_name,
				user_avatar
			FROM 
				cn_comments,
				cn_users 
			WHERE 
				fk_user_id=user_id
			AND
				parent_id = $id
			ORDER BY 
				votes
			DESC");
		
		if($query->num_rows() == 0)
			return false;
			
		return $query->result_array();
	}
	
	public function insertComment()
	{
		if(isset($_POST['comment']) && isset($_POST['fk_user_id']) && (isset($_POST['fk_question_id']) || isset($_POST['fk_video_id']) || isset($_POST['parent_id']))) {
			$trimmed = trim($_POST['comment']);
			if(!empty($trimmed)) {
				$this->db->insert('cn_comments', $_POST);
				return true;
			}
		}
		return true;
	}
}

?>