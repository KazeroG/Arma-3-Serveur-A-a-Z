<?php
session_start();
include_once('class/config.php');

if(isset($_GET['action']) && $_GET['action']=='logout'){
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_status']);
    unset($_SESSION['admin_pid']);
}

if(isset($_SESSION['admin_id'])){
    echo "<script language=\"javascript\">";
    echo "window.location='dashboard.php';";
    echo "</script>";
}

if(isset($_POST['submit'])){
    $admin = ADMIN::byLogin($_POST['login']);
    if(isset($admin) and $admin->active){
        $reponse = $admin->signin($_POST["password"]);
        if($reponse['signin']=='1'){
            $_SESSION['admin_id'] = $admin->id;
            $_SESSION['admin_status'] = $admin->status;
            $_SESSION['admin_pid'] = $admin->playerid;
            header('Location:dashboard.php');
        }else{
            $error = "Erreur : Mdp incorrect";
        }
    }else{
        $error = "Erreur : Login incorrect ou inactive";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="robots" content="noindex,nofollow">
    <link rel="icon" type="image/png" href="http://altisfrance.fr/img/favicon_af.png">

    <title>AltisFrance - Panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <link href="http://altisfrance.fr/cdn/css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div class="login-bg"></div>
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Panel AltisFrance - Login</h3>
                </div>
                <div class="panel-body">
                    <form method="post" action="" role="form">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Login" name="login" type="text" required autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" required value="">
                            </div>
                            <input type="submit" name="submit" class="btn btn-lg btn-success btn-block" value="Login">
                        </fieldset>
                    </form>
                </div>
            </div>
            <?php if(isset($error)) echo "<div class=\"alert alert-danger\">{$error}</div>"; ?>
        </div>
    </div>
</div>
