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
        $this->getUsers();
    }

    public function newMessage($sender, $receiver = NULL, $message, $date = NULL)
	{

		$users = $this->_users;
		// receiver null? so this message is global!
		if($receiver == NULL)
			$receiver = 0;


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