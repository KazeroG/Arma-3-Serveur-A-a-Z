<?php

if(isset($_GET['error'])){
    $error = $_GET['error'];
}
if(isset($_GET['sucess'])){
    $success = $_GET['success'];
}

?>
<div id="page-wrapper">

    <div class="row">
        <div class="col-lg-12">
            <?php echo isset($error)?Tools::displayError($error):''; ?>
            <?php echo isset($success)?Tools::displaySuccess($success):''; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-ticket fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= count(Ticket::getNew()) ?></div>
                            <div>Nouveaux tickets !</div>
                        </div>
                    </div>
                </div>
                <a href="ticket.php">
                    <div class="panel-footer">
                        <span class="pull-left">Détails</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= Player::countPlayers() ?></div>
                            <div>Joueurs enregistrés !</div>
                        </div>
                    </div>
                </div>
                <a href="players.php">
                    <div class="panel-footer">
                        <span class="pull-left">Détails</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user-plus fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= Player::countSponsors() ?></div>
                            <div>Parrains</div>
                        </div>
                    </div>
                </div>
                <a href="players.php?filter=sponsors">
                    <div class="panel-footer">
                        <span class="pull-left">Détails</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-graduation-cap fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?= Admin::countAdmin() ?></div>
                            <div>Membres du STAFF</div>
                        </div>
                    </div>
                </div>
                <a href="admins.php">
                    <div class="panel-footer">
                        <span class="pull-left">Détails</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <!-- /.panel-heading -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Derniers joueurs inscrits
                </div>
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-players">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>GUID</th>
                                <th>Cash</th>
                                <th>Bank</th>
                                <th>Cop</th>
                                <th>Civ</th>
                                <th>Med</th>
                                <th>Admin</th>
                                <th>Dona</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $table = Player::getNew();
                            foreach($table as $player){
                                $player = Player::byPlayerid($player['playerid']); ?>
                                <tr>
                                    <td><a href="player.php?playerid=<?= $player->playerid ?>"><?= $player->name; ?></a></td>
                                    <td><?= $player->playerid; ?></td>
                                    <td class="text-right"><?= $player->cash; ?></td>
                                    <td class="text-right"><?= $player->bankacc; ?></td>
                                    <td class="text-right"><?= $player->coplevel; ?></td>
                                    <td class="text-right"><?= $player->displayCivLevel()?></td>
                                    <td class="text-right"><?= $player->mediclevel; ?></td>
                                    <td class="text-right"><?= $player->adminlevel; ?></td>
                                    <td class="text-right"><?= $player->donatorlvl?'Oui':'Non'; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Donut Chart Example
                </div>
                <div class="panel-body">
                    <div id="morris-donut-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>

</div>
<!-- /#page-wrapper -->

</div>
<script>
    if(!isMobile) {
        $('#dataTables-players').DataTable({
            responsive: true
        });
    }
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [
            {label: "Vagabonds", value: <?= Player::countCivLevel(0)['countCiv'] ?>},
            {label: "Recensés", value: <?= Player::countCivLevel(1)['countCiv'] ?>},
            {label: "Ouvriers", value: <?= Player::countCivLevel(2)['countCiv'] ?>},
            {label: "Marchands", value: <?= Player::countCivLevel(3)['countCiv'] ?>},
            {label: "Citoyens", value: <?= Player::countCivLevel(4)['countCiv'] ?>}
        ],
        colors: ['#999999','#1E2F77','#FF7925','#1FC32F','#08AFFF']
    });
</script>
