<?php
require "config.php";
if ($_SESSION['grade'] == 'Inconnu'){ // ah non, pas eux !!!
  header('Location: exit.php'); // pas d'intrus sur cette photo
} elseif(!isset($_SESSION['id'])){
  header('Location: login.php');
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
			<h1>Liste des personnes rencontrés : </h1>
      <div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
               <div class="panel-heading">Table des rencontres</div>
               <div class="panel-footer">
                  <div class="row">
                     <div class="col-lg-2">
                        <input type="search" placeholder="Recherche"  data-table="order-table" class="input-sm form-control light-table-filter">
                     </div>
                  </div>
               </div>
               <div class="panel-wrapper collapse in" style=""><div class="table-responsive">
                 <table class="order-table table table-bordered table-hover">
                   <thead>
                      <tr>
                         <th style="width: 3%">#</th>
                         <th style="width: 20%">Carte d'identité</th>
                         <th style="width: 8%">Date de rencontre</th>
                         <th style="width: 8%">Agent qui l'a rencontré</th>
                         <th>Statue</th>
                         <th style="width: 10%">Identité</th>
                         <th style="width: 5%">Téléphone</th>
                         <th style="width: 5%">Dangerosité</th>
                         <th style="width: 30%">Informations</th>
                         <th style="width: 10%">Point de vue</th>
                      </tr>
                   </thead>
                   <tbody>
                     <?php
                      $rrencontre = $bdd->query('SELECT * FROM rencontre');
                      foreach($rrencontre as $rrencontre)
                      {
                        if ($_SESSION['grade'] == 'Harsh') {
                          echo "
                          <tr>
                             <td align='center'>".$rrencontre['id']."</td>
                             <td align='center'>
                             <div class='panel-group' id='accordion'>
                                 <div class='panel panel-default'>
                                 ";


                                 if($rrencontre['carte'] == "http://image.noelshack.com/fichiers/2016/47/1480012595-carte-identite.png")
                                 {
                                   echo " <div class='panel-heading' style='background-color:#830a0a'> ";
                                 }
                                 else
                                 {
                                   echo " <div class='panel-heading' style='background-color:#356821'> ";
                                 }


                          echo"
                                     <h4 class='panel-title'>
                                       <a data-toggle='collapse' data-parent='#accordion' data-no-instant href='#collapse".$rrencontre['id']."'>Carte d'identité</a>
                                     </h4>
                                   </div>
                                   <div id='collapse".$rrencontre['id']."' class='panel-collapse collapse'>
                                     <div class='panel-body'>
                                     <img src='".$rrencontre['carte']."'/>
                                     </div>
                                   </div>
                                 </div>
                               </div>
                             </td>
                             <td align='center'>".$rrencontre['date']."</td>
                             <td align='center'>La Division</td>
                             <td align='center' class='".$rrencontre['statue']."'>".$rrencontre['statue']."</td>
                             <td align='center'>".$rrencontre['identite']."</td>
                             ";
                             if($rrencontre['telephone'] == "/")
                             {

                                 echo "<td>Non connu</td>";
                             }
                             else {
                               echo"<td align='center'>".$rrencontre['telephone']."</td>";
                             }
                             echo "
                             <td align='center' class='".$rrencontre['dangerosite']."'>".$rrencontre['dangerosite']."</td>
                             ";
                             if($rrencontre['informations'] == "/")
                             {

                                 echo "<td>Aucune information</td>";
                             }
                             else {
                               echo"<td align='center'>".$rrencontre['informations']."</td>";
                             }
                             echo "
                             ";
                             if($rrencontre['pdv'] == "/")
                             {

                                 echo "<td>Pas de point de vue</td>";
                             }
                             else {
                               echo"<td align='center'>".$rrencontre['pdv']."</td>";
                             }
                             echo "
                          </tr>
                          ";
                        }
                        else {
                          echo "
                          <tr>
                             <td align='center'>".$rrencontre['id']."</td>
                             <td align='center'>
                             <div class='panel-group' id='accordion'>
                                 <div class='panel panel-default'>";


                                 if($rrencontre['carte'] == "http://image.noelshack.com/fichiers/2016/47/1480012595-carte-identite.png")
                                 {
                                   echo " <div class='panel-heading' style='background-color:#830a0a'> ";
                                 }
                                 else
                                 {
                                   echo " <div class='panel-heading' style='background-color:#356821'> ";
                                 }


                          echo"
                                     <h4 class='panel-title'>
                                       <a data-toggle='collapse' data-parent='#accordion' data-no-instant href='#collapse".$rrencontre['id']."'>Carte d'identité</a>
                                     </h4>
                                   </div>
                                   <div id='collapse".$rrencontre['id']."' class='panel-collapse collapse'>
                                     <div class='panel-body'>
                                     <img src='".$rrencontre['carte']."'/>
                                     </div>
                                   </div>
                                 </div>
                               </div>
                             </td>
                             <td align='center'>".$rrencontre['date']."</td>
                             <td align='center'>".$rrencontre['pseudo']."</td>
                             <td align='center' class='".$rrencontre['statue']."'>".$rrencontre['statue']."</td>
                             <td align='center'>".$rrencontre['identite']."</td>
                             ";
                             if($rrencontre['telephone'] == "/")
                             {

                                 echo "<td>Non connu</td>";
                             }
                             else {
                               echo"<td align='center'>".$rrencontre['telephone']."</td>";
                             }
                             echo "
                             <td align='center' class='".$rrencontre['dangerosite']."'>".$rrencontre['dangerosite']."</td>
                             ";
                             if($rrencontre['informations'] == "/")
                             {

                                 echo "<td>Aucune information</td>";
                             }
                             else {
                               echo"<td align='center'>".$rrencontre['informations']."</td>";
                             }
                             echo "
                             ";
                             if($rrencontre['pdv'] == "/")
                             {

                                 echo "<td>Pas de point de vue</td>";
                             }
                             else {
                               echo"<td align='center'>".$rrencontre['pdv']."</td>";
                             }
                             echo "
                          </tr>
                          ";
                        }
                      }

                      ?>
                   </tbody>
                 </table>
               </div>

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
