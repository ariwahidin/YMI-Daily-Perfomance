<table style="font-size: 12px;" class="table table-borderless table-centered align-middle table-nowrap mb-0">
    <thead class="text-muted table-light">
        <tr>
            <th scope="col">Date</th>
            <th scope="col">PL No</th>
            <th scope="col">Picking</th>
            <th scope="col">Checking</th>
            <th scope="col">Scanning</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($outbound->result() as $data) {
            $duration_picking = countDuration($data->start_picking, $data->stop_picking);
            $duration_checking = countDuration($data->start_checking, $data->stop_checking);
            $duration_scanning = countDuration($data->start_scanning, $data->stop_scanning);
            $minute_picking = ($duration_picking != '') ? roundMinutes($duration_picking) : (($data->start_picking != null && $data->stop_picking == null) ? 'proccesing' : '');
            $minute_checking = ($duration_checking != '') ? roundMinutes($duration_checking) : (($data->start_checking != null && $data->stop_checking == null) ? 'proccesing' : '');
            $minute_scanning = ($duration_scanning != '') ? roundMinutes($duration_scanning) : (($data->start_scanning != null && $data->stop_scanning == null) ? 'proccesing' : '');
            // $status = ($minute_picking != 'proccesing' && $minute_checking != 'proccesing' && $minute_scanning != 'proccesing') ? 'DONE' : '';
        ?>

            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1"><?= date('Y-m-d', strtotime($data->created_date)) ?></div>
                    </div>
                </td>
                <td><?= $data->pl_no ?></td>
                <td><?= $minute_picking ?></td>
                <td><?= $minute_checking ?></td>
                <td><?= $minute_scanning ?></td>
                <td>
                    <span class="badge bg-success-subtle text-success"><?= $data->status ?></span>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>