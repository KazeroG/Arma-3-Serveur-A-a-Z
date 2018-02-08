<?php
require "../config.php";
require_once '../configuration.fonction.php';


if(isset($_GET['id']) AND !empty($_GET['id'])) {
   $get_id = htmlspecialchars($_GET['id']);
   $news = $bdd->prepare('SELECT * FROM news WHERE id = ?');
   $news->execute(array($get_id));
   if($news->rowCount() == 1) {
      $news = $news->fetch();
      $titre = $news['titre'];
      $contenu = $news['contenu'];
      $date_i = $news['date_p'];
      $auteur = $news['auteur'];
   } else {
      header("Location: index.php");
   }
} else {

   header("Location: index.php");
   exit(); // Si vous vous diriger sur news.php directement, vous pouvez évidemment mettre ce que vous voulez, mais je préfère faire une redirection.
}

 ?>
 <!DOCTYPE html>
 <html >
 <head>
   <meta charset="UTF-8">
   <title>News - La Division</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
   <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'>
   <link rel="stylesheet" href="css/style1.css">
   <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
   <link rel="icon" href="../favicon.ico" type="image/x-icon">
   <script src="//fast.eager.io/PQWTEM3XZ4.js"></script>
   <script type="text/javascript">
   function ImageMax(chemin) {
html='<html> <head> <title>Titre</title> </head> <body bgcolor=black><IMG src="'+chemin+'" BORDER=0 NAME=ImageMax onLoad="window.resizeTo(document.ImageMax.width+40, document.ImageMax.height+60)"></body></html>';
popupImage = window.open('','_blank','toolbar=0, location=0, directories=0, menuBar=0, scrollbars=0, resizable=1');
popupImage.document.open();
popupImage.document.write(html);
popupImage.document.close()
};
   </script>
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

              <h2 align="center" style="font-size:30px;font-weight:bold;"><?= $news['titre']; ?></h2></br>
              <div class="divider"><span></span></div>
              <div class="contenu"><p><?= $news['contenu']; ?>
              </p> </div>
              <div class="date">
              Publié le <?= $news['date_p']; ?>
              </div>

    </div>

  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
  <script src="js/index.js"></script>
  <!-- //HRP// Développé entièrement par Erwan Wiks | TheChypsis Copyright -->
</body>
</html>
