<?php

if($_GET['id']!=$_SESSION['admin_id'] and $_SESSION['admin_status']!=2) {
    echo "<script language=\"javascript\">";
    echo "window.location='dashboard.php?error=Tu n\'as pas accès à cette page';";
    echo "</script>";
}

if(isset($_GET['id'])) {
    $admin = Admin::byId($_GET['id']);
}else{
    $admin = null;
}

if(empty($admin)) {
    echo "<script language=\"javascript\">";
    echo "window.location='dashboard.php?error=Admin inexistant';";
    echo "</script>";
}

if(isset($_GET['error'])){
    $error = $_GET['error'];
}
if(isset($_GET['sucess'])){
    $success = $_GET['success'];
}

?>
<div id="page-wrapper">
    <?php
    if(!empty($_POST)){

        $post = [];
        foreach($_POST as $k => $data){
            $post[$k] = $data;
        }

        if($_SESSION['admin_status']==2) {
            $admin->status = $post['status'];
            $admin->active = $post['active'];
        }

        $password = $post['password'] == '' ? null : $post['password'];

        $admin->update($password);
        $success = 'Membre mis à jour';
    }
    ?>
    <div class="row">
        <div class="col-lg-12">
            <?php echo isset($error)?Tools::displayError($error):''; ?>
            <?php echo isset($success)?Tools::displaySuccess($success):''; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 page-header">
            <h1 class="inline-block m-0">Modification du STAFF : <?= $admin->login ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Informations du STAFF
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="player-infos" action="" method="post" role="form">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="login" class="label-form">Login :</label>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input id="login" type="text" name="login" class="form-control" value="<?= $admin->login ?>" disabled>
                                        </div>
                                    </div>
                                    <?php if($_SESSION['admin_status']==2){ ?>
                                    <div class="col-lg-6">
                                        <label for="status" class="label-form">status :</label>
                                        <div class="form-group">
                                            <select id="status" name="status" class="form-control">
                                                <?php
                                                    $selected = $admin->status==1 ? 'selected' : '';
                                                    $selected2 = $admin->status==2 ? 'selected' : '';
                                                    echo '<option value="1" '.$selected.'>Modérateur</option>';
                                                    echo '<option value="2" '.$selected2.'>Administrateur</option>';

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-lg-6">
                                        <label for="password" class="label-form">Password :</label>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <input id="password" type="password" name="password" class="form-control">
                                        </div>
                                    </div>
                                    <?php if($_SESSION['admin_status']==2){ ?>
                                    <div class="col-lg-6">
                                        <label for="active" class="label-form">active :</label>
                                        <div class="form-group">
                                            <select id="active" name="active" class="form-control">
                                                <?php
                                                $selected = $admin->active==1 ? 'selected' : '';
                                                echo '<option value="0" >Non</option>';
                                                echo '<option value="1" '.$selected.'>Oui</option>';

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    <div class="col-lg-6">
                                        <input class="btn btn-primary" type="submit" name="submit" value="ENVOYER">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
            </div>
            <!-- /.panel -->
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->