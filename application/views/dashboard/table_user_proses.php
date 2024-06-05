<div class="col-md-3">
    <div class="card">
        <div class="card-header card-primary"><strong>Inbound Complete Putaway</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-sm table-striped table-nowrap table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Checker</th>
                        <th>SJ</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($inbound->result() as $data) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->fullname ?></td>
                            <td><?= $data->tot_sj ?></td>
                            <td><?= $data->tot_qty ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card">
        <div class="card-header card-primary"><strong>User Inbound Status</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Fullname</th>
                        <th>Status</th>
                        <th>SJ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($user_inbound->result() as $data) {
                        $arr_sj = array();
                        $sj = getStatusProsesUserInbound($data->user_id);

                        // var_dump($sj->result());

                        foreach ($sj->result() as $p) {
                            if ($p->proses_status == 'active') {
                                array_push($arr_sj, $p->no_sj);
                            }
                        }
                        $sj_no = implode(", ", $arr_sj);
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->fullname ?></td>
                            <td><?= count($arr_sj) > 0 ? 'active' : 'idle' ?></td>
                            <td><?= $sj_no ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card">
        <div class="card-header card-success"><strong>Outbound Complete Scanning</strong></div>
        <div class="card-body table-responsive">
            <table class="table display compact table-sm table-striped table-nowrap table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>User</th>
                        <th>PL</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($outbound->result() as $data) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->fullname ?></td>
                            <td><?= $data->tot_pl ?></td>
                            <td><?= $data->tot_qty ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card">
        <div class="card-header card-success"><strong>User Outbound Status</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($user_outbound->result() as $data) {
                        $arr_pl = array();
                        $pl = getStatusProsesUserOutbound($data->user_id);
                        foreach ($pl->result() as $p) {
                            if ($p->proses_status == 'active') {
                                array_push($arr_pl, $p->pl_no . "(" . $p->sts . ")");
                            }
                        }
                        $pl_no = implode(", ", $arr_pl);
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->fullname ?></td>
                            <td><?= count($arr_pl) > 0 ? 'active' : 'idle' ?></td>
                            <td><?= $pl_no ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>