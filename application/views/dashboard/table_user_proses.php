<div class="col-md-4">
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
                        <th>Activity Date</th>
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
                            <td><?= $data->activity_date ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-4">
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
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->fullname ?></td>
                            <td><?= $data->status ?></td>
                            <td>
                                <?php
                                $sj = $this->db->get_where('tb_trans_temp', ['checker_id' => $data->user_id]);
                                $arr = array();
                                foreach ($sj->result() as $s) {
                                    array_push($arr, $s->no_sj);
                                }
                                $no_sj = implode(", ", $arr);
                                echo $no_sj;
                                ?>

                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card">
        <div class="card-header card-success"><strong>User Outbound Status</strong></div>
        <div class="card-body table-responsive">
            <table class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Picker</th>
                        <th>Status</th>
                        <th>PL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($user_outbound->result() as $data) {
                        $arr_pl = array();
                        $this->db->select('a.pl_no');
                        $this->db->from('pl_h a');
                        $this->db->join('pl_p b', 'a.id = b.pl_id');
                        $this->db->join('tb_out_temp c', 'a.id = c.no_pl');
                        $this->db->where(['b.user_id' => $data->user_id]);
                        $pl = $this->db->get();
                        foreach ($pl->result() as $p) {
                            array_push($arr_pl, $p->pl_no);
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