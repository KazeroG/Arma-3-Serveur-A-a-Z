<?php
require "config.php";
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
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
    <div id="spider">
		<div class="content-wrapper">
			<h1>Bienvenue sur le site de la Division </h1>
			<div class="row">
				<div class="col-sm-6">
        <div class="row">
				      <div class="col-sm-12" style="width:100%">
                  <div class="panel panel-default">
                     <div class="panel-heading"><center>Les 5 dernières news</center></div>
                     <div class="panel-body">
                     	  <div class="text-center center-block">
                          <?php

                          $req = $bdd->query('SELECT * FROM articles ORDER BY id DESC LIMIT 5');

                          while($article = $req->fetch())
                          {

                          ?>
                                        <h4><?php echo $article['titre']; ?></h4>
                                        <p><?php echo $contenu_reduit; ?></p>
                                        <a href="news?id=<?php echo $article['id']; ?>">Accéder à l'article</a></br></br>
                                        <p>Le <?php echo $article['date_p']; ?></p>
                                        <hr>
                                        <?php } ?>

                          </div>
                     	  </div>
                     </div>
                  </div>
				      </div>
		    </div>
        <div class="col-sm-6">
          <div class="col-sm-12" style="width:100%">
            <div class="panel panel-default">
               <div class="panel-heading"><center>Les 2 dernières revendication</center></div>

               <?php
               $rvideo = $bdd->query('SELECT * FROM revendication ORDER BY id DESC LIMIT 2');
               foreach($rvideo as $rvideo)
               {
                 echo"
                 <div class='panel-body'>
                   <iframe width='560' height='315' src='https://www.youtube.com/embed/".$rvideo['video']."' frameborder='0' allowfullscreen></iframe>
                 </div>
             ";
             }
             ?>

              </div>
            </div>
          </div>
        </div>
  </div>
</div>
	</main> <!-- .cd-main-content -->
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
