<?php

/* vim: set expandtab tabstop=4 shiftwidth=4: */

// +----------------------------------------------------------------------+
// | K-messaging:                                                         |
// | Used to simulate an internal mail for any syte                       |
// +----------------------------------------------------------------------+
// |                                                                      |
// | Copyright (C) 2005 Jo�o Pereira, joaopedro17@netvisao.pt Portugal    |
// |                                                                      |
// | This program is free software; you can redistribute it and/or        |
// | modify it under the terms of the GNU General Public License          |
// | as published by the Free Software Foundation; either version 2       |
// | of the License, or (at your option) any later version.               |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to the Free Software          |
// | Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA            |
// | 02111-1307, USA.                                                     |
// |                                                                      |
// | Author: Jo�o Pereira, joaopedro17@netvisao.pt Portugal               |
// |                                                                      |
// +----------------------------------------------------------------------+
//
// $Id: class.KMessaging.php,v 1.2 2005/10/07 11:30:15 bubu_herodes Exp $

// New Version 1.2 so structural bugs have been arranjed
// 1.2.1 -- Author: AshDigg from the Pligg Team
//		added $id = $idMsg to GetAllMesseges() and GetMessage() arrays
// 1.2.2 -- Author: AshDigg from the Pligg Team 
//		renamed $order to $sort
//		fixed bug with GetAllMesseges() switch on $sort -- missing break; so it always used the last item
//		added sort by date asc / desc
// 1.2.3 -- Author: AshDigg from the Pligg Team 
//		added $filter to GetAllMesseges()



//Mysql table, just import this.
/*
CREATE TABLE `msgtbl` (
  `idMsg` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `body` text NOT NULL,
  `sender` int(11) NOT NULL default '0',
  `receiver` int(11) NOT NULL default '0',
  `senderLevel` int(11) NOT NULL default '0',
  `readed` int(11) NOT NULL default '0',
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`idMsg`)
);
*/

/*
	Sample:
	$message = new KMessaging(true);
	$message->SendMessege('Promotion','Today we have a brand new promotion from the pack number5',10,30,3);//user 10 sends a message to user 30 and have a level of 3
	$array = $message->GetAllMesseges(0,30);
*/




class KMessaging
{
	/*
	* @var  Used to save the database name
	*/
//	var $DBName = 'dbname';
	var $DBName = 'EZSQL_DB_NAME';
	/*
	* @var  Used to save the Username of the MySql Server
	*/
//	var $DBUser = 'username';
	var $DBUser = 'EZSQL_DB_USER';
	/*
	* @var  Used to save the Password of the MySql Server
	*/
//	var $DBPass = 'password';
	var $DBPass = 'EZSQL_DB_PASSWORD';
	/*
	* @var  Used to save the Host of the MySql Server
	*/
//	var $DBHost = 'localhost';
	var $DBHost = 'EZSQL_DB_HOST';
	/*
	* @var  Used to save the table name
	*/
//	var $tblName = 'msgtbl';
	var $tblName = table_messages;
	/*
	 *	@desc Class constructor
	 *	@param String $tblName
	 *	@return KMessaging	returns the object
	 *	@return Int	1	If the database cannot be selected after conecting
	 *	@return Int 2	If connection to MySQL server fail
	 *	@return Int 3	If the database cannot be selected When connection to the Database done outside of the class
	 *	@return Int 4	If Conection var is not correct
	*/
	function KMessaging($connect = false,$selectDB = false,$con = '')
	{		
		if($connect)
		{
			$con = @mysql_connect($this->DBHost,$this->DBUser,$this->DBPass);
			if($con)
				if(!@mysql_select_db($this->DBName,$con))
					return 1;
			else 
				return 2;
		}elseif ($selectDB)
		{
			if( strlen($con) > 0 )
				if(!@mysql_select_db($this->DBName,$con))
					return 3;
			else 
				return 4;
		}
	}
	
	/**
	* @return Int 0		Messege sended succesfully
	* @return Int 1		No title
	* @return Int 2		No body
	* @return Int 3		Invalid Sender
	* @return Int 4		Invalid Receiver
	* @return Int 5		Invalid Sender Level
	* @return Int 6		Error inputing in Database
	*
	* @param String $title
	* @param String $body
	* @param Int $sender
	* @param Int $receiver
	*
	* @desc Send messege to $receiver
	*/
	function SendMessege($title ,$body ,$sender ,$receiver ,$senderLevel)
	{
		if( strlen($title) == 0 )
			return 1;
		if( strlen($body) == 0 )
			return 2;
		if( strlen($sender) == 0 )
			return 3;
		if( strlen($receiver) == 0 )
			return 4;
		if( strlen($senderLevel) == 0)
			return 5;
		$sql = "INSERT INTO ".$this->tblName." (title,body,sender,receiver,senderLevel,readed) VALUES ('$title','$body',$sender,$receiver,$senderLevel,0)";
		//echo $sql;
		$result = mysql_query($sql);
		if($result)
			return 0;
		else 	
			return 6;
	}
	/**
	* @return int 1		 When msgId equal to 0
	* @return int 2      When no Messege in database with that msgId
	* @return String 	 Returns the title of the messege
	* @param int $msgId
	* @desc This function is used to return the title of a especific messege
	*/
	function GetTitle($msgId)
	{
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("SELECT title FROM ".$this->tblName." WHERE idMsg=$msgId");
		if(mysql_num_rows($result) == 0)
			return 2;
		$row = mysql_fetch_object($result);
		return $row->title;
	}
	
	/**
	* @return int 1		When msgId equal to 0
	* @return int 2		When no Messege in database with that msgId
	* @return String 	Returns the body of the messege
	* @param int $msgId
	* @desc This function is used to return the body of a especific messege
	*/
	function GetBody($msgId)
	{
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("SELECT body FROM ".$this->tblName." WHERE idMsg=$msgId");
		if(mysql_num_rows($result) == 0)
			return 2;
		$row = mysql_fetch_object($result);
		return $row->body;
	}
	/**
	* @return int 1				When msgId equal to 0
	* @return int 2				When no Messege in database with that msgId
	* @return int Other int 	Return the userId that sent this messege
	* @param int $msgId
	* @desc This function is used to return the userId from the sender of a especific messege
	*/
	function GetSenderID($msgId)
	{
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("SELECT sender FROM ".$this->tblName." WHERE idMsg=$msgId");
		if(mysql_num_rows($result) == 0)
			return 2;
		$row = mysql_fetch_object($result);
		return $row->sender;
	}
	/**
	* @return int 1				When msgId equal to 0
	* @return int 2				When no Messege in database with that msgId
	* @return int Other int 	Return the userId that is the receiver this messege
	* @param int $msgId
	* @desc This function is used to return the userId from the receiver of a especific messege
	*/
	function GetReceiverID($msgId)
	{
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("SELECT receiver FROM ".$this->tblName." WHERE idMsg=$msgId");
		if(mysql_num_rows($result) == 0)
			return 2;
		$row = mysql_fetch_object($result);
		return $row->receiver;
	}
	/**
	* @return int 1				When msgId equal to 0
	* @return int 2				When no Messege in database with that msgId
	* @return int Other int 	Return the date when the message was sent
	* @param int $msgId
	* @desc This function is used to return the send date of a especific messege
	*/
	function GetSendDate( $msgId ){
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("SELECT date FROM ".$this->tblName." WHERE idMsg=$msgId");
		if(mysql_num_rows($result) == 0)
			return 2;
		$row = mysql_fetch_object($result);
		return $row->date;
	}
	/**
	* @return int 1		When msgId equal to 0
	* @return int 2		When no Messege in database with that msgId
	* @return array 	Returns the an array with all the fields of the table were messeges are stored
	* @param int $msgId
	* @desc This function is used to return the messege, and all is specifications
	*/
	function GetMessege($msgId)
	{
		$messege = array();
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("SELECT * FROM ".$this->tblName." WHERE idMsg=$msgId");
		if(mysql_num_rows($result) == 0)
			return 2;
		$row = mysql_fetch_object($result);
		$messege['id'] = $row->idMsg;
		$messege['receiver'] = $row->receiver;
		$messege['sender'] = $row->sender;
		$messege['title'] = $row->title;
		$messege['body'] = $row->body;
		$messege['senderLevel'] = $row->senderLevel;
		$messege['readed'] = $row->readed;
		$messege['date'] = $row->date;
		return $messege;
	}
	
	/**
	* @return Int 0		Marked Readed succesfully
	* @return Int 1		When msgId equal to 0
	* @return Int 2		Error while updating database
	* @param unknown $msgId
	* @desc Marks the messege has readed
	*/
	function MarkAsRead($msgId)
	{
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("UPDATE ".$this->tblName." SET readed=1 WHERE idMsg=$msgId");
		if($result)
			return 0;
		else 
			return 2;
	}
	
	/**
	* @return Int 1			Error while collectic info on database
	* @return Int 2			No messeges with this settings
	* @return Array			Returns one array with all messeges
	* 
	* @param Int $order		Can take values from 0 to 5(0-> Order By senderLevel Ascendent,
	*													1-> Order By senderLevel Descendent,
	*													2-> Order By readed messege Ascendent,
	*													3-> Order By readed messege Descendent)
	*													4-> Order By date received - oldest first)
	*													5-> Order By date received - newest first)
	* @param Int $filter	Can take values from 0 to 1(
	*													0-> no filter,
	*													1-> only show UNREAD,
	*													2-> show READ,
	* @param Int $receiver
	* @param Int $sender
	*
	* @desc This function outputs all messeges ordered by $order field and filtered by sender and/or receiver or none to display all messeges
	*/
	function GetAllMesseges($sort = 0, $receiver = '', $sender = '', $filter = 0)
	{
		switch( $sort )
		{
			case 0:
				$order = 'senderLevel ASC';
				break;
			case 1:
				$order = 'senderLevel DESC';
				break;
			case 2:
				$order = 'readed ASC';
				break;
			case 3:
				$order = 'readed DESC';
				break;
			case 4:
				$order = '`date` ASC';
				break;
			case 5:
				$order = '`date` DESC';
				break;
		}
		$where = '';

		switch( $filter )
		{
			case 0:
				break;
			case 1:
				$where = ' AND readed = 0 ';			
				break;
			case 2:
				$where = ' AND readed = 1 ';			
				break;
		}

		if(strlen($receiver) > 0 && strlen($sender) > 0)
			$where = ' AND ';
		
		$where = ((strlen($receiver) > 0)?'receiver=' . $receiver:'') . $where . ((strlen($sender) > 0)?'sender=' . $sender:'');
		
		$sql = "SELECT * FROM ".$this->tblName." WHERE $where ORDER BY $order";
		//echo $sql;
		$result = @mysql_query($sql);
		
		if( !$result )
			return 1;
		$num = mysql_num_rows($result);
		$messege = '';
		for($i = 0 ; $i < $num ; $i++ )
		{
			$row = mysql_fetch_object($result);
			$messege[$i]['id'] = $row->idMsg;
			$messege[$i]['receiver'] = $row->receiver;
			$messege[$i]['sender'] = $row->sender;
			$messege[$i]['title'] = $row->title;
			$messege[$i]['body'] = $row->body;
			$messege[$i]['senderLevel'] = $row->senderLevel;
			$messege[$i]['readed'] = $row->readed;	
			$messege[$i]['date'] = $row->date;
		}
		if( !is_array($messege) )
			return 2;
		return $messege;
			
		
	}


	/**
	* @return Int 0		Deleted succesfully
	* @return Int 1		When msgId equal to 0
	* @return Int 2		Error while deleting from database
	* @param Int $msgId
	* @desc Delete messege
	*/
	function DeleteMessege($msgId)
	{
		if(strlen($msgId) == 0)
			return 1;
		$result = mysql_query("DELETE FROM ".$this->tblName." WHERE idMsg=$msgId");
		if($result)
			return 0;
		else 
			return 2;
	}

	
}
?>