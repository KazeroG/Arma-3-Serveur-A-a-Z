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
			<h1>Itinéraires : </h1>






                  <div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                           <div class="panel-heading">Les différents itinéraires</div>
                           <div class="panel-body">
                              <div id="accordion" class="panel-group">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Trajet n°1 | AP -> Cocaïne -> Pyrgos</a>
                                       </h4>
                                    </div>
                                    <div id="collapse2" class="panel-collapse collapse">
                                       <div class="panel-body"><img src="image/trajet1.jpg"/></div>
                                    </div>
                                 </div>
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Trajet n°2 | AP -> Cocaïne -> Pyrgos -> Traitement Rubis -> Triple Traitements -> Rodopoli -> Telos -> Pyrgos</a>
                                       </h4>
                                    </div>
                                    <div id="collapse3" class="panel-collapse collapse">
                                       <div class="panel-body"><img src="image/trajet2.jpg"/></div>
                                    </div>
                                 </div>
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse4">Trajet n°2 | AP -> Cocaïne -> Pyrgos -> Athira -> Traitement cocaïne -> Prison -> Pyrgos</a>
                                       </h4>
                                    </div>
                                    <div id="collapse4" class="panel-collapse collapse">
                                       <div class="panel-body"><img src="image/trajet3.jpg"/></div>
                                    </div>
                                 </div>
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse5">Notre zone d'afluence</a>
                                       </h4>
                                    </div>
                                    <div id="collapse5" class="panel-collapse collapse">
                                       <div class="panel-body"><img src="image/zone1.jpg"/></div>
                                    </div>
                                 </div>
                              </div>
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
