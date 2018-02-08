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
  $titre = htmlspecialchars(trim($_POST['titre']));
  $contenu = $_POST['contenu'];
  $UPDATEnews = $bdd->prepare("UPDATE news SET titre = ?, contenu = ? WHERE id = ?");
  $UPDATEnews->execute(array($titre, $contenu, $id));
  header('Location:	articles/index.php');
}
if (isset($_POST['delete']))
{
  $id = htmlspecialchars(trim($_POST['id']));
  $req = $bdd->prepare('DELETE FROM news WHERE id = ?');
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
			<h1>Editer les articles</h1>
      <?php
       $articles = $bdd->query('SELECT * FROM news');
       foreach($articles as $articles)
       {
         echo"<div class='col-md-12'>
          <div class='panel panel-default'>
                     <div class='panel-heading'>Editer l'article n°".$articles['id']."</div>
                     <div class='panel-body'>
                      <form method='POST' class='form-horizontal'>

                           <div class='form-group'>
                              <label class='col-lg-2 control-label'>Titre</label>
                              <div class='col-lg-10'>
                                 <input name='titre' type='text' value='".$articles['titre']."' class='form-control'>
                              </div>
                           </div>
                           <input type='hidden' name='id' value='".$articles['id']."'>
                           <div class='form-group'>
                              <label class='col-lg-2 control-label'>Contenu</label>
                              <div class='col-lg-10'>
                                <textarea name='contenu' id='editor".$articles['id']."' rows='10' cols='80'>".$articles['contenu']."</textarea>
                                <script>
                                    CKEDITOR.replace( 'editor".$articles['id']."' );
                                </script>
                              </div>
                           </div>
                          </br></br>
                           <div class='form-group'>
                              <div class='col-lg-offset-2 col-lg-10'>
                                 <button name='submit' class='btn btn-sm btn-default'>Editer l'article</button>
                              </div>
                           </div>
                        </form>
                        <form class='form-horizontal' method='post'>
                          <div class='form-group'>
                              <div class='col-lg-offset-2 col-lg-10'>
                                <input type='hidden' name='id' value='".$articles['id']."'>
                                <button name='delete' class='btn btn-sm btn-default'>Supprimer</button>
                              </div>
                           </div>
                        </form>
            </div>
          </div>
        </div>
			";}
      ?>
		</div>
	 </div>
	</main>

<script src="js/app.js"></script>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
