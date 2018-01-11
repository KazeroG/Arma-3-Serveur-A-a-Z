<div id="page-wrapper">
    <?php
    $table = Ticket::getOpen();

    $admin = Admin::byId($_SESSION['admin_id']);
    $perm_admin = $admin->status<2 ? 'disabled':'';

    if(isset($_GET['id']) and $_GET['id']!='') {
        $ticket = Ticket::byId($_GET['id']);
    }
    if(isset($ticket)){

        $isMyTicket = ($_SESSION['admin_status']==2 or $ticket->staff_id==$admin->id);
        if(!$isMyTicket) $warning = "Vous n'êtes pas assigné sur le ticket";
        $permTicket = $isMyTicket==1 ? '':'disabled';

        if(!empty($_POST)){
            if($isMyTicket) {
                if (isset($_POST['status'])) $ticket->status = $_POST['status'];
                if (isset($_POST['answer'])) $ticket->answer = $_POST['answer'];
                if (isset($_POST['staff_id']) and $admin->status == 2) $ticket->staff_id = $_POST['staff_id'];
                $ticket->update();
                $sucess = "Ticket bien enregistré";
            }else{
                $error = "Tu ne peux pas faire ça, tu n'est pas assigné sur le ticket";
            }
        }
    ?>

    <!--ERRORS-->
    <div class="row">
        <div class="col-lg-12">
            <?php echo isset($error)?Tools::displayError($error):''; ?>
            <?php echo isset($warning)?Tools::displayWarning($warning):''; ?>
            <?php echo isset($success)?Tools::displaySuccess($success):''; ?>
        </div>
    </div>

    <!--FICHE TICKET-->
    <div class="row">
        <div class="col-lg-12 page-header">
            <h1 class="inline-block m-0">Tickets n°<?= $ticket->id." : ".$ticket->type." (".date("d/m/Y H\hi",strtotime($ticket->date)).")" ?></h1>
            <?php if(empty($ticket->staff_id) or $admin->status==2){ ?><button data-id="<?= $ticket->id ?>" id="pick-ticket" type="button" name="submit" class="mlr-5 float-right btn btn-success btn-lg">Prendre Ticket</button>
            <?php }elseif($isMyTicket or $admin->status==2){ ?><button id="submit-form" type="button" name="submit" class="float-right btn btn-primary btn-lg">Enregistrer</button><?php } ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <div data-target="infosPanel" data-open="1" class="panel-heading pointer">
                    Informations du ticket
                </div>
                <div id="infosPanel" class="panel-body">
                    <form id="ticket-form" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Playerid Joueur :</strong><p>
                                <a target="_blank" href="player.php?playerid=<?= $ticket->playerid ?>"><p><?= $ticket->playerid ?></p></a>
                            </div>
                            <?php if($admin->status==2){ ?>
                            <div class="col-md-3">
                                <label for="staff_id" class="label-form">Staff assigné :</label>
                                <div class="form-group">
                                    <select id="staff_id" name="staff_id" class="form-control">
                                        <option value="0">Non assigné</option>
                                        <?php
                                        $admins = Admin::getAll();
                                        foreach($admins as $a){
                                            $selected = $a->id==$ticket->staff_id ? 'selected' : '';
                                            echo '<option value="'.$a->id.'" '.$selected.'>'.$a->login.' - '.$a->displayRank().'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="col-md-3">
                                <label for="status" class="label-form">status :</label>
                                <div class="form-group">
                                    <select id="status" name="status" class="form-control" <?= $permTicket ?>>
                                        <option value="0">Fermé</option>
                                        <option value="1" <?php if($ticket->status==1)echo 'selected' ?>>Ouvert</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Joueur(s) concernés :</strong></p>
                                <p><?php echo isset($ticket->target) ? $ticket->target : 'N/A' ;?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Joueur(s) témoins :</strong></p>
                                <p><?php echo isset($ticket->witness) ? $ticket->witness : 'N/A' ;?></p>
                            </div>
                            <div class="col-md-12">
                                <p><strong>Description :</strong></p>
                                <p><?= $ticket->description ?></p>
                            </div>
                            <div class="col-md-12">
                                <p><strong>Preuves / Fichiers :</strong></p>
                                <p><?= $ticket->files ?></p>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="answer">Réponse Staff</label>
                                    <textarea id="answer" name="answer" class="form-control" rows="5" <?= $permTicket ?>><?= $ticket->answer ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <?php
                                if($sanctions = Sanction::byTicket($ticket->id)) {
                                    echo '<h3>Délibération du staff :</h3>';
                                    foreach ($sanctions as $s) {
                                    if($s->type==2){ $class = 'label-danger'; }
                                    elseif($s->type==1){ $class = 'label-warning'; }
                                    else{ $class = 'label-success'; }
                                    $author = Admin::byPlayerid($s->author); ?>
                                        <div class="panel panel-default mb-10">
                                            <div data-target="sanction-<?= $s->id ?>" data-open="0" class="panel-heading pointer">
                                                <h4 class="panel-title">
                                                    <?php echo date("Y-m-d H\hi",strtotime($s->date)).' - '.Player::byPlayerid($s->playerid)->name.' : '.$s->sanction.' ('.$author->login.')'; ?>
                                                    <?php if($s->type>=1) echo "<span class=\"mlr-5 float-right label $class\">".$s->displayType()."</span>"; ?>
                                                </h4>
                                            </div>
                                            <div id="sanction-<?= $s->id ?>" class="panel-body display-none">
                                                <div class="row">
                                                    <div class="col-xs-12">
                                                        <?= $s->description ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }?>
                            </div>
                        </div>
                        <div class="row">
                        <div class="text-center">
                            <?php if($isMyTicket){ ?><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#addSanction"><i class="fa fa-gavel"></i> Ajouter Rapport</button><?php } ?>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php } ?>

    <!--ERRORS-->
    <div class="row">
        <div class="col-lg-12">
            <?php echo isset($error)?Tools::displayError($error):''; ?>
            <?php echo isset($success)?Tools::displaySuccess($success):''; ?>
        </div>
    </div>

    <?php
    $tableMy = Ticket::getByStaff($admin->id);
    if(!empty($tableMy)){
    ?>
    <!--MY TICKETS-->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Mes tickets</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="dataTable_wrapper">
                <table id="dataTableStaff" class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>PlayerId</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Assigné</th>
                        <th>status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($tableMy as $t){
                        $status = $t->status==1 ? '<span class="mlr-5 label label-success">Ouvert</span>':'<span class="mlr-5 label label-danger">Fermé</span>';
                        $staff = isset($t->staff_id) ? Admin::byId($t->staff_id)->login : 'Non';
                        echo "<tr data-id=\"$t->id\" class=\"pointer\">";
                        echo "<td>$t->id</td>";
                        echo "<td>$t->playerid</td>";
                        echo "<td>".date("d/m/Y H\hi",strtotime($t->date))."</td>";
                        echo "<td>$t->type</td>";
                        echo "<td>$staff</td>";
                        echo "<td class=\"text-center\">$status</td>";
                        echo "<tr></tr>";
                    } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <?php } ?>

    <!--OPEN TICKETS-->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tickets ouverts</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="dataTable_wrapper">
                <table id="dataTableOpen" class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>PlayerId</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Assigné</th>
                            <th>status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($table as $t){
                        if($t->staff_id==$admin->id) continue;
                        $status = $t->status==1 ? '<span class="mlr-5 label label-success">Ouvert</span>':'<span class="mlr-5 label label-danger">Fermé</span>';
                        $staff = isset($t->staff_id) ? Admin::byId($t->staff_id)->login : 'Non';
                        echo "<tr data-id=\"$t->id\" class=\"pointer\">";
                        echo "<td>$t->id</td>";
                        echo "<td>$t->playerid</td>";
                        echo "<td>".date("d/m/Y H\hi",strtotime($t->date))."</td>";
                        echo "<td>$t->type</td>";
                        echo "<td>$staff</td>";
                        echo "<td class=\"text-center\">$status</td>";
                        echo "<tr></tr>";
                    } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <?php
    $tableClosed = Ticket::getClosed();
    ?>
    <!--CLOSED TICKETS-->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Tickets fermés</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="dataTable_wrapper">
                <table id="dataTableClosed" class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>PlayerId</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Assigné</th>
                        <th>status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach($tableClosed as $t){
                        $status = $t->status==1 ? '<span class="mlr-5 label label-success">Ouvert</span>':'<span class="mlr-5 label label-danger">Fermé</span>';
                        $staff = isset($t->staff_id) ? Admin::byId($t->staff_id)->login : 'Non';
                        echo "<tr data-id=\"$t->id\" class=\"pointer\">";
                        echo "<td>$t->id</td>";
                        echo "<td>$t->playerid</td>";
                        echo "<td>".date("d/m/Y H\hi",strtotime($t->date))."</td>";
                        echo "<td>$t->type</td>";
                        echo "<td>$staff</td>";
                        echo "<td class=\"text-center\">$status</td>";
                        echo "<tr></tr>";
                    } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
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
                    <div class="col-md-6">
                        <label for="target" class="label-form">Joueur à sanctioner :</label>
                        <input id="target" type="text" style="width: 300px">
                    </div>
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

</div>

<script>
    $(document).ready(function(){
        var options = {
            url: function(name) {
                return "api/search.php?name=" + name;
            },
            getValue: "name"
        };
        $("#target").easyAutocomplete(options);

        $('tbody tr').click(function(){
            window.location.replace("ticket.php?id="+$(this).data("id"));
        });

        $("#sanction-submit").click(function(){
            var sanction = $("#sanction").val();
            var type = $("#type").val();
            var desc = $("#description").val();
            var name = $("#target").val();
            if(sanction!="" && desc!="" && name!=""){
                $.getJSON("/ajaxqueries.php",{
                    query: "addSanction",
                    name: name,
                    sanction: sanction,
                    type: type,
                    desc: desc,
                    <?php if(isset($ticket)) echo "ticket: '$ticket->id'," ?>
                    author: "<?= $admin->playerid ?>"
                }).done(function(data){
                    if(data.ok == 1){
                        window.location.reload();
                    }else{
                        alert("Erreur");
                    }
                });
            }else{
                alert("Merci de remplir tous les champs");
            }
        });

        $("#pick-ticket").click(function(){
            var id = $(this).data("id");
            $.getJSON("/ajaxqueries.php",{
                query: "assignTicket",
                id: id,
                to: "<?= $admin->id ?>"
            }).done(function(){
                window.location.reload();
            });
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

        $("#submit-form").click(function(){
            $("#ticket-form").submit();
        });
    });
</script>
