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
			<h1>Listes des membres</h1>
      <table class='table table-bordered' data-effect="fade">
      <thead>
        <tr>
          <th style="width:15%">Identité</th>
          <th style="width:15%">Surnom</th>
          <th style="width:15%">Grade</th>
          <th style="width:15%">Téléphone</th>
          <th style="width:15%">Identité à donnée</th>
        </tr>
      </thead>
      <?php
       $liste = $bdd->query('SELECT * FROM users ORDER BY grade');
       foreach($liste as $liste)
       if(isset($_SESSION['id']) AND $_SESSION['grade'] == 'Agent Representant') {
       {
         echo "
         <tbody>
           <tr>
             <td>".$liste['pseudo']."</td>
             <td>".$liste['surnom']."</td>
             <td>".$liste['grade']."</td>
             <td>".$liste['telephone']."</td>
             <td>".$liste['surnom2']."</td>
           </tr>
         </tbody>

         ";
       }
       }
       elseif (isset($_SESSION['id']) AND $_SESSION['grade'] == 'Agent Divisionnaire') {
         echo "
         <tbody>
           <tr>
           <td>".$liste['pseudo']."</td>
           <td>".$liste['surnom']."</td>
           <td>".$liste['grade']."</td>
           <td>".$liste['telephone']."</td>
           <td>".$liste['surnom2']."</td>
           </tr>
         </tbody>

         ";
       }
       else {
         echo "

         <tbody>
           <tr>
             <td>Information non disponible</td>
             <td>".$liste['surnom']."</td>
             <td>".$liste['grade']."</td>
             <td>".$liste['telephone']."</td>
             <td>".$liste['surnom2']."</td>
           </tr>
         </tbody>

         ";
       }
       ?>
       </table>
    </div>
	</main>
<script src="js/jquery-2.1.4.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/main.js"></script>
<script src="js/bootstrap.min.js" ></script>
</body>
</html>
