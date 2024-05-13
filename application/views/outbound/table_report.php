<table style="font-size: 10px;" class="table table-bordered table-striped table-nowrap align-middle mb-0" id="tableCompleteActivities">
    <thead>
        <tr>
            <th scope="col">NO.</th>
            <th scope="col">TANGGAL</th>
            <th scope="col">NO PL</th>
            <th scope="col">NO SJ</th>
            <th scope="col">TUJUAN</th>
            <th scope="col">NO TRUCK</th>
            <th scope="col">KODE DEALER</th>
            <th scope="col">EXPEDISI</th>
            <th scope="col">MD/DDS</th>
            <th scope="col">QTY</th>
            <th scope="col">JAM CETAK PL</th>
            <th scope="col">JAM AMANO</th>
            <th scope="col">MULAI DORONG</th>
            <th scope="col">SELESAI DORONG</th>
            <th scope="col">MULAI CHECK</th>
            <th scope="col">SELESAI CHECK</th>
            <th scope="col">MULAI SCAN</th>
            <th scope="col">SELESAI SCAN</th>
            <th scope="col">JAM TERIMA SJ</th>
            <th scope="col">PINTU LOADING</th>
            <th scope="col">DURASI DORONG</th>
            <th scope="col">LEAD TIME DURASI DORONG</th>
            <th scope="col">DURASI CHECK</th>
            <th scope="col">LEAD TIME DURASI CHECK</th>
            <th scope="col">DURASI SCAN</th>
            <th scope="col">LEAD TIME DURASI SCAN</th>
            <th scope="col">REMARKS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($completed->result() as $data) {
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data->{'TANGGAL'} ?></td>
                <td><?= $data->{'NO PL'} ?></td>
                <td><?= $data->{'NO SJ'} ?></td>
                <td><?= $data->{'TUJUAN'} ?></td>
                <td><?= $data->{'NO TRUCK'} ?></td>
                <td><?= $data->{'KODE DEALER'} ?></td>
                <td><?= $data->{'EXPEDISI'} ?></td>
                <td><?= $data->{'MD/DDS'} ?></td>
                <td><?= $data->{'QTY'} ?></td>
                <td><?= date('H:i', strtotime($data->{'JAM CETAK PL'})) ?></td>
                <td><?= date('H:i', strtotime($data->{'JAM AMANO'}))  ?></td>
                <td><?= date('H:i', strtotime($data->{'MULAI DORONG'})) ?></td>
                <td><?= date('H:i', strtotime($data->{'SELESAI DORONG'})) ?></td>
                <td><?= date('H:i', strtotime($data->{'MULAI CHECK'})) ?></td>
                <td><?= date('H:i', strtotime($data->{'SELESAI CHECK'})) ?></td>
                <td><?= date('H:i', strtotime($data->{'MULAI SCAN'})) ?></td>
                <td><?= date('H:i', strtotime($data->{'SELESAI SCAN'})) ?></td>
                <td><?= $data->{'JAM TERIMA SJ'} == null ? '' : date('H:i', strtotime($data->{'JAM TERIMA SJ'})) ?></td>
                <td><?= $data->{'PINTU LOADING'} ?></td>
                <td><?= $data->{'DURASI DORONG'} ?></td>
                <td><?= $data->{'LEAD TIME DURASI DORONG'} ?></td>
                <td><?= $data->{'DURASI CHECK'} ?></td>
                <td><?= $data->{'LEAD TIME DURASI CHECK'} ?></td>
                <td><?= $data->{'DURASI SCAN'} ?></td>
                <td><?= $data->{'LEAD TIME DURASI SCAN'} ?></td>
                <td><?= $data->{'REMARKS'} ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>