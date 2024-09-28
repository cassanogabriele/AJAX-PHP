<?php
require '../core/init.php';

if(isset($_POST['method']) === true && empty($_POST['method']) === false){
	$chat = new Chat();
	$method = trim($_POST['method']);
	
	if($method === 'fetch'){
		// Capturer les messages.
		$messages = $chat->fetchMessages();
		
		if(empty($messages) === true){
			echo "Il n'y a actuellement aucun message dans le Tchat";
		} else{
			foreach($messages as $message){
			?>
				<div class="message">
					<a href="#"></a><?php echo $message['username']; ?> dit : <?php echo $message['message']; ?>					
				</div>
			<?php 			
			}
		}		
	}
}
?>	

					
				