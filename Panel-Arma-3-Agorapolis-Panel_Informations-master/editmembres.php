<?php
require 'config.php';

    if ($_SESSION['grade'] !== 'Agent Representant'){ // ah non, pas eux !!!
      header('Location: membres.php'); // pas d'intrus sur cette photo
    } elseif(!isset($_SESSION['id'])){
      header('Location: index.php');
    }
    if ($_SESSION['grade'] == 'Harsh'){
    	header('Location: index.php');
    }
      if(isset($_POST['submit'])){
           if(!empty($_POST['grade']))
            {
              $id = htmlspecialchars(trim($_POST['id']));
              $statue = htmlspecialchars(trim($_POST['grade']));
              $UPDATEusers = $bdd->prepare("UPDATE users SET grade = ? WHERE id = ?");
              $UPDATEusers->execute(array($statue, $id));
              header('Location: membres.php');
            }
        else
        {
          header('Location: editmembres.php');
        }
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
			<h1>Edit la liste des membres</h1>
        <table class='table table-bordered' data-effect='fade'>
          <thead>
            <tr>
              <th style='width:15%'>Identité</th>
              <th style='width:15%'>Email</th>
              <th style='width:15%'>Surnom</th>
              <th style='width:15%'>Grade</th>
              <th style='width:15%'>Téléphone</th>
              <th style='width:15%'>Email</th>
              <th style='width:15%'>Modification</th>
            </tr>
          </thead>
      <?php
          $test = $bdd->query('SELECT * FROM users');
          foreach($test as $test)
          {
              echo"
              <form method='POST' class='row' action='editmembres.php'>
              <tbody>
                <tr>
                  <td>".$test['pseudo']."</td>
                  <td>".$test['email']."</td>
                  <td>".$test['surnom']."</td>
                  <td> Grade actuel : ".$test['grade']."</br></br>
                  <select name='grade' class='input-sm form-control'>
                      <option value='Agent Representant'>Agent Representant</option>
                      <option value='Agent Renegat'>Agent Renegat</option>
                      <option value='Agent'>Agent</option>
                      <option value='Inconnu'>Inconnu</option>
                  </select>
                  </td>
                  <th>".$test['telephone']."</td>
                  <th>".$test['email']."</td>
                  <input type='hidden' name='id' value=".$test['id']." />
                  <th style='width:15%;padding-left:20px'><button name='submit' class='btn btn-sm btn-primary link'>Appliquer</button></th>
                </tr>
              </tbody>
              </form>
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
