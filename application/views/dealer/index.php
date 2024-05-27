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
            <h4 class="mb-sm-0">Master dealer</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master dealer</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col col-md-10">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="btnAdd">Add new dealer</button>
            </div>
            <div class="card-body">
                <table id="user-table" class="display table table-bordered compact" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Dealer Code</th>
                            <th>Dealer Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($dealer->result() as $data) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->code ?></td>
                                <td><?= $data->name ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm btnEdit" data-id="<?= $data->id ?>" data-code="<?= $data->code ?>" data-name="<?= $data->name ?>">Edit</button>
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
</div>

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
                                <label for="name" class="form-label">Dealer Code</label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="" required>
                            </div>
                            <div>
                                <label for="name" class="form-label">Dealer Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="" required>
                                <input type="hidden" id="eks_id" name="eks_id" val="" readonly>
                                <input type="hidden" id="form_proses" name="form_proses" val="" readonly>
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
        $('#ekpsedisiForm').on('submit', function(e) {
            e.preventDefault();
            let formUser = new FormData(this);
            let form_proses = $('#form_proses').val();

            if (form_proses === 'add_new') {
                $.ajax({
                    url: 'createdealer',
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
                                window.location.href = 'index';
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
                    url: 'editdealer',
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
                                window.location.href = 'index';
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

        $('#user-table').DataTable();

        $('#btnAdd').on('click', function() {
            $('#headerForm').text('Add new dealer');
            $('#form_proses').val('add_new');
            $('#modalForm').modal('show');
        })

        $('.btnEdit').on('click', function() {
            $('#headerForm').text('Edit dealer');
            $('#form_proses').val('edit');
            $('#eks_id').val($(this).data('id'));
            $('#code').val($(this).data('code'));
            $('#name').val($(this).data('name'));
            $('#modalForm').modal('show');
        })

        $('.btnDelete').on('click', function() {
            let id = $(this).data('id');
            $.post('deletedealer', {
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