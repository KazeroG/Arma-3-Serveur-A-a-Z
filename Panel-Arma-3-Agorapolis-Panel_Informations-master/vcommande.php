<?php
session_start();
include_once("panier/config.php");
include_once("config.php");
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
  header('Location: index.php');
}
if ($_SESSION['grade'] == 'Harsh'){
	header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
  <script src="https://use.fontawesome.com/158774fdb7.js"></script>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link href="panier/style/style.css" rel="stylesheet" type="text/css">
	<script src="../js/modernizr.js"></script>
	<script src="../ckeditor/ckeditor.js"></script>
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
	<link rel="icon" href="../favicon.ico" type="image/x-icon">
	<title>Division</title>

</head>
<body>
  <header class="cd-main-header">
  <a class="cd-logo"><img src="articles/image/logo.png" style="border-radius:5%;width:40px;" alt="Logo"></a>


  <div class="cd-search is-hidden">
    <form>
      <input placeholder="Grade actuel : <?= $_SESSION['grade']; ?>" disabled>
    </form>
  </div>
    <nav class="cd-nav">
      <ul class="cd-top-nav">
        <li><a href="profil">Mon compte</a></li>
        <li><a href="logout">Déconnexion</a></li>
        <li class="has-children account">
          <a>
            <img src="membres/avatars/<?= $_SESSION['avatar']; ?>">
            <?= $_SESSION['pseudo']; ?>
          </a>
        </li>
      </ul>
    </nav>
  </header>
  <?php
  include 'load/navbar.php';
  ?>
  <div class="content-wrapper"></br></br></br></br></br>
<h1 align="center">Mes commandes</h1></br></br></br></br>
	<?php
	$vcommande = $bdd->prepare("SELECT `id`, `commande`, `date`, `pseudo`, `etat`, `commentaire` FROM `commande` WHERE `pseudo` = :pseudo");
	$vcommande->bindParam(":pseudo", $_SESSION["pseudo"], PDO::PARAM_STR);
	$vcommande->execute();
	while($Data = $vcommande->fetch()):?>

	<div class="cart-view-table-back <?=$Data["etat"] ?>">
	<a style="color:orange;text-align:left"><b> Commande n°<?=$Data["id"] ?> de <?=$Data["pseudo"] ?></a>

	<div><b>Etat : <?=$Data["etat"] ?></b></div></b><?=$Data["commande"] ?></br>
  Commentaire : <?=$Data["commentaire"] ?>
	</div></br></br>';
<?php endwhile; ?>
</div>
</body>
</html>
