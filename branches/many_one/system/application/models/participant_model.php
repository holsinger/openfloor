<?
class participant_model extends Model {

    function __construct()
    {
        // Call the Model constructor
        parent::Model();
    }
	/**
	 * Add a new record to the participant table.  Pass the data which is an associative array with field_name => field_value pairs
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function InsertParticipant($data){
		$this->db->insert('event_participants', $data); 
		return $this->db->insert_id();
	}

	/**
	 * Update a participant record.  Pass the id to be updated and the data which is an associative array with field_name => field_value pairs
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function UpdateParticipant($id, $data){
		$this->db->where('id', (int) $id);
		$this->db->update('event_participants', $data);
		echo($this->db->last_query());
		return $this->db->affected_rows();
	}

	/**
	 * Deletes a participant that is specified by an id in the argument list
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function DeleteParticipant($id){
		$this->db->delete('event_participants', array('id' => $id));
	}
	
	
	/**
	 * Returns the number of current active users, this means any user that has pinged withing the last two minutes.
	 *
	 * @return void
	 * @author Clark Endrizzi
	 **/
	public function GetActiveParticipantsForEvent($event_id)
	{
		$sql = "SELECT COUNT(*) AS count 
		FROM event_participants
		WHERE fk_event_id = $event_id AND timestamp > SUBTIME(NOW(), '00:02:00')";
		
		return $this->db->query($sql)->row()->count;
	}
	
	public function GetParticipantInEvent($user_id, $event_id)
	{
		$where_array = array(
			"fk_user_id" => $user_id,
			"fk_event_id"=> $event_id
			);
		return $this->db->select('*')->from('event_participants')->where($where_array)->get()->result_array();
	}
}
?>