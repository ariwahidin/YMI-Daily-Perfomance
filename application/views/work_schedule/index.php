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
            <h4 class="mb-sm-0">Master work schedule</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Master work schedule</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-10">
        <div class="card">
            <div class="card-header bg-primary d-flex">
                <input type="text" class="form-control" style="display:none; width: 200px; margin-right: 10px;" id="sChecker" placeholder="Checker">
                <input type="date" class="form-control" style="width: 200px; margin-right: 10px;" id="sStartDate" placeholder="Start Date">
                <input type="date" class="form-control" style="width: 200px; margin-right: 10px;" id="sEndDate" placeholder="End Date">
                <button class="btn btn-outline-success" id="sButton"><i class="ri-filter-fill"></i></button>&nbsp;&nbsp;
                <button class="btn btn-info" id="btnAdd">Add new work schedule</button>
            </div>
            <div class="card-body table-responsive" id="divSchedule">

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
                <form id="scheduleForm">
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="name" class="form-label">Employee name</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Choosee employee</option>
                                        <?php
                                        foreach ($users->result() as $data) {
                                        ?>
                                            <option value="<?= $data->id ?>" data-position-id="<?= $data->position_id ?>"><?= $data->fullname ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <input type="hidden" id="eks_id" name="eks_id" val="" readonly>
                                    <input type="hidden" id="form_proses" name="form_proses" val="" readonly>
                                </div>
                                <div class="form-group col-6">
                                    <label for="name" class="form-label">Position</label>
                                    <select name="position_id" id="position_id" class="form-control">
                                        <option value="">Choosee Position</option>
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
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Day</label>
                                    <input type="text" class="form-control" id="day" name="day" value="<?= date('l') ?>" placeholder="" required readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="<?= date('Y-m-d') ?>" placeholder="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="name" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="start_time" value="08:00" name="start_time" placeholder="" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="name" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="end_time" value="17:00" name="end_time" placeholder="" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end pt-2">
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
        $('#scheduleForm').on('submit', function(e) {
            e.preventDefault();
            let formUser = new FormData(this);
            let form_proses = $('#form_proses').val();

            if (form_proses === 'add_new') {
                $.ajax({
                    url: 'createSchedule',
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
                                getTableSchedule();
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
                    url: 'editSchedule',
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
                                getTableSchedule();
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


        // $('#user-table').DataTable();

        $('#sButton').on('click', function() {
            getTableSchedule();
        })

        getTableSchedule();

        function getTableSchedule() {
            var today = new Date().toISOString().split('T')[0];
            if ($('#sStartDate').val() == '') {
                $('#sStartDate').val(today)
            }
            if ($('#sEndDate').val() == '') {
                $('#sEndDate').val(today)
            }

            let sDate = $('#sStartDate').val();
            let eDate = $('#sEndDate').val();

            let divTable = $('#divSchedule');
            divTable.empty();
            $.ajax({
                url: "getTableSchedule",
                type: "POST",
                data: {
                    startDate: sDate,
                    endDate: eDate
                },
                success: function(response) {
                    divTable.html(response);
                    // $('#tableCompleteActivities').DataTable({
                    //     sort: false
                    // });
                }
            });
        }

        $('#btnAdd').on('click', function() {
            getNamaHari($('#date').val());
            $('#headerForm').text('Add new work schedule');
            $('#form_proses').val('add_new');
            $('#modalForm').modal('show');
        })

        $('#divSchedule').on('click', '.btnEdit', function() {
            $('#headerForm').text('Edit work schedule');
            $('#form_proses').val('edit');
            $('#eks_id').val($(this).data('id'));
            $('#date').val($(this).data('date'));
            getNamaHari($(this).data('date'));
            $('#user_id').val($(this).data('user-id'));
            $('#start_time').val($(this).data('start-time'));
            $('#end_time').val($(this).data('end-time'));
            $('#position_id').val($(this).data('position-id'));
            $('#modalForm').modal('show');
        })

        $('#divSchedule').on('click', '.btnDelete', function() {
            let id = $(this).data('id');
            $.post('deleteSchedule', {
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

        $('#date').on('change', function() {
            let tanggal = $(this).val();
            getNamaHari(tanggal);
        })

        function getNamaHari(tanggal) {
            var dateObj = new Date(tanggal);
            var hari = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var namaHari = hari[dateObj.getDay()];
            $('#day').val(namaHari);
        }

        $('#user_id').on('change', function() {
            let position_id = $(this).children('option:selected').data('position-id');
            $('#position_id').val(position_id);
        })
    });
</script>