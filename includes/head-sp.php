<!DOCTYPE html>
<html lang="fr">

<?php
include_once('class/config.php');
?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="arthur touzard">
    <meta name="Copyright" content="arthur touzard">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="Content-Type" content="UTF-8">
    <meta name="Content-Language" content="fr">
    <meta name="Description" content="Site officiel du serveur Altis France. Osez une aventure fantastique sur le serveur de la meilleur communauté Française Altis Life.">
    <meta name="Keywords" content="Altis Life AltisLife AltisLifeFrance France RP RPG RolePlayingGame RolePlay Jeuderole Jeu de Role Arma3 Arma VideoGames JeuxVideos">
    <meta name="Subject" content="Altis Life">
    <meta name="Revisit-After" content="7 days">
    <meta name="Robots" content="all">
    <meta name="Rating" content="general">
    <meta name="Distribution" content="global">
    <meta name="Category" content="games">
    <link rel="icon" type="image/png" href="http://altisfrance.fr/img/favicon_af.png">

    <?php if(!isset($_GET['title'])) {
        echo "<title>Altis France - Communauté Altis Life</title>";
    } else {
        echo "<title>Altis France - {$_GET['title']}</title>";
    }
    ?>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="http://altisfrance.fr/cdn/css/bootstrap.min.css" type="text/css">

    <!-- Custom Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Quicksand:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Plugin CSS -->
    <link rel="stylesheet" href="http://altisfrance.fr/cdn/css/animate.min.css" type="text/css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="http://altisfrance.fr/cdn/css/creative.css" type="text/css">
    <link rel="stylesheet" href="http://altisfrance.fr/cdn/css/styles.css" type="text/css">
    <link rel="stylesheet" href="http://altisfrance.fr/cdn/css/sweetalert.css" type="text/css">

    <link href="http://altisfrance.fr/cdn/css/datepicker.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

    <script src="http://altisfrance.fr/cdn/js/datepicker.min.js"></script>
    <!-- Include English language -->
    <script src="http://altisfrance.fr/cdn/js/i18n/datepicker.en.js"></script>

    <!--SWEET ALERT-->
    <script src="http://altisfrance.fr/cdn/js/sweetalert.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top">