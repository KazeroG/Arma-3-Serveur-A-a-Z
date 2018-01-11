<div id="wrapper">
    <?php $admin = Admin::byId($_SESSION['admin_id']); ?>
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="logo-brand float-left inline-block ptb-10" style="padding-left: 10px">
                <a href="index.php"><img height="30" src="http://altisfrance.fr/img/logo_af.png"/></a>
            </div>
            <a class="navbar-brand" href="index.php">Altis France - <?= $admin->login ?> (<?= $admin->displayRank() ?>)</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" <?php if(Notification::newNotifs($admin->id)>0) echo 'style="color:#d9534f"'; ?>>
                    <i class="fa fa-bell fa-fw" ></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    <li>
                        <div class="ptb-5 plr-15" style="border-bottom: 1px solid #e5e5e5">Notifications</div>
                    </li>
                    <?php
                    $notifs = Notification::getNotifs($admin->id);
                    foreach($notifs as $k => $n){
                        if($k>=10) break;
                    ?>
                    <li <?php echo $n->status?'style="background-color: #f3dfdf"':''; ?>>
                        <a class="notif" data-id="<?= $n->id ?>" href="<?= $n->link ?>">
                            <i class="fa <?= $n->picto ?> fa-fw"></i> <?= $n->title ?>
                            <span class="pull-right text-muted small"><?= Tools::timeLapse($n->datetime) ?></span>
                        </a>
                    </li>
                    <?php } ?>
                    <li style="border-top: 1px solid #e5e5e5">
                        <a class="text-center" href="#">
                            <strong>See All Alerts</strong>
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="admins.php"><i class="fa fa-users fa-fw"></i> STAFF</a></li>
                    <li><a href="admin.php?id=<?= $_SESSION['admin_id'] ?>"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
                    <li class="divider"></li>
                    <li><a href="index.php?action=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <form id="search-form" method="get" action="players.php">
                        <div class="input-group custom-search-form">
                            <input type="text" id="input-search" name="filter" class="form-control" placeholder="Search...">
                                <span id="submit-search" class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        </form>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="players.php"><i class="fa fa-users fa-fw"></i> Joueurs</a>
                    </li>
                    <li>
                        <a href="players.php?filter=cop"><i class="fa fa-legal fa-fw"></i> Bluefor</a>
                    </li>
                    <li>
                        <a href="players.php?filter=med"><i class="fa fa-ambulance fa-fw"></i> Medics</a>
                    </li>
                    <li>
                        <a href="players.php?filter=dona"><i class="fa fa-star fa-fw"></i> Donateurs</a>
                    </li>
                    <li>
                        <a href="players.php?filter=admins"><i class="fa fa-mortar-board fa-fw"></i> Admins</a>
                    </li>
                    <li>
                        <a href="players.php?filter=bank"><i class="fa fa-money fa-fw"></i> Les plus riches</a>
                    </li>
                    <li>
                        <a href="players.php?filter=sponsors"><i class="fa fa-user-plus fa-fw"></i> Les parrains</a>
                    </li>
                    <li>
                        <a href="ticket.php"><i class="fa fa-ticket fa-fw"></i> Tickets
                            <span class="label label-danger float-right"><?php if($count = count(Ticket::getByStaff($admin->id))>0){ echo $count; }; ?></span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->

        <div class="navbar-default sidebar text-center ptb-10" style="background: none;position: fixed; bottom: 0; color: #999999;">
            <a href="http://touzard.fr">©A.TOUZARD 2016</a>
        </div>
    </nav>