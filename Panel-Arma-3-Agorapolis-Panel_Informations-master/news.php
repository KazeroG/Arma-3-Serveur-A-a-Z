<?php
require "config.php";
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
  header('Location: index.php');
}
if ($_SESSION['grade'] == 'Harsh'){
	header('Location: index.php');
}
require_once 'configuration.fonction.php';

if(isset($_POST['submit']))
{
  $pseudo = htmlspecialchars(trim($_POST['pseudo']));
  $date_p = htmlspecialchars(trim($_POST['date_p']));
  $ida = htmlspecialchars(trim($_POST['ida']));
  $commentaire = htmlspecialchars(trim($_POST['commentaire']));
  $addcomment = $bdd->prepare('INSERT INTO commentaire(pseudo, date_p, ida, commentaire) VALUES(?, ?, ?, ?)');
  $addcomment->execute(array($pseudo, $date_p, $ida, $commentaire));
  header("Location: news?id=$get_id");
}
$commentaires = $bdd->prepare('SELECT * FROM commentaire WHERE ida = ? ORDER BY id DESC');
$commentaires->execute(array($getid));


if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $get_id = htmlspecialchars($_GET['id']);
   $article = $bdd->prepare('SELECT * FROM articles WHERE id = ?');
   $article->execute(array($get_id));
   if($article->rowCount() == 1) {
      $article = $article->fetch();
      $titre = $article['titre'];
      $contenu = $article['contenu'];
      $date_i = $article['date_p'];
      $auteur = $article['auteur'];
   } else {
      die('Cet article n\'existe pas !'); // Si l'id entrée n'existe pas
   }
} else {

   header("Location: list_news.php");
   exit(); // Si vous vous diriger sur news.php directement, vous pouvez évidemment mettre ce que vous voulez, mais je préfère faire une redirection.
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
    </br></br></br></br>
        <div class="row">
           <div class="col-md-12">
              <h2 align="center"><?= $article['titre']; ?></h2>
              <h4 align="center">Posté le <?= $article['date_p']; ?> par <?= $article['auteur']; ?></h4>
              <center>--------------</center>
              <p><?= $article['contenu']; ?>
              </p>
              <center>____________________________________________________________________________________________</center>

            </br><center><h4>Commentaires:</h4></br>
            </div>
            <center><div class="col-md-6">
              <div class='panel panel-info'>
                <div class='panel-heading'>Commentaire</div>
              <?php
        			$commentaire = $bdd->prepare("SELECT `id`, `pseudo`, `commentaire`, `date_p` FROM `commentaire` WHERE `ida` = :id");
        			$commentaire->bindParam(":id", $get_id, PDO::PARAM_STR);
        			$commentaire->execute();
        			while($Data = $commentaire->fetch()):?>


                      </br><?=$Data["commentaire"] ?></br></br>
                        <div class="panel-footer">
                             De <?=$Data["pseudo"] ?> posté le <?=$Data["date_p"] ?>
                        </div>

        			<?php endwhile;

        			?>

              </div>
            </div>
                <form method="POST" action="news?id=<?= $get_id ?>">
                   <input type="hidden" value="<?= $_SESSION['pseudo']; ?>" name="pseudo" />
                   <input type="hidden" value="<?= $get_id ?>" name="ida" />
                   <input type="hidden" value="<?php $date = date("d-m-Y"); echo"$date"; ?>" name="date_p" /><br />
                   <textarea rows="5" cols="80" name="commentaire" placeholder="Votre commentaire..."></textarea><br /></br>
                   <button name="submit" class="btn btn-sm btn-default">Poster mon commentaire</button>
                </form>
              </center>
          </div>
    </div>
    </div>
  </main>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
