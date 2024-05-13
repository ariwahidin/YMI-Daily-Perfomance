<table id="user-table" class="table table-sm table-bordered table-striped" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Employee Name</th>
            <th>Day</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Position</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($work_schedule->result() as $data) {
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data->fullname ?></td>
                <td><?= date('l', strtotime($data->date)) ?></td>
                <td><?= $data->date ?></td>
                <td><?= date('H:i', strtotime($data->start_time)) ?></td>
                <td><?= date('H:i', strtotime($data->end_time)) ?></td>
                <td><?= $data->position_name ?></td>
                <td>
                    <button class="btn btn-primary btn-sm btnEdit" data-id="<?= $data->id ?>" data-user-id="<?= $data->user_id ?>" data-position-id="<?= $data->position_id ?>" data-date="<?= $data->date ?>" data-start-time="<?= date('H:i', strtotime($data->start_time)) ?>" data-end-time="<?= date('H:i', strtotime($data->end_time)) ?>">Edit</button>
                    <button class=" btn btn-danger btn-sm btnDelete" data-id="<?= $data->id ?>">Delete</button>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>