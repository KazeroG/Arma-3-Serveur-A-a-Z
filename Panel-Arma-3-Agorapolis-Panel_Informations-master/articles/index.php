<?php
require '../config.php';
 ?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>News - La Division</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
  <link rel='stylesheet prefetch' href='https://fonts.googleapis.com/css?family=Quicksand'>
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
  <link rel="icon" href="../favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" sizes="120x120" href="../apple-touch-icon-120x120-precomposed.png" />
  <link rel="apple-touch-icon" sizes="152x152" href="../apple-touch-icon-152x152-precomposed.png" />
  <script src="//fast.eager.io/PQWTEM3XZ4.js"></script>
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-87710084-1', 'auto');
  ga('send', 'pageview');

</script>
</head>

<body>

  <div id="news">
    <div id="header">
        <center><a href="https://la-division-france.eu" class="img"><img src="image/logo.png" style="max-height:200px;max-width:200px"/></a></center>
        <h1>Journal Officiel</h1></br>
        <p>Les dernières news de la Division
    </div>
    <a href="https://la-division-france.eu/articles/"><div id="menu"></div></a>
    <div id="content">
      <!--<marquee direction="up" height="50px" width="1000px" scrollamount="1" onmouseover="this.stop();" onmouseout="this.start();">
        <ul class="ticker-up">
          <li>D'après nos dernières nouvelles, les postiches résideraient dans les poubelles de Pyrgos.</li>
          <li>------------------------------------------------------------------------</li>
          <li>La banque nationnale n'a pas été attaqué depuis plus de 2 semaines.</li>
          <li>------------------------------------------------------------------------</li>
          <li>La Division oeuvre au quotidien pour les citoyens de Pyrgos</li>
          <li>------------------------------------------------------------------------</li>
        </ul>
      </marquee>
    </br></br>-->










    <div id="main">
      <?php
      $news1 = $bdd->query('SELECT * FROM news ORDER BY id DESC LIMIT 6');
      foreach($news1 as $news1)
      {
      echo"<div id='box'><a href='articles?id=".$news1['id']."' class='img'><img src='".$news1['img']."'/></a></div>";
      }
      ?>
    </div>

    <div id="article">
      <?php
      $news1 = $bdd->query('SELECT * FROM news ORDER BY id DESC LIMIT 6');
      foreach($news1 as $news1)
      {
      echo"
      <div id='articles'>
        <div class='desc'>
          ".$news1['titre']."
        </div>
        <div class='desc1'>
        <br>
            <a style='text-align:center;' href='articles?id=".$news1['id']."'><i class='fa fa-arrow-right'></i> Accéder à l'article <i class='fa fa-arrow-left'></i></a>
        </div>
        </br></br>
        <div class='date'>
          <i class='fa fa-pencil'></i> Posté le ".$news1['date_p']."
        </div>
      </div>
      ";
      }
      ?>
    </div>

    <div id="side">
      <h2 class="video">Nos dernières revendications</h2>
      <div class="divider"><span></span></div>
      <?php
      $drevendication = $bdd->query('SELECT * FROM revendication ORDER BY id DESC LIMIT 5');
      foreach($drevendication as $drevendication)
      {
        echo"
      <div id='sidecontent2' class='cf'><span><iframe width='305' height='210' src='https://www.youtube.com/embed/".$drevendication['video']."' frameborder='0' allowfullscreen></iframe></span></div>
        ";
      }
      ?>
    </div>
  </div>
  <div id="footer" class="cf"></br>© Copyright La Division 2022 </div>
</div>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
  <script src="js/index.js"></script>
<!-- //HRP// Développé entièrement par Erwan Wiks | TheChypsis Copyright -->
</body>
</html>
