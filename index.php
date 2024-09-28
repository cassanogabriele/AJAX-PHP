<?php


include_once("core/classes/Chat.php");
?>	

<!DOCTYPE html>
	<html > 
		<head>				
			<title>Passionate Tchat</title>			
			<link rel="stylesheet" href="css/style.css">	
			<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
			<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		</head>	
		
		<body class="bdy">
			<div class="alert alert-danger text-center" role="alert">
			&#9888; Ce site est un site de démonstration, fonctionnel. Toute informations non ajoutées par mes soins responsabilise l'auteur de l'encodage
			de ces informations, je possède les informations qui ont été encodées par mes soins.
			</div>	
			
			<div id="banniere"></div>
			
			<?php
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				if (empty($_POST['username']) || empty($_POST['message'])) {
					echo "<div class='alert alert-danger text-center' role='alert'>Veuillez remplir tous les champs.</div>";
				} else {
					$user = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : NULL;
					$msg = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : NULL;

					// Vérification de l'adresse e-mail
					if (filter_var($user, FILTER_VALIDATE_EMAIL)) {
						echo "<div class='alert alert-danger text-center' role='alert'>L'adresse e-mail n'est pas autorisée.</div>";
						// Gérer l'erreur ou rediriger l'utilisateur vers une page d'erreur appropriée
						//exit;
					} else {
						// Vérification de caractères bizarres
						if (preg_match('/[^a-zA-Z0-9_]/', $user)) {
							echo "<div class='alert alert-danger text-center' role='alert'>Le nom d'utilisateur contient des caractères non autorisés.</div>";
							// Gérer l'erreur ou rediriger l'utilisateur vers une page d'erreur appropriée
							//exit;
						} else {
							// Vérification du contenu du message
							$forbiddenPatterns = array(
								'/TO RENEW/i',
								'/https?:\/\/\S+/i', // Correspond à n'importe quelle URL commençant par http:// ou https://
								'/\bLegal Disclaimer:/i' // Correspond au début de la phrase "Legal Disclaimer:"
							);

							$isForbidden = false;
							foreach ($forbiddenPatterns as $pattern) {
								if (preg_match($pattern, $msg)) {
									$isForbidden = true;
									break;
								}
							}

							if ($isForbidden) {
								echo "<div class='alert alert-danger text-center' role='alert'>Le contenu du message n'est pas autorisé.</div>";
								// Gérer l'erreur ou rediriger l'utilisateur vers une page d'erreur appropriée
								//exit;
							} else {
								$create_user = $bdd->prepare('INSERT INTO users(username) VALUES(:username)');
								$create_user->execute(array(
									'username' => $user
								));

								$users = $bdd->query("SELECT * FROM users WHERE username='" . $user . "'");
								$fetch_user = $users->fetch();
								$user_id = $fetch_user["user_id"];

								$timestamp = time();

								$message = $bdd->prepare('INSERT INTO chat(user_id, message, timestamp) VALUES(:user_id, :message, :timestamp)');
								$message->execute(array(
									'user_id' => $user_id,
									'message' => $msg,
									'timestamp' => $timestamp,
								));

								if ($message->rowCount() > 0) {
									echo "<div class='alert alert-success text-center' role='alert'>Le formulaire a été soumis avec succès.</div>";
								} else {
									echo "<div class='alert alert-danger text-center' role='alert'>Une erreur s'est produite lors de l'enregistrement du message.</div>";
								}
							}
						}
					}
				}
			}
			?>

			
			
			<div class="chat">				
				<div class="messages"></div>	
				
				<div class="jumbotron" id="identifiants">
					<form action="index.php" method="post" name="formChat">
					<label for="user">Utilisateur</label>
					<br/>
					<input type="text" class="form-control" id="username" name="username" placeholder="Entrez votre nom d'utilisateur">
					<br>
					<label for="message">Message</label>
					<br/>
					<textarea class="entry form-control" id="message" name="message" placeholder="Entrez votre message"></textarea>
					<br/><br/>				
					<input type="submit" id="soumission" class="btn btn-primary" value="Envoyer">
					</form>
				</div>	
			</div>			
			

			<a href="http://icyber-corp.gabriel-cassano.be/" style="display:none;">Icyber-Corp.</a>	
			<a href="http://homesweethomedesign.gabriel-cassano.be/" style="display:none;">Home Sweet Home Design</a>
			<a href="http://invokingdemons.gabriel-cassano.be/" style="display:none;">invoking demons</a>
				
			<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
			<script src="js/chat.js"></script>		
		</body>			
	</html>