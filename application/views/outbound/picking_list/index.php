<link href="https://cdn.jsdelivr.net/npm/select2@latest/dist/css/select2.min.css" rel="stylesheet" />
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
    <div class="col col-md-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="btnAdd">Add new</button>
                <button class="btn btn-success" id="btnRefresh">Refresh</button>
            </div>
            <div class="card-body table-responsive" id="cardPL">

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
                                <input type="hidden" id="form_proses" name="form_proses" val="" readonly>
                                <input type="hidden" id="pl_id" name="pl_id" val="" readonly>
                            </div>
                        </div>


                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">PL Printed Time: </label>
                                <input type="time" class="form-control" id="pl_print_time" name="pl_print_time" placeholder="" required>
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

                    <div class="row mt-2">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Dealer Code : </label>
                                <!-- <input type="text" class="form-control" id="dealer_code" name="dealer_code" placeholder=""> -->
                                <select name="dealer_code" id="dealer_code">
                                    <option value="">Choose dealer code</option>
                                    <?php
                                    foreach ($dealer->result() as $data) {
                                    ?>
                                        <option value="<?= $data->code ?>" data-name="<?= $data->name ?>"><?= $data->code ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Dealer / Depo : </label>
                                <input type="text" class="form-control" id="dealer_det" name="dealer_det" placeholder="" readonly>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Pintu Loading : </label>
                                <input type="number" class="form-control" id="pintu_loading" name="pintu_loading" placeholder="">
                            </div>
                        </div>

                    </div>



                    <div class="row mt-2">

                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Destination : </label>
                                <!-- <input type="text" class="form-control" id="dest" name="dest" placeholder=""> -->
                                <select name="dest" id="dest" class="form-control">
                                    <option value="">Choose destination</option>
                                    <?php
                                    foreach ($dest->result() as $data) {
                                    ?>
                                        <option value="<?= $data->code ?>" data-name="<?= $data->name ?>"><?= $data->code ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Dest. Type : </label>
                                <input type="text" class="form-control" id="dock" name="dock" placeholder="" readonly>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Total Qty : </label>
                                <input type="number" class="form-control" id="tot_qty" name="tot_qty" placeholder="">
                            </div>
                        </div>

                    </div>


                    <div class="row mt-2">

                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">No Truck : </label>
                                <!-- <input type="text" class="form-control" id="no_truck" name="no_truck" placeholder=""> -->
                                <select class="form-control" name="no_truck" id="no_truck" required>
                                    <option value="">Choose No Truck</option>
                                    <?php foreach ($ekspedisi->result() as $eks) { ?>
                                        <option value="<?= $eks->no_truck ?>" data-id="<?= $eks->id ?>"><?= $eks->no_truck ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Expedisi : </label>
                                <select class="form-control" name="expedisi" id="expedisi">
                                    <option value="">Choose ekspedisi</option>
                                    <?php foreach ($ekspedisi->result() as $eks) { ?>
                                        <option value="<?= $eks->id ?>"><?= $eks->name ?></option>
                                    <?php } ?>
                                </select>
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
                                <label for="name" class="form-label">SJ Time : </label>
                                <input type="time" class="form-control" id="sj_time" name="sj_time" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col">
                            <div class="form-group">
                                <label for="name" class="form-label">Remarks : </label>
                                <input type="text" class="form-control" name="remarks" id="remarks">
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
<script src="https://cdn.jsdelivr.net/npm/select2@latest/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        $('#dest').select2({
            tags: true,
            dropdownParent: $("#modalForm")
        });

        $('#dest').on('change', function() {
            let kode = $(this).val();
            let name = $(this).children('option:selected').data('name');
            $('#dock').val(name);
        })

        $('#dealer_code').select2({
            tags: true,
            dropdownParent: $("#modalForm")
        });

        $('#dealer_code').on('change', function() {
            let kode = $(this).val();
            let name = $(this).children('option:selected').data('name');
            $('#dealer_det').val(name);
        })

        $('#no_truck').select2({
            tags: true,
            dropdownParent: $("#modalForm")
        });

        $('#no_truck').on('change', function() {
            let kode = $(this).val();
            let id = $(this).children('option:selected').data('id');
            console.log(id);
            $('#expedisi').val(id);
        })



        getTablePickingList();

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
                                // window.location.href = 'pickingList';
                                getTablePickingList();
                                $('#modalForm').modal('hide');
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
            } else {
                $.ajax({
                    url: 'editPickingList',
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
                                // window.location.href = 'pickingList';
                                getTablePickingList();
                                $('#modalForm').modal('hide');
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
        });

        function getTablePickingList() {
            $.post('getTablePickingList', {}, function(response) {
                if (response.success == true) {
                    $('#cardPL').empty();
                    $('#cardPL').html(response.table);
                    $('#tablePL').dataTable();
                }
            }, 'json');
        }

        // $('#user-table').DataTable();

        $('#btnRefresh').on('click', async function() {
            startLoading();
            await getTablePickingList();
            stopLoading();
        })

        $('#btnAdd').on('click', function() {
            moment.tz.setDefault('Asia/Jakarta');
            let today = moment().format('YYYY-MM-DD');
            let currentTime = moment().format('HH:mm');
            $('#sj_time').val('');
            $('#rec_pl_date').val(today);
            $('#rec_pl_time').val(currentTime);
            $('#pl_print_time').val(currentTime);
            $('#headerForm').text('Add new PL');
            $('#form_proses').val('add_new');
            $('#modalForm').modal('show');
        })

        $('#cardPL').on('click', '.btnEdit', function() {
            let pl_id = $(this).data('id');

            $.post('getPickingListAdmById', {
                id: pl_id
            }, function(response) {
                let data = response.picking_list;
                $('#form_proses').val('edit');
                $('#pl_id').val(data.id);
                $('#pl_no').val(data.pl_no);
                $('#dest').val(data.dest);
                $('#tot_qty').val(data.tot_qty);
                $('#pintu_loading').val(data.pintu_loading);
                $('#dealer_code').val(data.dealer_code);
                $('#dealer_det').val(data.dealer_det);
                $('#dock').val(data.dock);
                $('#pl_print_time').val(data.pl_print_time);
                $('#rec_pl_date').val(data.adm_pl_date);
                $('#rec_pl_time').val(data.adm_pl_time);
                $('#expedisi').val(data.expedisi);
                $('#no_truck').val(data.no_truck);
                $('#sj_no').val(data.sj_no);
                $('#sj_time').val(data.sj_time);
                $('#remarks').val(data.remarks);
                $('#headerForm').text('Edit PL');
                $('#form_proses').val('edit');
                $('#modalForm').modal('show');
            }, 'json');

        })



        $('#cardPL').on('click', '.btnDelete', function() {
            let id = $(this).data('id');


            $.post('cekStatusPickingList', {
                id: id
            }, function(response) {
                if (response.success == true) {
                    if (response.data.status == 'unprocessed') {
                        $.post('deletePickingList', {
                            id: id
                        }, function(response) {
                            if (response.success == true) {
                                getTablePickingList();
                            }
                        }, 'json');
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Not allowed',
                            text: 'Status picking list : ' + response.data.status
                        });
                    }
                }
            }, 'json');

            // $.post('deleteEkspedisi', {
            //     id: id
            // }, function(response) {
            //     if (response.success == true) {
            //         Swal.fire({
            //             position: "top-end",
            //             icon: "success",
            //             title: response.message,
            //             showConfirmButton: false,
            //             timer: 1500
            //         }).then(function() {
            //             window.location.href = 'index';
            //         })
            //     } else {
            //         Swal.fire({
            //             icon: 'error',
            //             title: 'Failed',
            //             text: response.message
            //         });
            //     }
            // }, 'json');
        })
    });
</script>