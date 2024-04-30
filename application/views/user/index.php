<style>
    table tr th:first-child {
        max-width: 10px !important;
    }
</style>



<div class="row">
    <div class="col col-md-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Users</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master Users</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col col-md-10">
        <div class="card">
            <div class="card-header">
                <button class="btn btn-primary" id="btnAdd">Add new user</button>
            </div>
            <div class="card-body">
                <table id="user-table" class="table table-striped table-bordered table-sm" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fullname</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Position</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        foreach ($user->result() as $data) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $data->fullname ?></td>
                                <td><?= $data->username ?></td>
                                <td><?= $data->role_name ?></td>
                                <td><?= $data->position_name ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm btnEdit" data-id="<?= $data->id ?>" data-fullname="<?= $data->fullname ?>" data-username="<?= $data->username ?>" data-role="<?= $data->role ?>" data-position="<?= $data->position_id?>">Edit</button>

                                    <?php
                                    if ($_SESSION['user_data']['user_id'] != $data->id) {
                                    ?>
                                        <button class="btn btn-danger btn-sm btnDelete" data-id="<?= $data->id ?>">Delete</button>
                                    <?php
                                    }
                                    ?>
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
                <form id="userForm">
                    <div class="row g-3">
                        <div class="col-xxl-6">
                            <div>
                                <label for="username" class="form-label">Fullname</label>
                                <input type="hidden" id="form_proses" val="" readonly>
                                <input type="hidden" id="user_id" name="user_id" val="" readonly>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter username" required>
                            </div>
                        </div>
                        <div class="col-xxl-6">
                            <div>
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                            </div>
                        </div>
                        <div class="col-xxl-6">
                            <div>
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="role" class="form-label">Role</label>
                            <div>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="">Choose role</option>
                                    <?php
                                    foreach ($role->result() as $r) {
                                    ?>
                                        <option value="<?= $r->id ?>"><?= $r->role ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="role" class="form-label">Position</label>
                            <div>
                                <select name="position" id="position" class="form-control">
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
        $('#userForm').on('submit', function(e) {
            e.preventDefault();
            let formUser = new FormData(this); // Mengambil data formulir
            let form_proses = $('#form_proses').val();

            if (form_proses === 'add_new') {
                $.ajax({
                    url: 'createUser',
                    type: 'POST',
                    data: formUser,
                    processData: false, // Pastikan untuk menonaktifkan pemrosesan data agar FormData tidak diubah
                    contentType: false, // Pastikan untuk menonaktifkan jenis konten agar FormData tidak diubah
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
                    url: 'editUser',
                    type: 'POST',
                    data: formUser,
                    processData: false, // Pastikan untuk menonaktifkan pemrosesan data agar FormData tidak diubah
                    contentType: false, // Pastikan untuk menonaktifkan jenis konten agar FormData tidak diubah
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
            $('#headerForm').text('Add new user');
            $('#form_proses').val('add_new');
            $('#username').removeAttr('readonly');
            $('#fullname').val('');
            $('#username').val('');
            $('#role').val('');
            $('#position').val('');
            $('#password').attr('required', 'required');
            $('#modalForm').modal('show');
        })

        $('#user-table').on('click', '.btnEdit', function() {
            $('#headerForm').text('Edit user');
            $('#form_proses').val('edit_user');
            $('#user_id').val($(this).data('id'));
            $('#fullname').val($(this).data('fullname'));
            $('#username').val($(this).data('username'));
            $('#position').val($(this).data('position'));
            $('#username').attr('readonly', 'readonly');
            $('#password').val('');
            $('#password').removeAttr('required');
            $('#role').val($(this).data('role'));
            $('#modalForm').modal('show');
        })

        $('#user-table').on('click', '.btnDelete', function() {
            let id = $(this).data('id');
            $.post('deleteUser', {
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