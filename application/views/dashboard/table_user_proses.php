<div class="col-md-4">
    <div class="card">
        <div class="card-header">Summary of Inbound Activity</div>
        <div class="card-body">
            <table class="table table-sm table-striped table-responsive table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Fullname</th>
                        <th>Total SJ</th>
                        <th>Total Qty</th>
                        <th>Date</th>
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
                            <td><?= $data->created_date ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-md-5 table-responsive">
    <div class="card">
        <div class="card-header">User Activity</div>
        <div class="card-body">
            <table class="table table-sm table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Fullname</th>
                        <th>Proses</th>
                        <th>Posisi</th>
                        <th>PL/SJ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($user_proses->result() as $data) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->fullname ?></td>
                            <td><?= $data->proses ?></td>
                            <td><?= $data->posisi ?></td>
                            <td><?= $data->{'pl/sj'} ?></td>
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
        <div class="card-header">User Idle</div>
        <div class="card-body">
            <table class="table table-sm table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Fullname</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($user_idle->result() as $data) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data->fullname ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>