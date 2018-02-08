<!DOCTYPE html>
<html>
<head>
  <title>Run command</title>
</head>
<body>

  <?php
  if ($_GET['run']) {
    # This code will run if ?run=true is set.
    exec("/root/run.sh");
  }
  if ($_GET['apache']) {
    # This code will run if ?run=true is set.
    exec("/root/apache.sh");
  }
  if ($_GET['mysql']) {
    # This code will run if ?run=true is set.
    exec("/root/mysql.sh");
  }
  if ($_GET['php']) {
    # This code will run if ?run=true is set.
    exec("/root/php.sh");
  }
  if ($_GET['supervisor']) {
    # This code will run if ?run=true is set.
    exec("/root/supervisor.sh");
  }
  if ($_GET['update']) {
    # This code will run if ?run=true is set.
    exec("/root/update.sh");
  }
  ?>

  <!-- This link will add ?run=true to your URL, myfilename.php?run=true -->
  <a href="?run=true" style="align:center;">Lancer L'installation</a>

</body>
</html>
