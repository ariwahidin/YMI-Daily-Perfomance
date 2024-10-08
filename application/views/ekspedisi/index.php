<link href="<?= base_url() ?>myassets/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>myassets/js/jquery-3.7.0.js"></script>
<script src="<?= base_url() ?>myassets/js/jquery.dataTables.min.js"></script>
<style>
    table tr th:first-child {
        max-width: 10px !important;
    }
</style>



<div class="row">
    <div class="col col-md-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Master Ekspedisi</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master Ekspedisi</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-info" id="btnAdd">Add new ekspedisi</button>
            </div>
            <div class="card-body table-responsive">
                <table id="tableEkpedisi" class="display table-sm compact table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th style="white-space: nowrap;">Name</th>
                            <th>Position</th>
                            <th>No Truck</th>
                            <th>Action</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><input type="text" placeholder="Search Name" class="column_search form-control-sm"></th>
                            <th><input type="text" placeholder="Search Position" class="column_search form-control-sm"></th>
                            <th><input type="text" placeholder="Search No Truck" class="column_search form-control-sm"></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- 
<div class="row">
    <div class="col col-md-12">
        <div class="card">
            <div class="card-header bg-primary">

            </div>
            <div class="card-body">
                <table id="user-table" class="table table-striped table-sm table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>No Truck</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($ekspedisi->result() as $data) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->name ?></td>
                                <td><?= $data->no_truck ?></td>
                                <td><?= $data->position ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm btnEdit" data-id="<?= $data->id ?>" data-name="<?= $data->name ?>" data-position="<?= $data->position_id ?>" data-notruck="<?= $data->no_truck ?>">Edit</button>
                                    <button class=" btn btn-danger btn-sm btnDelete" data-id="<?= $data->id ?>">Delete</button>
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
</div> -->

<!-- Grids in modals -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headerForm"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ekpsedisiForm">
                    <div class="row g-3">
                        <div class="col-xxl-6">
                            <div>
                                <label for="name" class="form-label">Ekspedisi Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="" required>
                                <input type="hidden" id="eks_id" name="eks_id" val="" readonly>
                                <input type="hidden" id="form_proses" name="form_proses" val="" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="name" class="form-label">Position</label>
                                <select class="form-control" name="position" id="position_id">
                                    <option value="">Choose position</option>
                                    <?php
                                    foreach ($position->result() as $data) {
                                    ?>
                                        <option value="<?= $data->id ?>"><?= $data->name ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="name" class="form-label">No Truck</label>
                                <input type="text" class="form-control" id="no_truck" name="no_truck" placeholder="" required>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        // var table = $('#tableEkpedisi').DataTable({
        //     "processing": true,
        //     "serverSide": true,
        //     "ajax": {
        //         "url": "<?php echo site_url('ekspedisi/ajax_list') ?>",
        //         "type": "POST"
        //     },
        //     "columnDefs": [{
        //         "targets": [0], //first column / numbering column
        //         "orderable": false, //set not orderable
        //     }, ],
        // });

        var table = $('#tableEkpedisi').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('ekspedisi/ajax_list') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }],
            "createdRow": function(row, data, dataIndex) {
                // Menambahkan atribut data-id pada elemen tr
                $(row).attr('data-id', data['data-id']);
                $(row).attr('data-name', data['data-name']);
                $(row).attr('data-position', data['data-position']);
                $(row).attr('data-notruck', data['data-notruck']);
                $(row).addClass('btnEdit');
                $(row).css('cursor', 'pointer');
            },
            "columns": [
                { "data": 0 }, // Nomor urut
                { "data": 1 }, // Name
                { "data": 2 }, // Position
                { "data": 3 }, // No Truck
                { "data": 4 }  // Action buttons
            ]
        });

        // Individual column search
        $('.column_search').on('keyup change', function() {
            table.column($(this).parent().index()).search(this.value).draw();
        });


        $('#ekpsedisiForm').on('submit', function(e) {
            e.preventDefault();
            let formUser = new FormData(this);
            let form_proses = $('#form_proses').val();

            if (form_proses === 'add_new') {
                $.ajax({
                    url: 'createEkspedisi',
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
                                // window.location.href = 'index';
                                table.ajax.reload(null, false); // user paging is not reset on reload
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
                    url: 'editEkspedisi',
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
                                table.ajax.reload(null, false); // user paging is not reset on reload
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


        $('#btnAdd').on('click', function() {
            $('#headerForm').text('Add new ekspedisi');
            $('#form_proses').val('add_new');
            $('#modalForm').modal('show');
        })

        $('#tableEkpedisi').on('click', '.btnEdit', function() {
            $('#headerForm').text('Edit ekspedisi');
            $('#form_proses').val('edit');
            $('#eks_id').val($(this).data('id'));
            $('#name').val($(this).data('name'));
            $('#position_id').val($(this).data('position'));
            $('#no_truck').val($(this).data('notruck'));
            $('#modalForm').modal('show');
        })

        $('#tableEkpedisi').on('click', '.btnDelete', function() {
            let id = $(this).data('id');
            $.post('deleteEkspedisi', {
                id: id
            }, function(response) {
                if (response.success == true) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'index';
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: response.message
                    });
                }
            }, 'json');
        })
    });
</script>