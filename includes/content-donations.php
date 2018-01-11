<div id="page-wrapper">
    <?php
    $table = Donation::getAll();
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Liste des donations</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-striped table-bordered table-hover" id="dataTables">
                <thead>
                <tr>
                    <th>ID TRANSACTION</th>
                    <th>STATUS</th>
                    <th>EMAIL</th>
                    <th>DATE</th>
                    <th>MONTANT</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total = 0;
                foreach($table as $transaction){
                    $total += $transaction->mc_gross;
                    echo "<tr>";
                    echo "<td>$transaction->txn_id</td>";
                    echo "<td>$transaction->payment_status</td>";
                    echo "<td>$transaction->payer_email</td>";
                    echo "<td>".date("d/m/Y H\hi",strtotime($transaction->dt))."</td>";
                    echo "<td>$transaction->mc_gross $transaction->mc_currency</td>";
                    echo "</tr>";
                } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>TOTAL</b></td>
                    <td><b><?= $total." EUR" ?></b></td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- /.col-lg-12 -->
    </div>
</div>
<!-- /#page-wrapper -->

</div>

<script>
    $(document).ready(function(){
        if(!isMobile) {
            $('#dataTables').DataTable({
                responsive: true,
                order: "[[3,'desc']]"
            });
        }
    });
</script>