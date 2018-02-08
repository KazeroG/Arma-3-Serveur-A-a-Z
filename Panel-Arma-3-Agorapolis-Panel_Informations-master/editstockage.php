<?php
require "config.php";
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
  header('Location: login.php');
}
if ($_SESSION['grade'] == 'Harsh'){
	header('Location: index.php');
}
	if(isset($_POST['submit']))
	{
		$id = htmlspecialchars(trim($_POST['id']));
		$nbcoffres = htmlspecialchars(trim($_POST['nbcoffres']));
		$Cocaïne = htmlspecialchars(trim($_POST['Cocaïne']));
		$Héroïne = htmlspecialchars(trim($_POST['Héroïne']));
		$Marijuana = htmlspecialchars(trim($_POST['Marijuana']));
		$Speed = htmlspecialchars(trim($_POST['Speed']));
    $commentaire = htmlspecialchars(trim($_POST['commentaire']));
		$UPDATEcommande = $bdd->prepare("UPDATE stockage SET nbcoffres = ?, Cocaïne = ?, Héroïne = ?, Marijuana = ?, Speed = ?, commentaire = ? WHERE id = ?");
		$UPDATEcommande->execute(array($nbcoffres, $Cocaïne, $Héroïne, $Marijuana, $Speed, $commentaire, $id));
		header('Location:	stockage.php');
	}
  if (isset($_POST['delete']))
  {
    $id = htmlspecialchars(trim($_POST['id']));
    $req = $bdd->prepare('DELETE FROM stockage WHERE id = ?');
    $req->execute(array($id));
  }
?>
<?php
include 'load/head.php';
?>
<main class="cd-main-content">
<?php
include 'load/navbar.php';
?>

		<div class="content-wrapper">
			<h1>Editer mes lieux de stockages</h1>
			<?php
			$commande = $bdd->prepare("SELECT `id`, `type`, `nbcoffres`, `coordonnees`, `date`, `surnom`, `Cocaïne`, `Héroïne`, `Marijuana`, `Speed`, `commentaire` FROM `stockage` WHERE `surnom` = :surnom");
			$commande->bindParam(":surnom", $_SESSION["surnom"], PDO::PARAM_STR);
			$commande->execute();
			while($Data = $commande->fetch()):?>
			<div class='col-lg-4'>
							<div class='panel panel-success'>
								 <div class='panel-heading'><?=$Data["type"] ?> de <?=$Data["surnom"] ?></div>
								 <div class='panel-body'>
										<p><center><img src='image/"<?=$Data["type"] ?>.png'/></center></br></br>
										</p>
										<center>Capacité en détails</br></center>
										<form method="POST" class="form-horizontal">
										<input type="hidden" name="id" value="<?=$Data["id"] ?>">
                    Nombres de coffres : <input class="form-control" type="text" name="nbcoffres" value="<?=$Data["nbcoffres"] ?>"></br>
										Cocaïne : <input class="form-control" type="text" name="Cocaïne" value="<?=$Data["Cocaïne"] ?>"></br>
										Héroïne : <input class="form-control" type="text" name="Héroïne" value="<?=$Data["Héroïne"] ?>"></br>
										Marijuana : <input class="form-control" type="text" name="Marijuana" value="<?=$Data["Marijuana"] ?>"></br>
										Speed :  <input class="form-control" type="text" name="Speed" value="<?=$Data["Speed"] ?>"></br>
                    Commentaire :  <input class="form-control" type="text" name="commentaire" value="<?=$Data["commentaire"] ?>"></br>
										<div class="form-group">
											 <div class="col-lg-offset-2 col-lg-12">
													<button name="submit" class="btn btn-sm btn-default">Mettre à jour</button></br></br>
                          </form>
                          <form class="form-horizontal" method="post">
                            <input type="hidden" name="id" value="<?=$Data["id"] ?>">
                            <button name="delete" class="btn btn-sm btn-default">Supprimer</button>
                          </form>
											 </div>
										</div>


								 </div>
							</div>
					 </div>
			<?php endwhile;
			?>
    </div>
  </main>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
