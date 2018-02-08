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
		if(!empty($_POST['video']))
		{
			$video = htmlspecialchars(trim($_POST['video']));
			$addrencontre = $bdd->prepare('INSERT INTO revendication(video) VALUES(?)');
			$addrencontre->execute(array($video));
			header('Location: revendication.php');
		}

		else
			{
				$erreur = "L'id doit être complétés";
			}
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
			<h1>Ajouter une vidéo de revendication </h1>
			<div class="col-md-12">
					<div class="panel panel-default">
          <div class="panel-heading">Ajouter une vidéo de revendication</div>
            <div class="panel-body">
							<form method="POST" class="form-horizontal">
										<div class="form-group">
                      <label class="col-lg-2 control-label">Id de la vidéo</label>
                      <div class="col-lg-10">
                          <input name="video" placeholder="Id de la vidéo ( situé après le ?v= dans l'url )" type="text" class="form-control">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-lg-offset-2 col-lg-10">
                          <button name="submit" class="btn btn-sm btn-default">Ajouter</button>
                      </div>
                    </div>
                </form>
            </div>
					</div>
				</div>
		</div>
	</div>
	</main>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
</body>
</html>
