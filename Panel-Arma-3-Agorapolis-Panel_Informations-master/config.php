<?php
session_start();

$host = ""; # Hôte
$dbname = ""; # Nom de la base de donnée
$user = ""; # Nom d'utiliseur
$password = ""; # Mot de passe

try {

$bdd = new PDO('mysql:host='. $host . ';dbname='. $dbname .';charset=utf8', $user, $password);
}catch(PDOException $e){
   die('Erreur : '.$e->getMessage());
}

		if(isset($_SESSION['id']))
		{
			$aInfo = $bdd->prepare("SELECT * FROM users WHERE id = ?");
			$aInfo->execute(array($_SESSION['id']));
			$rowcPseudo = $aInfo->rowCount();
			if($rowcPseudo == 1)
			{
				$info = $aInfo->fetch();
				$_SESSION['id'] = $info['id'];
				$_SESSION['pseudo'] = $info['pseudo'];
				$_SESSION['email'] = $info['email'];
				$_SESSION['avatar'] = $info['avatar'];
				$_SESSION['grade'] = $info['grade'];
		        $_SESSION['surnom'] = $info['surnom'];
		        $_SESSION['surnom2'] = $info['surnom2'];
			}
		}

?>
