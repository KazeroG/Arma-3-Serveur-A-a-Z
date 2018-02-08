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
 ?>
 <?php
 include 'load/head.php';
 ?>
 <main class="cd-main-content">
 <?php
 include 'load/navbar.php';
 ?>
		<div class="content-wrapper">
			<h1>Liste de toutes les news </h1>
      <?php

      $req = $bdd->query('SELECT * FROM articles ORDER BY id DESC');

      while($article = $req->fetch())
      {
      ?>
          <div class="col-lg-4">
                  <!-- START panel-->
                  <div class="panel panel-danger">
                     <div class="panel-heading">News #<?php echo $article['id']; ?> - <?php echo $article['titre']; ?></div>
                     <div class="panel-body">
                        <p><a href="news?id=<?php echo $article['id']; ?>">Accéder à l'article</a></p>
                     </div>
                     <div class="panel-footer">Par <?php echo $article['auteur']; ?> le <?php echo $article['date_p']; ?></div>
                  </div>
                  <!-- END panel-->
          </div>


        <?php } ?>
		</div>
	</div>
	</main>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
</body>
</html>
