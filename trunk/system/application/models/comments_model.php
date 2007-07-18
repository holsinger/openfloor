<?php

class Comments_model extends Model
{
	public function __construct()
    {
        parent::Model();
    }

	public function getCommentsByQuestion($id)
	{
		//$query = $this->db->getwhere('cn_comments', array('fk_question_id' => $id));
		// $query = $this->db->query('select comment_id, user_name, comment, fk_user_id, fk_question_id from cn_comments 
		// 		left join cn_users on user_id = fk_user_id;');
		$query = $this->db->query(
			"SELECT 
				comment_id, 
				(SELECT 
					format(sum(vote_value)/10,0) AS number 
				FROM 
					cn_votes 
				WHERE 
					fk_comment_id=comment_id 
				GROUP BY fk_comment_id) as votes, 
				comment, 
				fk_user_id,
				fk_question_id, 
				user_name
			FROM 
				cn_comments,
				cn_users 
			WHERE 
				fk_user_id=user_id
			AND
				fk_question_id = $id
			ORDER BY 
				votes
			DESC");
		
		if($query->num_rows() == 0)
			return false;
			
		return $query->result_array();	
	}
	
	public function insertComment()
	{
		if(isset($_POST['comment']) && isset($_POST['fk_user_id']) && isset($_POST['fk_question_id'])) {
			$this->db->insert('cn_comments', $_POST);
			return true;
		}
		return false;
	}
}

?>