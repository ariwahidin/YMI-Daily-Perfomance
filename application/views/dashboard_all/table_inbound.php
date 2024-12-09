<table style="font-size: 12px;" class="table table-borderless table-centered align-middle table-nowrap mb-0">
    <thead class="text-muted table-light">
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Activity Date</th>
            <th scope="col">Surat Jalan</th>
            <th scope="col">Checker</th>
            <th scope="col">Unloading</th>
            <th scope="col">Checking</th>
            <th scope="col">Putaway</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($inbound->result() as $data) {
            $duration_unload = countDuration($data->start_unload, $data->stop_unload);

            $duration_checking = countDuration($data->start_checking, $data->stop_checking);
            $duration_putaway = countDuration($data->start_putaway, $data->stop_putaway);

            // var_dump($duration_unload);
            // var_dump($duration_checking);
            // var_dump($duration_putaway);

            $minute_unload = ($duration_unload != '') ? roundMinutes($duration_unload) : (($data->start_unload != null && $data->stop_unload == null) ? 'proccesing' : '');
            $minute_checking = ($duration_checking != '') ? roundMinutes($duration_checking) : (($data->start_checking != null && $data->stop_checking == null) ? 'proccesing' : '');
            $minute_putaway = ($duration_putaway != '') ? roundMinutes($duration_putaway) : (($data->start_putaway != null && $data->stop_putaway == null) ? 'proccesing' : '');
            // $status = ($minute_unload != 'processing' && $minute_checking != 'processing' && $minute_putaway != 'processing' && $minute_unload != '' && $minute_checking != '' && $minute_putaway != '') ? 'DONE' : '';
            $status = ($duration_unload != '' && $duration_checking != '' && $duration_putaway != '') ? 'DONE' : '';

        ?>

            <tr>
                <td><?= $no++; ?></td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1"><?= $data->activity_date == null ? '' : date('Y-m-d', strtotime($data->activity_date)) ?></div>
                    </div>
                </td>
                <td><?= $data->no_sj ?></td>
                <td><?= $data->checker_name ?></td>
                <td><?= $minute_unload ?></td>
                <td><?= $minute_checking ?></td>
                <td><?= $minute_putaway ?></td>
                <td>
                    <span class="badge bg-success-subtle text-success"><?= $status ?></span>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>