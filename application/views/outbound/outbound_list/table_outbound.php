<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
// var_dump($outbound);
?>
<table id="outboundTable" class="table table-striped table-bordere table-sm">
    <thead>
        <tr>
            <th>No.</th>
            <th>Outbound ID</th>
            <th>Activity Date</th>
            <th>Dest</th>
            <th>Loading Gate</th>
            <th>Remarks</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($outbound as $data) { ?>
            <tr>
                <td class="dt-control" data-id="<?= $data->id ?>"><?= $no++ ?></td>
                <td><?= $data->outbound_number ?></td>
                <td><?= $data->activity_date ?></td>
                <td><?= $data->dest ?></td>
                <td><?= $data->pintu_loading ?></td>
                <td><?= $data->remarks ?></td>
                <td>
                    <button class="btn btn-info btn-sm btnEdit" data-bs-toggle="modal" data-items='<?= json_encode($data) ?>'">Edit</button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>