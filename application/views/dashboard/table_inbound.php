<table style="font-size: 12px;" class="table table-borderless table-centered align-middle table-nowrap mb-0">
    <thead class="text-muted table-light">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">Surat Jalan</th>
            <th scope="col">Checker</th>
            <th scope="col">Unloading</th>
            <th scope="col">Checking</th>
            <th scope="col">Putaway</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($inbound->result() as $data) {
            $duration_unload = countDuration($data->start_unload, $data->stop_unload);
            $duration_checking = countDuration($data->start_checking, $data->stop_checking);
            $duration_putaway = countDuration($data->start_putaway, $data->stop_putaway);
            $minute_unload = ($duration_unload != '') ? roundMinutes($duration_unload) : (($data->start_unload != null && $data->stop_unload == null) ? 'proccesing' : '');
            $minute_checking = ($duration_checking != '') ? roundMinutes($duration_checking) : (($data->start_checking != null && $data->stop_checking == null) ? 'proccesing' : '');
            $minute_putaway = ($duration_putaway != '') ? roundMinutes($duration_putaway) : (($data->start_putaway != null && $data->stop_putaway == null) ? 'proccesing' : '');
            $status = ($minute_unload != 'processing' && $minute_checking != 'processing' && $minute_putaway != '' && $minute_unload != '' && $minute_checking != '' && $minute_putaway != '') ? 'DONE' : '';

        ?>

            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1"><?= date('Y-m-d', strtotime($data->created_at)) ?></div>
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