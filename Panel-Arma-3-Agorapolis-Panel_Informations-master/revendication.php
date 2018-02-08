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
			<h1>Liste des revendications : </h1>
        <div class="row">
          <?php
          $rvideo = $bdd->query('SELECT * FROM revendication ORDER BY id');
          foreach($rvideo as $rvideo)
          {
            echo"
          <div class='col-sm-6'>
              <div class='panel panel-default'>
                 <div class='panel-heading'><center>Revendication n°".$rvideo['id']."</center></div>
                  <div class='panel-body'>
                    <center><iframe width='560' height='315' src='https://www.youtube.com/embed/".$rvideo['video']."' frameborder='0' allowfullscreen></iframe></center>
                  </div>
              </div>
            </div>
        ";
        }
        ?>
        </div>
	  </div>
	</main>
<script src="js/app.js"></script>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
</body>
</html>
