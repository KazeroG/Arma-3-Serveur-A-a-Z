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
       if(!empty($_POST['titre']))
       {
    			$titre = htmlspecialchars(trim($_POST['titre']));
    			$contenu = $_POST['contenu'];
          $auteur = htmlspecialchars(trim($_POST['auteur']));
          $date_p = htmlspecialchars(trim($_POST['date_p']));
    			$addarticle = $bdd->prepare('INSERT INTO articles(titre, date_p, auteur, contenu) VALUES(?, ?, ?, ?)');
    			$addarticle->execute(array($titre, $date_p, $auteur, $contenu));
    			header('Location: news.php');
    		}
      }
  		else
  			{
  				$erreur = "L'identité doit être completées";
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
			<h1>Créer une nouvelle news :</h1>
      <div class="col-md-12">
          <div class="panel panel-default">
                     <div class="panel-heading">Formulaire ajout article</div>
                     <div class="panel-body">
                      <form method="POST" class="form-horizontal">

                           <div class="form-group">
                              <label class="col-lg-2 control-label">Titre</label>
                              <div class="col-lg-10">
                                 <input name="titre" type="text" placeholder="Titre de la news" class="form-control">
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-lg-2 control-label">Contenu</label>
                              <div class="col-lg-10">
                                <textarea name="contenu" id="editor1" rows="10" cols="80"></textarea>
                                <script>
                                    CKEDITOR.replace( 'editor1' );
                                </script>
                              </div>
                           </div>

                                 <input name="date_p" type="hidden" value="<?php
                                $date = date("d-m-Y");
                                echo"$date";
                                ?> ">
                                 <input type="hidden" name="auteur" value="<?= $_SESSION['surnom']; ?>" />

                          </br></br>
                           <div class="form-group">
                              <div class="col-lg-offset-2 col-lg-10">
                                 <button name="submit" class="btn btn-sm btn-default">Ajouter la news</button>
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
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
