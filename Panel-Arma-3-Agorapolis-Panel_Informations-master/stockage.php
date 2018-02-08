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
 ?>
 <?php
 include 'load/head.php';
 ?>
 <main class="cd-main-content">
 <?php
 include 'load/navbar.php';
 ?>
    <div class="content-wrapper">
			<h1>Les stockages de la Division</h1>

  </br></br>
  <div class="row">
    <div class="col-md-3">
      <div class="service-item">
          <div class="icon"><i class="fa fa-signal"></i></div>
    </div>
    <center>Stock total de cocaïne : <?php

              $tcocaine = $bdd->query('SELECT sum(Cocaïne) AS somme FROM stockage');


              while ($cocaine1 = $tcocaine->fetch())
              {
              ?>
              <?php echo $cocaine1['somme']; ?>

<?php
  }
?></center></br></br>
    </div>
    <div class="col-md-3">
      <div class="service-item">
          <div class="icon1"><i class="fa fa-signal"></i></div>
    </div>
    <center>Stock total d'héroïne: <?php

              $thero = $bdd->query('SELECT sum(Héroïne) AS somme FROM stockage');


              while ($hero1 = $thero->fetch())
              {
              ?>
              <?php echo $hero1['somme']; ?>

<?php
  }
?></center></br></br>
    </div>
    <div class="col-md-3">
      <div class="service-item">
          <div class="icon2"><i class="fa fa-signal"></i></div>
    </div>
    <center>Stock total de marijuana : <?php

              $tmari = $bdd->query('SELECT sum(Marijuana) AS somme FROM stockage');


              while ($mari1 = $tmari->fetch())
              {
              ?>
              <?php echo $mari1['somme']; ?>

<?php
  }
?></center></br></br>
    </div>
    <div class="col-md-3">
      <div class="service-item">
          <div class="icon3"><i class="fa fa-signal"></i></div><center>Stock total de speed : <?php

                    $tspeed = $bdd->query('SELECT sum(Speed) AS somme FROM stockage');


                    while ($speed1 = $tspeed->fetch())
                    {
                    ?>
                    <?php echo $speed1['somme']; ?>

    <?php
        }
    ?></center></br></br>
      </div>

    </div>
  </div>

      <div class="row">

        <?php
        $rstockage = $bdd->query('SELECT * FROM stockage');
        foreach($rstockage as $rstockage)
        {

          $total = $rstockage['Cocaïne']*2 + $rstockage['Héroïne']*2 + $rstockage['Marijuana']*2 + $rstockage['Speed']*2;
          $total1 = $total*100;
          $total2 = $rstockage['nbcoffres']*700;
          $dtotal = $total1/$total2;
          $totald = substr("$dtotal", 0, 4);
          if ($totald >= 100) {
            echo "<div class='col-lg-4'>
                  <div class='panel panel-danger'>";
          }
          else {
            echo "<div class='col-lg-4'>
                  <div class='panel panel-success'>";
          };
          echo "  <div class='panel-heading'>".$rstockage['type']." de ".$rstockage['surnom']." | Coordonnées ".$rstockage['coordonnees']."</div>
                   <div class='panel-body'>";

                   if ($totald >= 100) {
                     echo "<p><center><img src='image/".$rstockage['type']."1.png'/></center></br>Capacité de stockage actuelle : $total2 unitées</br></br>";
                   }
                   else {
                     echo "<p><center><img src='image/".$rstockage['type'].".png'/></center></br>Capacité de stockage actuelle : $total2 unitées</br></br>";
                   };

          echo "   <div id='myProgress'>";

                        if ($totald >= 100) {
                          echo "<div id='myBar1' style='width:$totald%;'>";
                        }
                        else {
                          echo "<div id='myBar' style='width:$totald%;'>";
                        };

          echo "                  <div id='label'>$totald%</div>
                          </div>
                        </div>
                      </p>
                      <center>Capacité en détails </br></center>
                      <span style='background-color:rgba(255,255,255,0.5);color:black;border-radius:5px'> Cocaïne :</span>  ".$rstockage['Cocaïne']."</br>
                      <span style='background-color:rgba(239,255,0,0.5);color:black;border-radius:5px'> Héroïne :</span>  ".$rstockage['Héroïne']."</br>
                      <span style='background-color:rgba(66,194,100,0.5);color:black;border-radius:5px'> Marijuana :</span>  ".$rstockage['Marijuana']."</br>
                      <span style='background-color:rgba(173,173,173,0.2);color:black;border-radius:5px'> Speed :</span>  ".$rstockage['Speed']."</br>
                      Commentaire :  ".$rstockage['commentaire']."</br>
                   </div>
                </div>
             </div>
             ";
           }
           ?>
      </div>
    </div>
  </main>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
