<?php

if(isset($_GET['error'])){
    $error = $_GET['error'];
}
if(isset($_GET['sucess'])){
    $success = $_GET['success'];
}

if(!empty($_POST) and $_SESSION['admin_status']!=2){
    echo "<script language=\"javascript\">";
    echo "window.location='dashboard.php?error=Tu peux pas faire ça mec, reste à ta place';";
    echo "</script>";
}

?>
<div id="page-wrapper">
    <?php if(!empty($_POST)){
        if(!Tools::formatPlayerid($_POST['playerid'])){
            $error = 'GUID incorrect';
        }elseif(Admin::byPlayerid($_POST['playerid'])) {
            $error = 'GUID déjà utiliser';
        }elseif(Admin::byLogin($_POST['login'])){
            $error = 'Login déjà utilisé';
        }elseif(Admin::byEmail($_POST['email'])){
            $error = 'Email déjà utilisé';
        }else{
            $admin = new Admin();
            $admin->login = $_POST['login'];
            $admin->email = $_POST['email'];
            $admin->playerid = $_POST['playerid'];
            $admin->status = $_POST['status'];
            $admin->active = 1;
            $admin->add($_POST['password']);
            $success = "Membre ajouté";
        }
    }?>
    <div class="row">
        <div class="col-lg-12">
            <?php echo isset($error)?Tools::displayError($error):''; ?>
            <?php echo isset($success)?Tools::displaySuccess($success):''; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 page-header">
            <h1 class="inline-block m-0">Liste des membres du STAFF</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTables-players">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>GUID</th>
                        <th>Email</th>
                        <th>Rank</th>
                        <th>active</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $admins = Admin::getAll();
                    foreach($admins as $admin){ ?>
                        <tr data-id="<?php echo $admin->id ?>">
                            <td><?= $admin->login; ?></td>
                            <td><?= $admin->playerid; ?></td>
                            <td><?= $admin->email; ?></td>
                            <td class="text-right"><?= $admin->status; ?></td>
                            <td class="text-right"><?= $admin->active; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <?php if($_SESSION['admin_status']==2){ ?>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Ajouter un nouveau STAFF
                </div>
                <div class="panel-body">
                    <form action="" method="post">
                        <div class="col-lg-6">
                            <label for="login" class="label-form">Login :</label>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input id="login" type="text" name="login" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="email" class="label-form">Email :</label>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input id="bankacc" type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="playerid" class="label-form">GUID :</label>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-hashtag"></i></span>
                                <input id="playerid" type="number" name="playerid" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="password" class="label-form">Password :</label>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input id="password" type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <label for="status" class="label-form">Admin level :</label>
                            <div class="form-group">
                                <select id="status" name="status" class="form-control">
                                    <option value="1">Modérateur</option>
                                    <option value="2">Administrateur</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <input type="submit" class="btn btn-primary" name="submit" value="ENVOYER">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php } ?>
</div>
<!-- /#page-wrapper -->
<script>
    $('#dataTables-players').DataTable({
        responsive: true,
        order:[[3,'desc']]
    });
    $('tbody tr').click(function(){
        window.location.replace('admin.php?id='+$(this).data('id'));
    });
</script>
