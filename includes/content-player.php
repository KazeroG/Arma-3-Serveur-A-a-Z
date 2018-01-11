<?php

if(isset($_GET['playerid'])) {
    $player = Player::byPlayerid($_GET['playerid']);
}else{
    $player = null;
}
$admin = Admin::byId($_SESSION['admin_id']);
$perm_admin = $_SESSION['admin_status']==2 ? '' : 'disabled';
$perm_modo = $_SESSION['admin_status']>=1 ? '' : 'disabled';

if(empty($player)) {
    echo "<script language=\"javascript\">";
    echo "window.location='dashboard.php?error=Joueur inexistant';";
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
        if($admin->status<1){
            $error = "Vous n'êtes pas staff, bien essayé";
        }else{

            $post = [];
            foreach($_POST as $k => $data){
                $post[$k] = $data;
            }
            if((isset($post['adminlevel']) or isset($post['donatorlvl'])) and $admin->status<2){
                $error = "Vous n'êtes pas Admin, mais bien essayé";
            }else{

                if ($player->cash != $post['cash'] or $player->bankacc != $post['bankacc']) {
                    $log = date('Y-m-d H:i:s', time()) . " - Money give : " . $admin->login . " to " . $player->name . "(" . $player->playerid . ") = cash " . ($post['cash']-$player->cash) . " / bank " . ($post['bankacc']-$player->bankacc) . "\n";
                    error_log($log, 3, "logs/give.log");
                }

                foreach ($post as $prop => $value) {
                    $player->$prop = $value;
                }

                $player->update();

                $success = 'Joueur bien modifié';
            }
        }
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
            <h1 class="inline-block m-0">Modification du joueur : <?= $player->name ?></h1> <button id="submit-form" type="button" name="submit" class="float-right btn btn-primary btn-lg">Enregistrer</button>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div data-target="ticketPanel" data-open="1" class="panel-heading pointer">
                    Tickets du joueur
                </div>
                <div id="ticketPanel">
                    <?php
                    if($tickets = Ticket::byPlayerId($player->playerid)) {
                        foreach ($tickets as $t) { ?>
                            <div class="ptb-10 plr-15">
                                <a target="_blank" href="ticket.php?id=<?= $t->id ?>"><span><?= date("Y-m-d H\hi",strtotime($t->date)) . ' : ' . $t->type ?></span></a>
                                <?php echo $t->status ? '<span class="mlr-5 float-right label label-success">OUVERT</span>':'<span class="mlr-5 float-right label label-danger">FERMÉ</span>'; ?>
                            </div>
                        <?php }
                    }else{ echo '<div class="ptb-10 plr-15"><span>Aucuns tickets pour ce joueurs</span></div>'; }?>
                </div>
            </div>

            <div class="panel panel-default">
                <div data-target="infosPanel" data-open="1" class="panel-heading pointer">
                    Informations du joueur
                </div>
                <div id="infosPanel" class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="player-infos" action="" method="post" role="form">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="playerid" class="label-form">GUID Joueur :</label>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input id="playerid" type="text" name="playerid" class="form-control" value="<?= $player->playerid ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="adminlevel" class="label-form">Admin level :</label>
                                        <div class="form-group">
                                            <select id="adminlevel" name="adminlevel" class="form-control" <?= $perm_admin ?>>
                                                <option value="0">0</option>
                                                <?php
                                                    for($i=1;$i<=5;$i++){
                                                        $selected = $i==$player->adminlevel ? 'selected' : '';
                                                        echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="cash" class="label-form">Cash :</label>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                            <input id="cash" type="number" name="cash" class="form-control" value="<?= $player->cash ?>" <?= $perm_modo ?>>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="bankacc" class="label-form">Banque :</label>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                            <input id="bankacc" type="number" name="bankacc" class="form-control" value="<?= $player->bankacc ?>" <?= $perm_modo ?>>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="coplevel" class="label-form">Cop level :</label>
                                        <div class="form-group">
                                            <select name="coplevel" class="form-control" <?= $perm_modo ?>>
                                                <option value="0">N/A</option>
                                                <?php
                                                for($i=1;$i<=11;$i++){
                                                    $selected = $i==$player->coplevel ? 'selected' : '';
                                                    $rank = Player::displayCopLevel($i);
                                                    echo '<option value="'.$i.'" '.$selected.'>'.$rank.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="mediclevel" class="label-form">Med level :</label>
                                        <div class="form-group">
                                            <select id="mediclevel" name="mediclevel" class="form-control" <?= $perm_modo ?>>
                                                <option value="0">N/A</option>
                                                <?php
                                                for($i=1;$i<=3;$i++){
                                                    $selected = $i==$player->mediclevel ? 'selected' : '';
                                                    echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="donatorlvl" class="label-form">Donateur :</label>
                                        <div class="form-group">
                                            <select id="donatorlvl" name="donatorlvl" class="form-control" <?= $perm_admin ?>>
                                                <?php
                                                $selected = $player->donatorlvl ? 'selected' : '';
                                                echo '<option value="0">Non</option>';
                                                echo '<option value="1" '.$selected.'>Oui</option>';
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="playerid" class="label-form">GUID Parrain :</label>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input id="playerid" type="text" class="form-control" value="<?= $player->sponsor ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="civ_gear">Civ gear</label>
                                            <textarea id="civ_gear" name="civ_gear" class="form-control" rows="5" <?= $perm_modo ?>><?= $player->civ_gear ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="cop_gear">Cop gear</label>
                                            <textarea id="cop_gear" name="cop_gear" class="form-control" rows="5" <?= $perm_modo ?>><?= $player->cop_gear ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="med_gear">Med gear</label>
                                            <textarea id="med_gear" name="med_gear" class="form-control" rows="5" <?= $perm_modo ?>><?= $player->med_gear ?></textarea>
                                        </div>
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

            <div class="panel panel-default">
                <div data-target="sponsoredPanel" data-open="0" class="panel-heading pointer" style="background-color: #dbdbdb">
                    Filleuls : <?= count($player->getSponsoredPlayer()) ?>
                </div>
                <div id="sponsoredPanel" class="display-none">
                    <?php
                    $sponsored = $player->getSponsoredPlayer();
                    foreach($sponsored as $p){ ?>
                        <div class="ptb-10 plr-15">
                            <a href="player.php?playerid=<?= $p->playerid." \">".$p->name." : ".$p->playerid; ?></a>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="panel panel-default">
                <div data-target="garagePanel" data-open="1" class="panel-heading pointer">
                    Garage du joueur
                </div>
                <div id="garagePanel">
                <?php
                $vehicles = Vehicles::byPlayerId($player->playerid);
                foreach($vehicles as $v){ ?>
                    <div class="ptb-10 plr-15">
                        <span><?= $v->classname ?></span>
                        <?php if($_SESSION['admin_status']==2){ echo "<span data-id=\"{$v->id}\" class=\"delVehicle mlr-5 pointer float-right label label-danger\">X</span>"; } ?>
                        <?php echo $v->alive ? "<span data-id=\"{$v->id}\" data-status=\"{$v->alive}\" class=\"toggle-alive mlr-5 pointer float-right label label-success\">ALIVE</span>" : "<span data-id=\"{$v->id}\" data-status=\"{$v->alive}\" class=\"toggle-alive mlr-5 pointer float-right label label-warning\">DEAD</span>" ?>
                        <?php echo $v->insure ? "<span data-id=\"{$v->id}\" data-status=\"{$v->insure}\" class=\"toggle-insure mlr-5 pointer float-right label label-info\">INSURED</span>" : "<span data-id=\"{$v->id}\" data-status=\"{$v->insure}\" class=\"toggle-insure mlr-5 pointer float-right label label-warning\">NOT INSURED</span>" ?>
                        <?php if($v->active){ ?>
                            <span class="mlr-5 float-right label label-success">active</span>
                        <?php } ?>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">

            <div class="panel panel-default">
                <div data-target="sanctionsPanel" data-open="1" class="panel-heading pointer">
                    Reports
                </div>
                <div id="sanctionsPanel" class="panel-body">
                    <?php
                    if($sanctions = Sanction::byPlayerId($player->playerid)) {
                        foreach ($sanctions as $s) {
                        if($s->type==2){ $class = 'label-danger'; }
                        elseif($s->type==1){ $class = 'label-warning'; }
                        else{ $class = 'label-success'; }
                        $author = Admin::byPlayerid($s->author);
                    ?>
                            <div class="panel panel-default mb-10">
                                <div data-target="sanction-<?= $s->id ?>" data-open="0" class="panel-heading pointer">
                                    <h4 class="panel-title">
                                        <?= date("Y-m-d H\hi",strtotime($s->date)).' : '.$s->sanction.' ('.$author->login.')' ?>
                                        <?php if($s->type>=1) echo "<span class=\"mlr-5 float-right label $class\">".$s->displayType()."</span>"; ?>
                                    </h4>
                                </div>
                                <div id="sanction-<?= $s->id ?>" class="panel-collapse collapse" aria-expanded="false">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-xs-11">
                                                <?= $s->description ?>
                                            </div>
                                            <div class="col-xs-1">
                                                <?php if($s->ticket) echo "<a href=\"ticket.php?id=$s->ticket\"><i class=\"fa fa-link\"></i></a>"; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }?>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#addSanction"><i class="fa fa-gavel"></i> Add report</button>
                </div>
            </div>

            <div class="panel panel-default">
                <div data-target="licPanel" data-open="1" class="panel-heading pointer">
                    Licenses
                </div>
                <div id="licPanel" class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs mb-10">
                                <li class="active"><a href="#civ" data-toggle="tab">Civ</a></li>
                                <li><a href="#cop" data-toggle="tab">Cop</a></li>
                                <li><a href="#medic" data-toggle="tab">Medic</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="civ">
                                    <?php
                                    $arrayLicenses = Tools::decodeLicenses($player->civ_licenses);
                                    if(!empty($arrayLicenses[0])) {
                                        $totarrayLicenses = count($arrayLicenses);
                                        $y = 0;
                                        $n = 0;

                                        for ($i = 1; $y < $totarrayLicenses; $i++) {
                                            ?>
                                            <div style="margin-top:5px;width:100%;">
                                                <div class="input-group">
                                                    <input type="text" disabled class="form-control"
                                                           placeholder="<?php echo $arrayLicenses[$y]; ?>">

                                                    <div class="input-group-btn">
                                                    <span class="input-group-btn">
                                                    <?php
                                                    if ($arrayLicenses[$i] == 1) {
                                                        echo '<button data-status="' . $arrayLicenses[$i] . '" data-id="' . $n . '" data-side="civ" style="width:90px;" class="addLic btn btn-danger" type="button">Retirer</button>';
                                                    } else {
                                                        echo '<button data-status="' . $arrayLicenses[$i] . '" data-id="' . $n . '" data-side="civ" style="width:90px;" class="addLic btn btn-default" type="button">Ajouter</button>';
                                                    }
                                                    ?>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            // Pair
                                            $y = $y + 2;
                                            // Impair
                                            $i = $i + 1;
                                            // normal
                                            $n = $n + 1;
                                        }
                                    }else{ echo 'Aucunes licenses'; }?>
                                </div>
                                <div class="tab-pane fade" id="cop">
                                    <?php
                                    $arrayLicenses = Tools::decodeLicenses($player->cop_licenses);
                                    if(!empty($arrayLicenses[0])) {
                                        $totarrayLicenses = count($arrayLicenses);
                                        $y=0;
                                        $n=0;

                                        for($i=1; $y < $totarrayLicenses; $i++){
                                            ?>
                                            <div style="margin-top:5px;width:100%;">
                                                <div class="input-group">
                                                    <input type="text" disabled class="form-control" placeholder="<?php echo $arrayLicenses[$y];?>">
                                                    <div class="input-group-btn">
                                                        <span class="input-group-btn">
                                                        <?php
                                                        if($arrayLicenses[$i] == 1){
                                                            echo '<button data-status="'.$arrayLicenses[$i].'" data-id="'.$n.'" data-side="cop" style="width:90px;" class="addLic btn btn-danger" type="button">Retirer</button>';
                                                        }else{
                                                            echo '<button data-status="'.$arrayLicenses[$i].'" data-id="'.$n.'" data-side="cop" style="width:90px;" class="addLic btn btn-default" type="button">Ajouter</button>';
                                                        }
                                                        ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            // Pair
                                            $y=$y+2;
                                            // Impair
                                            $i=$i+1;
                                            // normal
                                            $n=$n+1;
                                        }
                                    }else{ echo 'Aucune licenses'; } ?>
                                </div>
                                <div class="tab-pane fade" id="medic">
                                    <?php
                                    $arrayLicenses = Tools::decodeLicenses($player->med_licenses);
                                    if(!empty($arrayLicenses[0])) {
                                        $totarrayLicenses = count($arrayLicenses);
                                        $y = 0;
                                        $n = 0;

                                        for ($i = 1; $y < $totarrayLicenses; $i++) {
                                            ?>
                                            <div style="margin-top:5px;width:100%;">
                                                <div class="input-group">
                                                    <input type="text" disabled class="form-control"
                                                           placeholder="<?php echo $arrayLicenses[$y]; ?>">

                                                    <div class="input-group-btn">
                                                    <span class="input-group-btn">
                                                    <?php
                                                    if ($arrayLicenses[$i] == 1) {
                                                        echo '<button data-status="' . $arrayLicenses[$i] . '" data-id="' . $n . '" data-side="med" style="width:90px;" class="addLic btn btn-danger" type="button">Retirer</button>';
                                                    } else {
                                                        echo '<button data-status="' . $arrayLicenses[$i] . '" data-id="' . $n . '" data-side="med" style="width:90px;" class="addLic btn btn-default" type="button">Ajouter</button>';
                                                    }
                                                    ?>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            // Pair
                                            $y = $y + 2;
                                            // Impair
                                            $i = $i + 1;
                                            // normal
                                            $n = $n + 1;
                                        }
                                    }else{ echo 'Aucune licenses'; }?>
                                </div>
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<!-- Modal -->
<div class="modal fade" id="addSanction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Ajouter sanction</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <label for="sanction" class="label-form">Sanction :</label>
                        <div class="form-group input-group">
                            <span class="input-group-addon"><i class="fa fa-gavel"></i></span>
                            <input id="sanction" type="text" name="sanction" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="type" class="label-form">Type :</label>
                        <div class="form-group">
                            <select id="type" name="type" class="form-control" required>
                                <option value="0">R.A.S</option>
                                <option value="1">Averto</option>
                                <option value="2">Ban</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Description :</label>
                            <textarea id="description" name="description" class="form-control" rows="5" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Anuler</button>
                <button id="sanction-submit" type="button" class="btn btn-danger">Envoyer</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#side-menu').metisMenu();

    $(document).ready( function () {
        $("#submit-form").click(function(){
            $("#player-infos").submit();
        });

        $(".addLic").click(function(){
            var obj = $(this);
            var status = obj.data("status");
            var id = obj.data("id");
            var side = obj.data("side");
            var playerid = '<?= $player->playerid ?>';
            var html = '';
            console.log(status);
            $.getJSON('/ajaxqueries.php', {
                query: 'updateLic',
                status: status,
                id: id,
                playerid: playerid,
                side: side
            }).done(function(data){
                console.log(data);
                if(data['ok']){
                    if(obj.data("status") == '1'){
                        html = 'Ajouter';
                        obj.html('').html(html).css('color','#333').css('background-color','#fff').css('border-color','#ccc').data('status',0);
                    }else{
                        html = 'Retirer';
                        obj.html('').html(html).css('color','#fff').css('background-color','#d9534f').css('border-color','#d43f3a').data('status',1);
                    }
                }else{

                }
            });
        });

        $(".toggle-alive").click(function(){
            var obj = $(this);
            $.getJSON('/ajaxqueries.php', {
                query: 'toggleAliveVehicle',
                id: obj.data("id")
            }).done(function(data){
                if(obj.data("status") == '1'){
                    html = 'DEAD';
                    obj.html('').html(html).css('background-color','#f0ad4e').data('status',0);
                }else{
                    html = 'ALIVE';
                    obj.html('').html(html).css('background-color','#5cb85c').data('status',1);
                }
            }).error(function(){
                alert("Tu ne peux pas faire ça !");
            });
        });
        $(".toggle-insure").click(function(){
            var obj = $(this);
            $.getJSON('/ajaxqueries.php', {
                query: 'toggleInsureVehicle',
                id: obj.data("id")
            }).done(function(data){
                if(obj.data("status") == '1'){
                    html = 'NOT INSURED';
                    obj.html('').html(html).css('background-color','#f0ad4e').data('status',0);
                }else{
                    html = 'INSURED';
                    obj.html('').html(html).css('background-color','#5bc0de').data('status',1);
                }
            }).error(function(){
                alert("Tu ne peux pas faire ça !");
            });
        });

        $(".delVehicle").click(function(){
            var obj = $(this);
            var r = confirm("Êtes vous bien sûr de supprimer ce véhicule ?");
            if (r == true) {
                $.getJSON('/ajaxqueries.php', {
                    query: 'delVehicle',
                    id: obj.data("id")
                }).done(function(){
                    window.location.reload();
                }).error(function(){
                    alert("Tu ne peux pas faire ça !");
                });
            }
        });

        $(".panel-heading").click(function(){
            var head = $(this);
            var target = head.data("target");
            if(head.data("open")){
                $("#"+target).slideUp();
                head.data("open",0).css("background","#DBDBDB");
            }else{
                $("#"+target).slideDown();
                head.data("open",1).css("background","#f5f5f5");
            }
        });

        $("#sanction-submit").click(function(){
            var sanction = $("#sanction").val();
            var type = $("#type").val();
            var desc = $("#description").val();
            if(sanction!="" && desc!=""){
                $.getJSON("/ajaxqueries.php",{
                    query: "addSanction",
                    playerid: "<?= $player->playerid ?>",
                    sanction: sanction,
                    type: type,
                    desc: desc,
                    author: "<?= $admin->playerid ?>"
                }).done(function(data){
                    if(data.ok == 1){
                        window.location.reload();
                    }else{
                        alert("Erreur");
                    }
                }).error(function(){
                    alert("Tu ne peux pas faire ça !")
                });
            }else{
                alert("Merci de remplir tous les champs");
            }
        });

    });

</script>