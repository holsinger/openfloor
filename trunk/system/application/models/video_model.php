<?php

class Video_model extends Model 
{
	//vars

	var $date_begin;
	var $date_end;
	var $user_id;
	var $video_status = 'active'; //active, deleted
	var $event_id;
	var $video_id;
	var $tag_id;
	var $order_by = 'votes'; //date,votes,
	var $offset;
	var $limit;
	
 	function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
    
	public function insertVideo($videoName='', $videoDesc='', $userID='', $eventID='', $youtubeID = '', $thumb = '',$videoURLName='')
	{
		$query = "INSERT INTO cn_videos (video_title, video_url_title, video_desc, fk_user_id, fk_event_id, video_youtude_id, video_thumb) ";
		$query .="VALUES ('$videoName', '$videoURLName', \"$videoDesc\", $userID, $eventID, '$youtubeID', '$thumb')";		
		$this->db->query($query);
		
		return $this->db->insert_id();
	}
	
	public function updateVideo ($video_id, $array) 
	{
		$this->db->where ('video_id',$video_id);
		if (isset($array['video_name'])) $this->db->set ('video_name',$array['video_name']);
		if (isset($array['video_url_name'])) $this->db->set ('video_url_name',$array['video_url_name']);
		if (isset($array['video_desc'])) $this->db->set ('video_desc',$array['video_desc']);
		if (isset($array['video_status'])) $this->db->set ('video_status',$array['video_status']);
		if (isset($array['video_answer'])) $this->db->set ('video_answer',$array['video_answer']);
		if (isset($array['video_youtude_id'])) $this->db->set ('video_youtude_id',$array['video_youtude_id']);
		$this->db->update('cn_videos');
		log_message('debug', "updateVideo:".trim($this->db->last_query()));
		return $this->db->affected_rows();
	}
	
	public function videoQueue ()
	{	
		$where = '';
		$tag_append = '';
		
		$where .= (isset($this->date_begin)) ? " AND event_date >= $this->date_begin" : '' ;
		$where .= (isset($this->date_end)) ? " AND event_date <= $this->date_end" : '' ;
		$where .= (isset($this->user_id)) ? " AND user_id = $this->user_id" : '' ;
		$where .= (isset($this->video_status)) ? " AND video_status = '$this->video_status'" : '' ;
		$where .= (isset($this->event_id)) ? " AND event_id = $this->event_id" : '' ;
		$where .= (isset($this->video_id)) ? " AND video_id = $this->video_id" : '' ;
		
		if(isset($this->tag_id)) {
			$tag_append = ', cn_idx_tags_questions';
			$where .= " AND	fk_tag_id=$this->tag_id	AND cn_idx_tags_questionss.fk_video_id = video_id";
		}
		
		$limit = '';
		if (isset($this->limit) && isset ($this->offset)) {
			$limit .= "LIMIT $this->offset, $this->limit";
		} elseif (isset($this->limit)) {
			$limit .= "LIMIT $this->limit";
		}
		
		$query = $this->db->query(
			"SELECT 
				video_id, 
				(SELECT 
					format(sum(vote_value)/10,0) AS number 
				FROM 
					cn_votes 
				WHERE 
					fk_video_id=video_id 
				GROUP BY fk_video_id) as votes, 
				video_title, 
				video_desc,
				video_thumb,
				video_youtude_id,
				cn_videos.timestamp as date, 
				user_name, 
				event_name 
			FROM 
				cn_videos, 
				cn_events, 
				cn_users
				$tag_append 
			WHERE 
				cn_videos.fk_user_id=user_id 
				$where
			AND 
				fk_event_id=event_id 
			ORDER BY 
				$this->order_by 
			DESC 
				$limit");
		log_message('debug', "videoQueue:".trim($this->db->last_query()));
		return $query->result_array();
	}
	
	/**
	 * return the id from the video url name
	 * 
	 * @param string $url event url name
	 * @author James Kleinschnitz
	 */
	public function get_video ($id, $url='',$youtubeID='')
	{
		 $result_array = array(); 
		 if ($id) $this->db->where('video_id',$id);
		 if ($url) $this->db->where('video_url_title',$url);
		 if ($youtubeID) $this->db->where('video_youtube_id',$youtubeID);
		 $query = $this->db->get('cn_videos');
		 log_message('debug', "VIDEOS:getVideos:".trim($this->db->last_query()));
		 $result_array = $query->result_array();
		 return $result_array[0];
	}
	
	/**
	 * return the id from the video url name
	 * 
	 * @param string $url event url name
	 * @author James Kleinschnitz
	 */
	public function get_id_from_url ($url)
	{
		 $result_array = $this->get_video(0,$url);
		 return $result_array['video_id'];
	}

	public function numVideos($event_id)
	{
		$result = $this->db->query("SELECT count(*) as count FROM cn_videos WHERE fk_event_id=$event_id")->result_array();
		return $result[0]['count'];
	}
}
?>