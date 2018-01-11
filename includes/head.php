<!DOCTYPE html>

<?php
//error_reporting(0);

session_start();

if (!isset($_SESSION['admin_id'])) {
    echo "<script language=\"javascript\">";
    echo "window.location.replace('http://admin.altisfrance.Fr/');";
    echo "</script>";
    exit();
}
require_once('class/config.php');

$admin = Admin::byId($_SESSION['admin_id']);

if ($admin->status==0) {
    echo "<script language=\"javascript\">";
    echo "window.location.replace('http://admin.altisfrance.Fr/');";
    echo "</script>";
    exit();
}
?>

<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex,nofollow">
    <?php if(Notification::newNotifs($admin->id)>0) {
        echo '<link rel="icon" type="image/png" href="http://altisfrance.fr/img/favicon_admin.png">';
    }else{
        echo '<link rel="icon" type="image/png" href="http://altisfrance.fr/img/favicon_af.png">';
    }?>
    <title>AltisFrance - Panel Admin</title>

    <script>
        var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        if( isMobile ) {
            $('head').append('<link rel="stylesheet" href="/css/mobile.css?v=2.3" type="text/css" />');
        }
    </script>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
<!--    <link href="bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">-->

    <!-- Timeline CSS -->
    <link href="dist/css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="http://altisfrance.fr/cdn/css/styles.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="bower_components/morrisjs/morris.css" rel="stylesheet">

    <!-- CSS file -->
    <link rel="stylesheet" href="http://altisfrance.fr/cdn/css/easy-autocomplete.min.css">

    <!-- Custom Fonts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

    <!-- JS file -->
    <script src="http://altisfrance.fr/cdn/js/jquery.easy-autocomplete.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="http://cdn.oesmith.co.uk/morris-0.4.1.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

</head>

<body>
