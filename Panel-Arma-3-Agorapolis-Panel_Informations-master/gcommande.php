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
if(isset($_POST['submit'])){
     if(!empty($_POST['etat']))
      {
    $id = htmlspecialchars(trim($_POST['id']));
    $etat = htmlspecialchars(trim($_POST['etat']));
    $UPDATEcommande = $bdd->prepare("UPDATE commande SET etat = ? WHERE id = ?");
    $UPDATEcommande->execute(array($etat, $id));
    header('Location: gcommande.php');
      }
  }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
  <script src="https://use.fontawesome.com/158774fdb7.js"></script>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/style.css">
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
    <h1 align="center">Les commandes en attente | en cours</h1></br></br></br></br>

    <?php
    $gcommande = $bdd->query('SELECT * FROM commande');
    foreach($gcommande as $gcommande)
    {

    if($gcommande['etat'] == "En attente" || $gcommande['etat'] == "En cours"){
  	echo "<div class='cart-view-table-back ".$gcommande['etat']."'>
  	      <a style='color:orange;text-align:left'><b> Commande n°".$gcommande['id']." de ".$gcommande['pseudo']."</a></br></br>
  	      <div>
            <form method='POST' action='gcommande.php'>
            <b>Etat actuel : ".$gcommande['etat']."</b></br></br> Modifié :
              <select name='etat' class='input-sm form-control'>
                <option value='En attente'>En attente</option>
                <option value='En cours'>En cours</option>
                <option value='Livrée'>Livrée</option>
                <option value='Refusée'>Refusée</option>
              </select>
        <input type='hidden' name='id' value=".$gcommande['id']." />
        <button name='submit' class='btn btn-sm btn-primary link'>Appliquer</button>

    </b>".$gcommande['commande']."</br>
    Commentaire : ".$gcommande['commentaire']."
  	</div></div></br></br></form>";}

    }


  ?>
<h1 align="center">Les commandes archivées</h1></br></br></br></br>


    <?php
    $gcommande = $bdd->query('SELECT * FROM commande');
    foreach($gcommande as $gcommande)
    {

    if($gcommande['etat'] == "Refusée" || $gcommande['etat'] == "Livrée"){
    echo "
    <div class='row' style='padding-left:30%;padding-right:30%'>
    <div class='col-lg-12'>
          <div class='panel-body'>
             <div id='accordion' class='panel-group'>
                <div class='panel panel-default'>
                   <div class='panel-heading'>
                      <h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion' href='#collapse".$gcommande['id']."'>";

                      if($gcommande['etat'] == "Refusée"){

                      echo "<i style='background-color:#60282a'>[".$gcommande['etat']."]</i>";

                      }

                      if($gcommande['etat'] == "Livrée"){

                      echo "<i style='background-color:#25632a'>[".$gcommande['etat']."]</i>";

                      }

                        echo" Commande n°".$gcommande['id']." de ".$gcommande['pseudo']."</a>
                      </h4>
                   </div>
                   <div id='collapse".$gcommande['id']."' class='panel-collapse collapse'>
                      <div class='panel-body'>
                      <div class='cart-view-table-back ".$gcommande['etat']."'>
                            <a style='color:orange;text-align:left'><b> Commande n°".$gcommande['id']." de ".$gcommande['pseudo']."</a></br></br>
                            <div>
                              <form method='POST' action='gcommande.php'>
                              <b>Etat actuel : ".$gcommande['etat']."</b></br></br> Modifié :
                                <select name='etat' class='input-sm form-control'>
                                  <option value='En attente'>En attente</option>
                                  <option value='En cours'>En cours</option>
                                  <option value='Livrée'>Livrée</option>
                                  <option value='Refusée'>Refusée</option>
                                </select>
                          <input type='hidden' name='id' value=".$gcommande['id']." />
                          <button name='submit' class='btn btn-sm btn-primary link'>Appliquer</button>

                      </b>".$gcommande['commande']."</br>
                      Commentaire : ".$gcommande['commentaire']."
                      </div></div></br></br></form>
                      </div>
                   </div>
                </div>
             </div>
          </div>
     </div>
   </div>





  ";}

    }


    ?>
</div>
</div>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
