<?php

require_once("./classes/misc.class.php");
require_once("./classes/user.class.php");


class Message extends Misc {
	public $_users = null;

	public function setUsers(User $users) {
		return $this->_users = $users;
	}
 
	public function getUsers() {
		if(null == $this->_users) {
			$this->setUsers(new User());

		}
		return $this->_users;
	}
	
    public function __construct() {
    	parent::__construct();
        $this->getUsers();
    }

    public function getAll($lastId = NULL){
    	$where_array = array();
    	if(!$this->_users->isAdmin())
   		{
   			$id_user = $this->_users->getCurrentUser();
   			// if user is not admin, only can see your privates and global messages
   			// and if is admin, can see all 
   			$is_admin_array = array("M.receiver", "=", $id_user);
   			array_push($where_array, $is_admin_array);
   		}
   		if(!$lastId == NULL){
   			$lastid_array = array("M.id", ">", $lastId);
   			array_push($where_array, $lastid_array);
   		}

   		if(count($where_array) == 0){
   			$where_array = NULL;
   		}
   		
		$fields_array = array("id", "sender", "receiver", "message", "date");
        $result = $this->_db->advancedSelect("messages M",$fields_array,$where_array, NULL, NULL, "id ASC");

	   		$messages_array = array();
	   	while ($row = $result->fetch_assoc()) {

	   		if($row){

				$msg = array(
					"id" => $row['id'],
					"sender"  => $row['sender'],
					"receiver"  => $row['receiver'],
					"message"  => $row['message'],
					"date"  => $row['date']
					);
				array_push($messages_array, $msg);

			}
		}
				return $messages_array;


    }
    public function newMessage($sender = NULL, $receiver = NULL, $message, $date = NULL)
	{

		$users = $this->_users;
		// receiver null? so this message is global!
		if($receiver == NULL)
			$receiver = 0;


		// sender null? so this message is from current!
		if($receiver == NULL)
			$receiver = $users->getCurrentUser();


		// date null? so this message is sented right now!
		if($date == NULL)
			$date = date("Y-m-d H:i:s");

		$sender = intval($sender);
		$receiver = intval($receiver);
		if($users->isExist($receiver) && $users->isExist($sender))
		{

			$array_values = array(
				"sender" => $sender,
				"receiver" => $receiver,
				"message" => $message,
				"date" => $date
				);


			$id_vote = $this->_db->insertToDB("messages", $array_values);
		}else{
			die("User doesn't exist!");
			return false;
		}



	}

}