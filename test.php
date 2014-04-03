<?php
require("./data/config.php");
require("./data/connection.php");
require("./classes/message.class.php");

// Testing create New Message

$message = new Message;
<<<<<<< HEAD
=======
$message2 = $message->newMessage(1, 1, "hola");

s
require("./classes/user.class.php");

// Testing create new user

$User = new User;
$User2 = $User->newUser(1, 1, "hola");

// Testing get all messages
>>>>>>> 55edc7a30d38826d835a2cdfb5d058a61be6dfb8
$message2 = $message->getAll();

print_r(json_encode($message2));
?>