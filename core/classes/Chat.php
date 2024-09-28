<?php
include_once("Core.php");

try{
    $bdd = new PDO('mysql:host=localhost;dbname=c0passionate', 'c0pass', 'wtngkHXD_H6');
	$bdd->exec('SET NAMES utf8');
} catch (Exception $e){
        die('Erreur : ' . $e->getMessage());
}

class Chat extends Core{
	public function fetchMessages(){			
		$this->query("
			SELECT 		chat.message,
						users.username,
						users.user_id
			FROM   		chat
			JOIN   		users
			ON     		chat.user_id = users.user_id
			ORDER BY    chat.timestamp
			DESC				  
		");
				
		return $this->rows(); 	
	}
}
?>	

					
				