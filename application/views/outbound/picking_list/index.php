<div class="row">
    <div class="col col-md-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Picking List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Picking List</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col col-md-6">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="btnAdd">Add new</button>
            </div>
            <div class="card-body">
                <table id="user-table" class="display table table bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>PL No</th>
                            <th>Dock</th>
                            <th>No Truck</th>
                            <th>Dest</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($picking_list->result() as $data) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->pl_no ?></td>
                                <td><?= $data->dock ?></td>
                                <td><?= $data->no_truck ?></td>
                                <td><?= $data->dest ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info btnEdit" data-id="<?= $data->id ?>">Edit</button>
                                    <button class="btn btn-sm btn-danger btnDelete">Delete</button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Grids in modals -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headerForm"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="plForm">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">PL No : </label>
                                <input type="text" class="form-control" id="pl_no" name="pl_no" placeholder="" required>
                                <!-- <input type="hidden" id="eks_id" name="eks_id" val="" readonly> -->
                                <input type="hidden" id="form_proses" name="form_proses" val="" readonly>
                            </div>

                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">SJ No : </label>
                                <input type="text" class="form-control" id="sj_no" name="sj_no" placeholder="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Destination : </label>
                                <input type="text" class="form-control" id="dest" name="dest" placeholder="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Dealer Code : </label>
                                <input type="text" class="form-control" id="dealer_code" name="dealer_code" placeholder="">
                            </div>
                        </div>

                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Dealer : </label>
                                <input type="text" class="form-control" id="dealer_det" name="dealer_det" placeholder="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Expedisi : </label>
                                <input type="text" class="form-control" id="expedisi" name="expedisi" placeholder="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Dock : </label>
                                <input type="text" class="form-control" id="dock" name="dock" placeholder="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Destination : </label>
                                <input type="text" class="form-control" id="dest" name="dest" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">No Truck : </label>
                                <input type="text" class="form-control" id="no_truck" name="no_truck" placeholder="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Total Qty : </label>
                                <input type="number" class="form-control" id="tot_qty" name="tot_qty" placeholder="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">PL Date Amano : </label>
                                <input type="date" class="form-control" id="rec_pl_date" name="rec_pl_date" placeholder="" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">PL Time Amano : </label>
                                <input type="time" class="form-control" id="rec_pl_time" name="rec_pl_time" placeholder="" required>
                            </div>
                        </div>
                    </div>




                    <div class="col-lg-12 mt-3">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#plForm').on('submit', function(e) {
            e.preventDefault();
            let formUser = new FormData(this);
            let form_proses = $('#form_proses').val();

            if (form_proses === 'add_new') {
                $.ajax({
                    url: 'createPickingList',
                    type: 'POST',
                    data: formUser,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success == true) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                window.location.href = 'pickingList';
                            })
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: response.message
                            });
                        }
                    },
                    dataType: 'json'
                });
            }

            // else {
            //     $.ajax({
            //         url: 'editEkspedisi',
            //         type: 'POST',
            //         data: formUser,
            //         processData: false,
            //         contentType: false,
            //         success: function(response) {
            //             if (response.success == true) {
            //                 Swal.fire({
            //                     position: "top-end",
            //                     icon: "success",
            //                     title: response.message,
            //                     showConfirmButton: false,
            //                     timer: 1500
            //                 }).then(function() {
            //                     window.location.href = 'index';
            //                 })
            //             } else {
            //                 Swal.fire({
            //                     icon: 'error',
            //                     title: 'Failed',
            //                     text: response.message
            //                 });
            //             }
            //         },
            //         dataType: 'json'
            //     });
            // }
        });

        // $('#user-table').DataTable();

        $('#btnAdd').on('click', function() {
            moment.tz.setDefault('Asia/Jakarta');
            let today = moment().format('YYYY-MM-DD');
            let currentTime = moment().format('HH:mm');
            $('#rec_pl_date').val(today);
            $('#rec_pl_time').val(currentTime);
            $('#headerForm').text('Add new PL');
            $('#form_proses').val('add_new');
            $('#modalForm').modal('show');
        })

        // $('.btnEdit').on('click', function() {
        //     $('#headerForm').text('Edit ekspedisi');
        //     $('#form_proses').val('edit');
        //     $('#eks_id').val($(this).data('id'));
        //     $('#name').val($(this).data('name'));
        //     $('#modalForm').modal('show');
        // })

        // $('.btnDelete').on('click', function() {
        //     let id = $(this).data('id');
        //     $.post('deleteEkspedisi', {
        //         id: id
        //     }, function(response) {
        //         if (response.success == true) {
        //             Swal.fire({
        //                 position: "top-end",
        //                 icon: "success",
        //                 title: response.message,
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             }).then(function() {
        //                 window.location.href = 'index';
        //             })
        //         } else {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: 'Failed',
        //                 text: response.message
        //             });
        //         }
        //     }, 'json');
        // })
    });
</script>