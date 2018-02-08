<?php
require "config.php";
if ($_SESSION['grade'] == 'Inconnu'){
  header('Location: exit.php');
} elseif(!isset($_SESSION['id'])){
  header('Location: index.php');
}
if ($_SESSION['grade'] == 'Harsh' || $_SESSION['grade'] == 'Agent Divisionnaire' || $_SESSION['grade'] == 'Agent Renegat' || $_SESSION['grade'] == 'Agent Representant') {

if(isset($_POST['submit']))
{
  if(!empty($_POST['pseudo']))
  {
    $date_p = htmlspecialchars(trim($_POST['date_p']));
    $type = htmlspecialchars(trim($_POST['type']));
    $pseudo = htmlspecialchars(trim($_POST['pseudo']));
    $marijuana = htmlspecialchars(trim($_POST['marijuana']));
    $heroine = htmlspecialchars(trim($_POST['heroine']));
    $cocaine = htmlspecialchars(trim($_POST['cocaine']));
    $speed = htmlspecialchars(trim($_POST['speed']));
    $bmarijuana = htmlspecialchars(trim($_POST['bmarijuana']));
    $bheroine = htmlspecialchars(trim($_POST['bheroine']));
    $bcocaine = htmlspecialchars(trim($_POST['bcocaine']));
    $bspeed = htmlspecialchars(trim($_POST['bspeed']));
    $addharsh = $bdd->prepare('INSERT INTO harsh(date_p, type, pseudo, marijuana, heroine, cocaine, speed, bmarijuana, bheroine, bcocaine, bspeed) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $addharsh->execute(array($date_p, $type, $pseudo, $marijuana, $heroine, $cocaine, $speed, $bmarijuana, $bheroine, $bcocaine, $bspeed));
    header('Location: harsh.php');
  }

  else
    {
      $erreur = "L'identité doit être completées";
    }
}

if(isset($_POST['submit1']))
{
  $id2 = htmlspecialchars(trim($_POST['id2']));
  $pseudo2 = htmlspecialchars(trim($_POST['pseudo2']));
  $marijuana2 = htmlspecialchars(trim($_POST['marijuana2']));
  $heroine2 = htmlspecialchars(trim($_POST['heroine2']));
  $cocaine2 = htmlspecialchars(trim($_POST['cocaine2']));
  $speed2 = htmlspecialchars(trim($_POST['speed2']));
  $bmarijuana2= htmlspecialchars(trim($_POST['bmarijuana2']));
  $bheroine2 = htmlspecialchars(trim($_POST['bheroine2']));
  $bcocaine2 = htmlspecialchars(trim($_POST['bcocaine2']));
  $bspeed2 = htmlspecialchars(trim($_POST['bspeed2']));
  $UPDATEharsh = $bdd->prepare("UPDATE harsh SET pseudo = ?, marijuana = ?, heroine = ?, cocaine = ?, speed = ?, bmarijuana = ?, bheroine = ?, bcocaine = ?, bspeed = ? WHERE id = ?");
  $UPDATEharsh->execute(array($pseudo2, $marijuana2, $heroine2, $cocaine2, $speed2, $bmarijuana2, $bheroine2, $bcocaine2, $bspeed2, $id2));
  header('Location:	accueil.php');
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
          <h1><img class="animated flipInX" src="http://image.noelshack.com/fichiers/2016/48/1480714613-1471263537-logo-harsh.png" style="width:150px;height:150px;"></h1>
          <div class="row">


          <div class="animated flipInY col-md-6">
            <div class="service-item">
                <div class="icon"><i class="fa fa-signal"></i></div>
          </div>
          </br></br>
    </div>
    <div class="animated flipInY col-md-6">
      <div class="service-item">
          <div class="icon"><i class="fa fa-signal"></i></div>
    </div>
    <center>Détails : </br></br><?php
              $tmarijuana = $bdd->query('SELECT sum(marijuana) AS somme FROM harsh');

              while ($marijuana1 = $tmarijuana->fetch())
              {
                echo "<div style='color:rgba(66,194,100,0.5)'>Marijuana vendu : ".$marijuana1['somme']." unités</br></br></div>";
              }


              $theroine = $bdd->query('SELECT sum(heroine) AS somme FROM harsh');

              while ($heroine1 = $theroine->fetch())
              {
                echo "<div style='color:rgba(239,255,0,0.5)'>Héroïne vendu : ".$heroine1['somme']." unités</br></br></div>";
              }

              $tcocaine = $bdd->query('SELECT sum(cocaine) AS somme FROM harsh');

              while ($cocaine1 = $tcocaine->fetch())
              {
                echo "<div style='color:rgba(255,255,255,0.5)'>Cocaïne vendu : ".$cocaine1['somme']." unités</br></br></div>";
              }


              $tspeed = $bdd->query('SELECT sum(speed) AS somme FROM harsh');

              while ($speed1 = $tspeed->fetch())
              {
               echo "<div style='color:rgba(173,173,173,0.5)'>Speed vendu : ".$speed1['somme']." unités</div>";
              }

?>
</center></br></br>
</div>
  </div></br></br></br></br></br>
  <div class="divider"><span></span></div>
          <h1>Livre des comptes</h1>
          <?php
          if ($_SESSION['grade'] == 'Harsh'){?>
            <div class="content-wrapper wow animated swing">
              <div id="accordion" class="panel-group">
                 <div class="panel panel-default">
                    <div class="panel-heading">
                       <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Ajouter une vente</a>
                       </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                       <div class="panel-body">
                         <div class="col-md-12">
                             <div class="panel panel-default">
                                <div class="panel-body">
                                  <form method="POST" class="form-horizontal">
                                      <input name="date_p" type="hidden" value="<?php $date = date("d-m-Y"); echo"$date"; ?> "/>
                                            <div class="form-group">
                                                <label class="col-lg-3 control-label">Type de vente</label>
                                                <div style="padding-left:15px;"class="input-group pull-left">
                                                     <div class="input-group pull-right">
                                                        <select name="type" class="input-sm form-control">
                                                           <option value="Livrée dealer">Livrée dealer</option>
                                                           <option value="Harsh aide la Division au transport">Harsh aide la Division au transport</option>
                                                           <option value="Directement Stocké">Directement Stocké</option>
                                                        </select>
                                                     </div>
                                                </div></br></br>
                                            </div>
                                              <div class="form-group">
                                                 <label class="col-lg-3 control-label">Personne ayant effectué la vente</label>
                                                 <div class="col-lg-4">
                                                    <input name="pseudo" type="text" class="form-control">
                                                 </div>
                                              </div>

                                              <div class="form-group">
                                                 <label class="col-lg-3 control-label">Quantité total de drogues</label>
                                                 <div class="col-lg-2">
                                                   <p><input type="number" class="form-control" placeholder="Marijuana" name="marijuana"/></p>
                                                   <p><input type="number" class="form-control" placeholder="Héroïne" name="heroine"/></p>
                                                   <p><input type="number" class="form-control" placeholder="Cocaïne" name="cocaine"/></p>
                                                   <p><input type="number" class="form-control" placeholder="Speed" name="speed"/></p>
                                                 </div>

                                              </div>

                                              <div class="form-group">
                                                 <label class="col-lg-3 control-label">Prix de la bourse de chaque drogue vendu</label>
                                                 <div class="col-lg-3">
                                                   <p><input type="number" class="form-control" placeholder="Bourse Marijuana" name="bmarijuana"/></p>
                                                   <p><input type="number" class="form-control" placeholder="Bourse Héroïne" name="bheroine"/></p>
                                                   <p><input type="number" class="form-control" placeholder="Bourse Cocaïne" name="bcocaine"/></p>
                                                   <p><input type="number" class="form-control" placeholder="Bourse Speed" name="bspeed"/></p>
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
                 </div>
              </div>

              <div id="accordion" class="panel-group">
                 <div class="panel panel-default">
                    <div class="panel-heading">
                       <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Editer les ventes</a>
                       </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                       <div class="panel-body">
                         <div class="col-md-12">
                             <div class="panel panel-default">
                                <div class="panel-body">

                                  <?php
                                   $eharsh = $bdd->query('SELECT * FROM harsh');
                                   foreach($eharsh as $eharsh)
                                   {
                                     echo "
                                                        <div id='accordion' class='panel-group'>
                                                           <div class='panel panel-default'>
                                                              <div class='panel-heading'>
                                                                 <h4 class='panel-title'><a data-toggle='collapse' data-parent='#accordion3' href='#collapse4".$eharsh['id']."'>Vente n°".$eharsh['id']."</a>
                                                                 </h4>
                                                              </div>
                                                              <div id='collapse4".$eharsh['id']."' class='panel-collapse collapse'>
                                                                 <div class='panel-body'>
                                                                   <div class='col-md-12'>
                                                                       <div class='panel panel-default'>
                                                                          <div class='panel-body'>
                                                                            <form method='POST' class='form-horizontal'>
                                                                                        <div class='form-group'>
                                                                                           <label class='col-lg-3 control-label'>Personne ayant effectué la vente</label>
                                                                                           <div class='col-lg-4'>
                                                                                              <input name='pseudo2' type='text' class='form-control' value='".$eharsh['pseudo']."'>
                                                                                           </div>
                                                                                        </div>
                                                                                        <input name='id2' type='hidden' class='form-control' value='".$eharsh['id']."'>
                                                                                        <div class='form-group'>
                                                                                           <label class='col-lg-3 control-label'>Quantité total de drogues</label>
                                                                                           <div class='col-lg-2'>
                                                                                             <p><input type='number' class='form-control' value='".$eharsh['marijuana']."' name='marijuana2'/></p>
                                                                                             <p><input type='number' class='form-control' value='".$eharsh['heroine']."' name='heroine2'/></p>
                                                                                             <p><input type='number' class='form-control' value='".$eharsh['cocaine']."' name='cocaine2'/></p>
                                                                                             <p><input type='number' class='form-control' value='".$eharsh['speed']."' name='speed2'/></p>
                                                                                           </div>

                                                                                        </div>

                                                                                        <div class='form-group'>
                                                                                           <label class='col-lg-3 control-label'>Prix de la bourse de chaque drogue vendu</label>
                                                                                           <div class='col-lg-3'>
                                                                                             <p><input type='number' class='form-control' value='".$eharsh['bmarijuana']."' name='bmarijuana2'/></p>
                                                                                             <p><input type='number' class='form-control' value='".$eharsh['bheroine']."' name='bheroine2'/></p>
                                                                                             <p><input type='number' class='form-control' value='".$eharsh['bcocaine']."' name='bcocaine2'/></p>
                                                                                             <p><input type='number' class='form-control' value='".$eharsh['bspeed']."' name='bspeed2'/></p>
                                                                                           </div>
                                                                                        </div>
                                                                                        <div class='form-group'>
                                                                                           <div class='col-lg-offset-2 col-lg-10'>
                                                                                              <button name='submit1' class='btn btn-sm btn-default'>Ajouter</button>
                                                                                           </div>
                                                                                        </div>
                                                                                     </form>
                                                                         </div>
                                                                       </div>
                                                                     </div>
                                                                 </div>
                                                              </div>
                                                           </div>
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
              </div>

            </div>
          <?php } ?>

          <div class="row wow animated swing">
            <div class="col-sm-12">
              <div class="panel panel-default">
                   <div class="panel-footer">
                      <div class="row">
                         <div class="col-lg-2">
                            <input type="search" placeholder="Recherche"  data-table="order-table" class="input-sm form-control light-table-filter">
                         </div>
                      </div>
                   </div>
                   <div class="panel-wrapper collapse in"><div class="table-responsive">
                     <table class="order-table table table-bordered table-hover">
                       <thead>
                        <tr>
                          <th style="width:1px">#</th>
                          <th style="width:8px">Date de la vente</th>
                          <th style="width:5px;">Personne ayant rachetés</th>
                          <th style="width:10px">Type de vente</th>
                          <th style="width:8px">Prix de rachat</th>
                          <th style="width:8px;">Quantité total de drogue</th>
                          <th style="background-color:rgba(66,194,100,0.5);color:white;width:3px">Marijuana</th>
                          <th style="background-color:rgba(239,255,0,0.5);color:white;width:3px">Héroïne</th>
                          <th style="background-color:rgba(255,255,255,0.5);color:white;width:3px">Cocaïne</th>
                          <th style="background-color:rgba(173,173,173,0.5);color:white;width:3px">Speed</th>
                          <?php
                          if ($_SESSION['grade'] == 'Harsh') { ?>
                          <th style="background-color:rgba(66,194,100,0.5);color:white;width:5px">Bourse Marijuana</th>
                          <th style="background-color:rgba(239,255,0,0.5);color:white;width:5px">Bourse Héroïne</th>
                          <th style="background-color:rgba(255,255,255,0.5);color:white;width:5px">Bourse Cocaïne</th>
                          <th style="background-color:rgba(173,173,173,0.5);color:white;width:5px">Bourse Speed</th>
                          <?php }?>
                          <th style="background-color:rgba(255,128,0,0.5);color:white;width:15px">Bénéfice pour la Division</th>
                          <th style="background-color:rgba(112,16,18,0.5);color:white;width:15px">Bénéfice pour la Harsh</th>
                          <th style="background-color:rgba(210,33,33,0.5);color:white;width:20px">Bénéfice total</th>
                        </tr>
                       </thead>
                       <?php
                       if ($_SESSION['grade'] == 'Harsh') { ?>
                         <?php
                          $rharsh = $bdd->query('SELECT * FROM harsh');
                          foreach($rharsh as $rharsh)
                          {
                            $totaldrogue = $rharsh['marijuana']+$rharsh['heroine']+$rharsh['cocaine']+$rharsh['speed'];
                              if ($rharsh['type'] == "Livrée dealer") {
                                $rprix = 8000;
                                $benefdiv = $rprix*$totaldrogue;
                              }
                              if ($rharsh['type'] == "Harsh aide la Division au transport") {
                                $rprix = 7500;
                                $benefdiv = $rprix*$totaldrogue;
                              }
                              if ($rharsh['type'] == "Directement Stocké") {
                                $rprix = 7000;
                                $benefdiv = $rprix*$totaldrogue;
                              }

                              $bene = $rharsh['bmarijuana']*$rharsh['marijuana']+$rharsh['bheroine']*$rharsh['heroine']+$rharsh['bcocaine']*$rharsh['cocaine']+$rharsh['bspeed']*$rharsh['speed'];
                              $benef = $bene*1.30;
                              $benefhar = $benef-$benefdiv;
                              $benef1 = number_format($benef, 0, ',', ' ');
                              $benefdiv1 = number_format($benefdiv, 0, ',', ' ');
                              $benefhar1 = number_format($benefhar, 0, ',', ' ');
                              echo "
                              <tr>
                                <td>".$rharsh['id']."</td>
                                <td>".$rharsh['date_p']."</td>
                                <td>".$rharsh['pseudo']."</td>
                                <td>".$rharsh['type']."</td>
                                <td>$rprix € </td>
                                <td>$totaldrogue</td>
                              ";
                              if($rharsh['marijuana'] == "")
                              {

                                  echo "<td>Non présente</td>";
                              }
                              else {
                                echo"<td>".$rharsh['marijuana']."</td>";
                              }
                              if($rharsh['heroine'] == "")
                              {

                                  echo "<td>Non présente</td>";
                              }
                              else {
                                echo"<td>".$rharsh['heroine']."</td>";
                              }
                              if($rharsh['cocaine'] == "")
                              {

                                  echo "<td>Non présente</td>";
                              }
                              else {
                                echo"<td>".$rharsh['cocaine']."</td>";
                              }
                              if($rharsh['speed'] == "")
                              {

                                  echo "<td>Non présente</td>";
                              }
                              else {
                                echo"<td>".$rharsh['speed']."</td>";
                              }


                              if($rharsh['bmarijuana'] == "")
                              {

                                  echo "<td>Pas vendu</td>";
                              }
                              else
                              {
                                echo"<td>".$rharsh['bmarijuana']."</td>";
                              }


                              if($rharsh['bheroine'] == "")
                              {

                                  echo "<td>Pas vendu</td>";
                              }
                              else
                              {
                                echo"<td>".$rharsh['bheroine']."</td>";
                              }


                              if($rharsh['bcocaine'] == "")
                              {

                                  echo "<td>Pas vendu</td>";
                              }
                              else
                              {
                                echo"<td>".$rharsh['bcocaine']."</td>";
                              }

                              if($rharsh['bspeed'] == "")
                              {

                                  echo "<td>Pas vendu</td>";
                              }
                              else
                              {
                                echo"<td>".$rharsh['bspeed']."</td>";
                              }
                              echo "
                                <td>$benefdiv1 €</td>
                                <td>$benefhar1 €</td>
                                <td>$benef1 €</td>
                              </tr>
                              ";
                          }

                          ?>
                       <?php }
                       else { ?>
                         <?php
                          $rharsh = $bdd->query('SELECT * FROM harsh');
                          foreach($rharsh as $rharsh)
                          {
                              $totaldrogue = $rharsh['marijuana']+$rharsh['heroine']+$rharsh['cocaine']+$rharsh['speed'];
                              if ($rharsh['type'] == "Livrée dealer") {
                                $rprix = 8000;
                                $benefdiv = $rprix*$totaldrogue;
                              }
                              if ($rharsh['type'] == "Harsh aide la Division au transport") {
                                $rprix = 7500;
                                $benefdiv = $rprix*$totaldrogue;
                              }
                              if ($rharsh['type'] == "Directement Stocké") {
                                $rprix = 7000;
                                $benefdiv = $rprix*$totaldrogue;
                              }
                              $bene = $rharsh['bmarijuana']*$rharsh['marijuana']+$rharsh['bheroine']*$rharsh['heroine']+$rharsh['bcocaine']*$rharsh['cocaine']+$rharsh['bspeed']*$rharsh['speed'];
                              $benef = $bene*1.30;
                              $benefhar = $benef-$benefdiv;
                              $benef1 = number_format($benef, 0, ',', ' ');
                              $benefdiv1 = number_format($benefdiv, 0, ',', ' ');
                              $benefhar1 = number_format($benefhar, 0, ',', ' ');
                              echo "
                              <tr>
                                <td>".$rharsh['id']."</td>
                                <td>".$rharsh['date_p']."</td>
                                <td>".$rharsh['pseudo']."</td>
                                <td>".$rharsh['type']."</td>
                                <td>$rprix € </td>
                                <td>$totaldrogue</td>
                              ";

                                if($rharsh['marijuana'] == "")
                                {

                                    echo "<td>Non présente</td>";
                                }
                                else {
                                  echo"<td>".$rharsh['marijuana']."</td>";
                                }
                                if($rharsh['heroine'] == "")
                                {

                                    echo "<td>Non présente</td>";
                                }
                                else {
                                  echo"<td>".$rharsh['heroine']."</td>";
                                }
                                if($rharsh['cocaine'] == "")
                                {

                                    echo "<td>Non présente</td>";
                                }
                                else {
                                  echo"<td>".$rharsh['cocaine']."</td>";
                                }
                                if($rharsh['speed'] == "")
                                {

                                    echo "<td>Non présente</td>";
                                }
                                else {
                                  echo"<td>".$rharsh['speed']."</td>";
                                }
                              echo"
                                <td>$benefdiv1 €</td>
                                <td>$benefhar1 €</td>
                                <td>$benef1 €</td>
                              </tr>
                              ";
                          }

                          ?>
                       <?php }?>


                     </table>
                   </div>
                 </div>
              </div>
            </div>
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
<?php } ?>
