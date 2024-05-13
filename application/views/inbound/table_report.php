<table style="font-size: 10px;" class="table table-bordered table-striped table-nowrap align-middle" id="tableCompleteActivities">
    <thead>
        <tr>
            <th scope="col">NO UNLOAD.</th>
            <th scope="col">ACTIVITY DATE</th>
            <th scope="col">SENT DATE</th>
            <th scope="col">UNLOADING DATE</th>
            <th scope="col">FACTORY</th>
            <th scope="col">SJ NO</th>
            <th scope="col">SJ DATE</th>
            <th scope="col">SJ TIME</th>
            <th scope="col">NO TRUCK</th>
            <th scope="col">EXPEDISI</th>
            <th scope="col">DRIVER</th>
            <th scope="col">ALOC</th>
            <th scope="col">PINTU UNLOAD</th>
            <th scope="col">CHECKER</th>
            <th scope="col">QTY</th>
            <th scope="col">TIME ARIVAL</th>
            <th scope="col">UNLOAD START</th>
            <th scope="col">UNLOAD STOP</th>
            <th scope="col">UNLOAD DURATION</th>
            <th scope="col">CHECKING START</th>
            <th scope="col">CHECKING STOP</th>
            <th scope="col">CHECKING DURATION</th>
            <th scope="col">PUTAWAY START</th>
            <th scope="col">PUTAWAY STOP</th>
            <th scope="col">PUTAWAY DURATION</th>
            <th scope="col">ACTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($completed->result() as $data) {
        ?>
            <tr>
                <td><?= $data->unload_seq ?></td>
                <td><?= date('Y-m-d', strtotime($data->sj_created_at)) ?></td>
                <td><?= date('Y-m-d', strtotime($data->sj_send_date)) ?></td>
                <td><?= $data->start_unload == null ? '' : date('Y-m-d', strtotime($data->start_unload)) ?></td>
                <td><?= $data->factory_name ?></td>
                <td><?= $data->no_sj ?></td>
                <td><?= date('Y-m-d', strtotime($data->sj_date)) ?></td>
                <td><?= date('H:i', strtotime($data->sj_time)) ?></td>
                <td><?= $data->no_truck ?></td>
                <td><?= $data->ekspedisi_name ?></td>
                <td><?= $data->driver ?></td>
                <td><?= $data->alloc_code ?></td>
                <td><?= $data->pintu_unloading ?></td>
                <td><?= $data->checker_name ?></td>
                <td><?= $data->qty ?></td>
                <td><?= date('H:i', strtotime($data->time_arival)) ?></td>
                <td><?= $data->start_unload == null ? '' : date('H:i', strtotime($data->start_unload)) ?></td>
                <td><?= $data->stop_unload == null ? '' : date('H:i', strtotime($data->stop_unload)) ?></td>
                <td><?= $data->unload_duration ?></td>
                <td><?= $data->start_checking == null ? '' : date('H:i', strtotime($data->start_checking)) ?></td>
                <td><?= $data->stop_checking == null ? '' : date('H:i', strtotime($data->stop_checking)) ?></td>
                <td><?= $data->checking_duration ?></td>
                <td><?= $data->start_putaway == null ? '' : date('H:i', strtotime($data->start_putaway)) ?></td>
                <td><?= $data->stop_putaway == null ? '' : date('H:i', strtotime($data->stop_putaway)) ?></td>
                <td><?= $data->putaway_duration ?></td>
                <td>
                    <?php
                    if ($data->status == 'complete') {
                    ?>
                        <button class="btn mt-1 mb-1 btn-sm btn-primary btnEdit" data-id="<?= $data->id ?>">Edit</button>
                        <button class="btn mt-1 mb-1 btn-sm btn-danger btnDelete" data-id="<?= $data->id ?>">Delete</button>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>