<table id="table_pl_no_sj" class="fs-11 table table-sm table-nowrap table-striped table-bordered compact table-hover" style="width:100%;">
    <thead>
        <tr>
            <th>#</th>
            <th>PL No</th>
            <th>Activity Date</th>
            <th>Dest</th>
            <th class="text-center">SJ No</th>
            <th class="text-center">SJ Time</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($pl->result() as $data) {
        ?>
            <tr style="cursor:pointer">
                <td><?= $no++ ?></td>
                <td><?= $data->pl_no ?></td>
                <td><?= $data->activity_date ?></td>
                <td><?= $data->dest ?></td>
                <td>
                    <input type="hidden" class="form-control form-control-sm sj_in_pl_id" name="sj_in_pl_id[]" required value="<?= $data->id ?>">
                    <input type="text" maxlength="8" minlength="8" required class="form-control form-control-sm sj_in_sj_no" name="sj_in_sj_no[]" value="<?= $data->sj_no ?? '' ?>">
                </td>
                <td>
                    <input type="time" class="form-control form-control-sm sj_in_sj_time" name="sj_in_sj_time[]" required value="<?= $data->sj_time ?? '' ?>">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger btnDeleteRow">x</button>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>