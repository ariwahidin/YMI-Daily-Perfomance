<table style="font-size: 10px;" class="table table-bordered table-striped table-nowrap align-middle display compact" id="tablePicker">
    <thead>
        <tr>
            <th scope="col">NO.</th>
            <th scope="col">PICKER NAME</th>
            <th scope="col">TANGGAL</th>
            <th scope="col">NO PL</th>
            <th scope="col">PL DATE</th>
            <th scope="col">MULAI DORONG</th>
            <th scope="col">SELESAI DORONG</th>
            <th scope="col">DURASI DORONG</th>
            <th scope="col">LEAD TIME DURASI DORONG</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // var_dump($picker);
        foreach ($picker as $data) {
        ?>
            <tr>
                <td><?= $data['NO'] ?></td>
                <td><?= $data['PICKER NAME'] ?></td>
                <td><?= date('Y-m-d', strtotime($data['TANGGAL'])) ?></td>
                <td><?= $data['NO PL'] ?></td>
                <td><?= $data['PL DATE'] ?></td>
                <td><?= $data['MULAI DORONG'] ?></td>
                <td><?= $data['SELESAI DORONG'] ?></td>
                <td><?= $data['DURASI DORONG'] ?></td>
                <td><?= $data['LEAD TIME DURASI DORONG'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>