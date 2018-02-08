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
if(isset($_POST['submit']))
{
  $id = htmlspecialchars(trim($_POST['id']));
  $titre = htmlspecialchars(trim($_POST['titre']));
  $contenu = $_POST['contenu'];
  $UPDATEnews = $bdd->prepare("UPDATE articles SET titre = ?, contenu = ? WHERE id = ?");
  $UPDATEnews->execute(array($titre, $contenu, $id));
  header('Location:	news.php');
}
if (isset($_POST['delete']))
{
  $id = htmlspecialchars(trim($_POST['id']));
  $req = $bdd->prepare('DELETE FROM articles WHERE id = ?');
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
			<h1>Editer mes news</h1>
      <?php
      if($_SESSION['grade'] == "Agent Representant"){
			$news1 = $bdd->prepare("SELECT `id`, `titre`, `contenu`, `auteur` FROM `articles`");
			$news1->bindParam(":auteur", $_SESSION["surnom"], PDO::PARAM_STR);
			$news1->execute();
			while($Data = $news1->fetch()):?>
        <div class="col-md-12">
          <div class="panel panel-default">
                     <div class="panel-heading">Editer la news n°<?=$Data['id'] ?></div>
                     <div class="panel-body">
                      <form method="POST" class="form-horizontal">

                           <div class="form-group">
                              <label class="col-lg-2 control-label">Titre</label>
                              <div class="col-lg-10">
                                 <input name="titre" type="text" value="<?=$Data['titre'] ?>" class="form-control">
                              </div>
                           </div>
                           <input type="hidden" name="id" value="<?=$Data["id"] ?>">
                           <div class="form-group">
                              <label class="col-lg-2 control-label">Contenu</label>
                              <div class="col-lg-10">
                                <textarea name="contenu" id="editor<?=$Data["id"] ?>" rows="10" cols="80"><?=$Data['contenu'] ?></textarea>
                                <script>
                                    CKEDITOR.replace( 'editor<?=$Data["id"] ?>' );
                                </script>
                              </div>
                           </div>
                          </br></br>
                           <div class="form-group">
                              <div class="col-lg-offset-2 col-lg-10">
                                 <button name="submit" class="btn btn-sm btn-default">Ajouter la news</button>
                              </div>
                           </div>
                        </form>

                        <form class="form-horizontal" method="post">
                          <div class="col-lg-offset-2 col-lg-10">
                          <input type="hidden" name="id" value="<?=$Data["id"] ?>">
                          <button name="delete" class="btn btn-sm btn-default">Supprimer</button>
                        </div>
                        </form>
            </div>
          </div>
        </div>
			<?php endwhile; } else {
        $news1 = $bdd->prepare("SELECT `id`, `titre`, `contenu`, `auteur` FROM `articles` WHERE `auteur` = :auteur ");
  			$news1->bindParam(":auteur", $_SESSION["surnom"], PDO::PARAM_STR);
  			$news1->execute();
  			while($Data = $news1->fetch()):?>
          <div class="col-md-12">
            <div class="panel panel-default">
                       <div class="panel-heading">Editer la news n°<?=$Data['id'] ?></div>
                       <div class="panel-body">
                        <form method="POST" class="form-horizontal">

                             <div class="form-group">
                                <label class="col-lg-2 control-label">Titre</label>
                                <div class="col-lg-10">
                                   <input name="titre" type="text" value="<?=$Data['titre'] ?>" class="form-control">
                                </div>
                             </div>
                             <input type="hidden" name="id" value="<?=$Data["id"] ?>">
                             <div class="form-group">
                                <label class="col-lg-2 control-label">Contenu</label>
                                <div class="col-lg-10">
                                  <textarea name="contenu" id="editor<?=$Data["id"] ?>" rows="10" cols="80"><?=$Data['contenu'] ?></textarea>
                                  <script>
                                      CKEDITOR.replace( 'editor<?=$Data["id"] ?>' );
                                  </script>
                                </div>
                             </div>
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
			<?php endwhile; } ?>
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
