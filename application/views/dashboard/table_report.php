<table style="font-size: 14px;" class="table table-bordered table-striped table-nowrap display compact" id="tableOutboundActivities">
    <thead>
        <tr>
            <th scope="col">NO.</th>
            <th scope="col">ACTIVITY</th>
            <th scope="col">TUJUAN</th>
            <th scope="col">NO TRUCK</th>
            <th scope="col">EXPEDISI</th>
            <th scope="col">NO PL</th>
            <th scope="col">NO SJ</th>
            <th scope="col">DEALER</th>
            <th scope="col">MD/DDS</th>
            <th scope="col">QTY</th>
            <th scope="col">CETAK PL</th>
            <th scope="col">AMANO</th>
            <th scope="col">START DORONG</th>
            <th scope="col">END DORONG</th>
            <th scope="col">START CHECK</th>
            <th scope="col">END CHECK</th>
            <th scope="col">START SCAN</th>
            <th scope="col">END SCAN</th>
            <th scope="col">TERIMA SJ</th>
            <th scope="col">GATE</th>
            <th scope="col">PARKING</th>
            <th scope="col">START LOAD</th>
            <th scope="col">FINISH LOAD</th>
            <!-- <th scope="col">DURASI DORONG</th>
            <th scope="col">LEAD TIME DURASI DORONG</th>
            <th scope="col">DURASI CHECK</th>
            <th scope="col">LEAD TIME DURASI CHECK</th>
            <th scope="col">DURASI SCAN</th>
            <th scope="col">LEAD TIME DURASI SCAN</th> -->
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
                <td><?= $data->{'ACTIVITY DATE'} ?></td>
                <td><?= $data->{'TUJUAN'} ?></td>
                <td><?= $data->{'NO TRUCK'} ?></td>
                <td><?= $data->{'EXPEDISI'} ?></td>
                <td><?= $data->{'NO PL'} ?></td>
                <td><?= $data->{'NO SJ'} ?></td>
                <td><?= $data->{'KODE DEALER'} ?></td>
                <td><?= $data->{'MD/DDS'} ?></td>
                <td><?= $data->{'QTY'} ?></td>
                <td><?= date('H:i', strtotime($data->{'JAM CETAK PL'})) ?></td>
                <td><?= date('H:i', strtotime($data->{'JAM AMANO'}))  ?></td>
                <td><?= $data->{'MULAI DORONG'} == null ? '' : date('H:i', strtotime($data->{'MULAI DORONG'})) ?></td>
                <td><?= $data->{'SELESAI DORONG'} == null ? '' : date('H:i', strtotime($data->{'SELESAI DORONG'})) ?></td>
                <td><?= $data->{'MULAI CHECK'} == null ? '' : date('H:i', strtotime($data->{'MULAI CHECK'})) ?></td>
                <td><?= $data->{'SELESAI CHECK'} == null ? '' : date('H:i', strtotime($data->{'SELESAI CHECK'})) ?></td>
                <td><?= $data->{'MULAI SCAN'} == null ? '' : date('H:i', strtotime($data->{'MULAI SCAN'})) ?></td>
                <td><?= $data->{'SELESAI SCAN'} == null ? '' : date('H:i', strtotime($data->{'SELESAI SCAN'})) ?></td>
                <td><?= $data->{'JAM TERIMA SJ'} == null ? '' : date('H:i', strtotime($data->{'JAM TERIMA SJ'})) ?></td>
                <td><?= $data->{'loading_gate'} ?></td>
                <!-- <td><?= $data->{'DURASI DORONG'} ?></td>
                <td><?= $data->{'LEAD TIME DURASI DORONG'} ?></td>
                <td><?= $data->{'DURASI CHECK'} ?></td>
                <td><?= $data->{'LEAD TIME DURASI CHECK'} ?></td>
                <td><?= $data->{'DURASI SCAN'} ?></td>
                <td><?= $data->{'LEAD TIME DURASI SCAN'} ?></td> -->
                <td><?= $data->{'parking_time'} == null ? '' : date('H:i', strtotime($data->{'parking_time'})) ?></td>
                <td><?= $data->{'start_loading'} == null ? '' : date('H:i', strtotime($data->{'start_loading'})) ?></td>
                <td><?= $data->{'finish_loading'} == null ? '' : date('H:i', strtotime($data->{'finish_loading'})) ?></td>
                <td><?= $data->{'REMARKS'} ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>