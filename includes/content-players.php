<div id="page-wrapper">
    <?php
    if(isset($_GET['filter'])){
        $filter = $_GET['filter'];
        $player = Player::byPlayerid($filter);
        if(isset($player)){
            echo '<script>window.location.replace("player.php?playerid='.$filter.'")</script>';
        }
        $table = Player::getPlayersByFilter($filter);
        switch ($filter) {
            case 'cop':
                $title = 'Liste des '.count($table).' joueurs Bluefor' ;
                break;
            case 'med':
                $title = 'Liste des '.count($table).' joueurs Médics' ;
                break;
            case 'admins':
                $title = 'Liste des '.count($table).' Admins' ;
                break;
            case 'dona':
                $title = 'Liste des '.count($table).' donateurs' ;
                break;
            case 'bank' :
                $title = 'Liste des 50 joueurs les plus riches' ;
                break;
            case 'sponsors' :
                $title = 'Liste des meilleurs parrains' ;
                break;
            case 'new' :
                $title = 'Liste des 50 derniers joueurs enregistrés' ;
                break;
            default :
                $title = 'Liste des '.count($table).' joueurs ressemblant à "'.$filter.'"' ;
        }
    }else{
        $table = Player::getNew();
        $title = 'Liste des nouveaux joueurs' ;
    }
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= $title ?></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des joueurs
                </div>
                <!-- /.panel-heading -->
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
                                <?php echo $_GET['filter']=="sponsors" ? "<th>Filleuls</th>": "" ; ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($table as $player){
                                if(isset($player->sponsor)){ $player = Player::byPlayerid($player->sponsor); }
                                else{ $player = Player::byPlayerid($player['playerid']); } ?>
                                <tr>
                                    <td><a href="player.php?playerid=<?= $player->playerid ?>"><?= $player->name; ?></a></td>
                                    <td><?= $player->playerid; ?></td>
                                    <td class="text-right"><?= $player->cash; ?></td>
                                    <td class="text-right"><?= $player->bankacc; ?></td>
                                    <td class="text-right"><?= $player->coplevel; ?></td>
                                    <td class="text-right"><?= $player->displayCivLevel()?></td>
                                    <td class="text-right"><?= $player->mediclevel; ?></td>
                                    <td class="text-right"><?= $player->adminlevel; ?></td>
                                    <td class="text-right"><?= $player->donatorlvl; ?></td>
                                    <?php echo $_GET['filter']=="sponsors" ? "<td class=\"text-right\">".count($player->getSponsoredPlayer())."</td>": "" ; ?>
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
        <!-- /.col-lg-12 -->
    </div>
</div>
<!-- /#page-wrapper -->

</div>

<script>
    if(!isMobile) {
        $('#dataTables-players').DataTable({
            responsive: true,
            <?php if($filter=='bank') echo "order: [[3,'desc']]"; ?>
            <?php if($filter=='cop') echo "order: [[4,'desc']]"; ?>
            <?php if($filter=='med') echo "order: [[5,'desc']]"; ?>
            <?php if($filter=='admins') echo "order: [[6,'desc']]"; ?>
            <?php if($filter=='sponsors') echo "order: [[9,'desc']]"; ?>
        });
    }

//    $('#side-menu').metisMenu();


</script>