<link href="<?= base_url() ?>myassets/css/select2.min.css" rel="stylesheet" />
<link href="<?= base_url() ?>myassets/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>myassets/js/jquery-3.7.0.js"></script>
<script src="<?= base_url() ?>myassets/js/jquery.dataTables.min.js"></script>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Inbound Task</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inbound Task </a>
                        <span id="spConnect"></span>
                    </li>
                </ol>
            </div>

            <!-- <div class="page-title-right">
                <ol class="breadcrumb m-0">
                </ol>
            </div> -->

        </div>
    </div>
</div>

<div class="row mb-3 pb-1">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <h4 class="card-title mb-0 flex-grow-1"><strong id="clock"></strong></h4>
                <!-- <h4 class="fs-16 mb-1">Hi , <?= $_SESSION['user_data']['fullname'] ?></h4> -->
                <!-- <p class="text-muted mb-0">This is a task that you must complete.</p> -->
            </div>
            <div class="mt-3 mt-lg-0">
                <form action="javascript:void(0);">
                    <div class="row">
                        <div class="col-sm-auto">
                            <div class="input-group">
                                <input type="text" id="inSearch" class="form-control border-0 dash-filter-picker shadow" placeholder="Search SJ">
                                <button class="btn btn-primary border-primary text-white" id="btnSearch">
                                    <i class="ri-search-2-line"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <?php if ($_SESSION['user_data']['role'] != 4) { ?>
                <div class="mt-3 ms-3 mt-lg-0">
                    <button class="btn btn-primary" id="btnCreate">Create new task</button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div id="content"></div>


<div class="modal fade" id="createTask" tabindex="-1" aria-labelledby="createTaskLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-success-subtle">
                <h5 class="modal-title" id="createTaskLabel">Create Activity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="createTaskBtn-close" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="task-error-msg" class="alert alert-danger py-2"></div>
                <form autocomplete="off" action="#" id="creatask">
                    <input type="hidden" id="proses" name="proses" class="form-control">
                    <input type="hidden" id="id_task" name="id_task" class="form-control">


                    <div class="row g-4 mb-3">
                        <div class="col col-lg-3">
                            <label for="priority-field" class="form-label">Factory Code</label>
                            <!-- <input type="text" id="factory" name="factory" class="form-control" value=""> -->
                            <select class="form-control" name="factory" id="factory" required>
                                <option value="">Choose Factory</option>
                                <?php foreach ($factory->result() as $f) { ?>
                                    <option value="<?= $f->id ?>"><?= $f->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col col-lg-3">
                            <label for="task-title-input" class="form-label">SJ No</label>
                            <input type="text" id="sj" name="sj" class="form-control" placeholder="" value="" required>
                        </div>
                        <div class="col col-lg-2">
                            <label for="task-title-input" class="form-label">SJ Send Date</label>
                            <input type="date" id="send_date" name="send_date" class="form-control" placeholder="" value="" required>
                        </div>
                        <div class="col col-lg-2">
                            <label for="priority-field" class="form-label">SJ Date</label>
                            <input type="date" id="sj_date" name="sj_date" class="form-control" placeholder="" value="">
                        </div>
                        <div class="col col-lg-2">
                            <label for="priority-field" class="form-label">SJ Time</label>
                            <input type="time" id="sj_time" name="sj_time" class="form-control" placeholder="" value="">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col col-lg-3">
                            <label for="task-status" class="form-label">No Truck</label>
                            <!-- <input type="text" id="no_truck" name="no_truck" class="form-control" value=""> -->
                            <select class="form-control" name="no_truck" id="no_truck" required>
                                <option value="">Choose No Truck</option>
                                <?php foreach ($ekspedisi->result() as $e) { ?>
                                    <option value="<?= $e->no_truck ?>" data-id="<?= $e->id ?>"> <?= $e->no_truck ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col col-lg-3">
                            <label for="priority-field" class="form-label">Expedisi</label>
                            <select class="form-control" name="expedisi" id="expedisi" required>
                                <option value="">Choose Ekspedisi</option>
                                <?php foreach ($ekspedisi->result() as $e) { ?>
                                    <option value="<?= $e->id ?>"><?= $e->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col col-lg-3">
                            <label for="priority-field" class="form-label">Driver</label>
                            <input type="text" id="driver" name="driver" class="form-control" placeholder="" value="">
                        </div>
                        <div class="col col-lg-3">
                            <label for="" class="form-label">Unloading Sequence Number</label>
                            <input type="number" id="unloading_sequence" name="unloading_sequence" class="form-control" placeholder="" value="" required>
                        </div>
                    </div>

                    <div class="mb-3 position-relative row">

                        <div class="col col-lg-3">
                            <label for="task-status" class="form-label">Alocation Code</label>
                            <input type="text" id="alocation" name="alocation" class="form-control" value="">
                        </div>
                        <div class="col col-lg-3">
                            <label for="task-assign-input" class="form-label">Pintu Unloading</label>
                            <input type="text" id="pintu_unloading" name="pintu_unloading" class="form-control" value="">
                        </div>
                        <div class="col col-lg-3">
                            <label for="task-status" class="form-label">Qty</label>
                            <input type="number" id="qty" name="qty" class="form-control" placeholder="" value="">
                        </div>
                        <div class="col col-lg-3">
                            <label for="task-status" class="form-label">Time of arival</label>
                            <input type="time" id="toa" name="toa" class="form-control" placeholder="" value="">
                        </div>
                    </div>

                    <div class="row g-4 mb-3">
                        <div class="col col-lg-3">
                            <label for="task-assign-input" class="form-label">Checker</label>
                            <select class="form-control" name="checker" id="checker" required>
                                <option value="">Choose Checker</option>
                                <?php foreach ($checker->result() as $c) { ?>
                                    <option value="<?= $c->id ?>"><?= $c->fullname ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label for="priority-field" class="form-label">Remarks</label>
                            <input type="text" id="remarks" name="remarks" class="form-control" value="">
                        </div>
                    </div>

                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-ghost-success" data-bs-dismiss="modal"><i class="ri-close-fill align-bottom"></i> Close</button>
                        <button type="submit" class="btn btn-primary" id="btnTask">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>myassets/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        $('#no_truck').select2({
            tags: true,
            dropdownParent: $("#createTask")
        });

        $('#no_truck').on('change', function() {
            let kode = $(this).val();
            let id = $(this).children('option:selected').data('id');
            // console.log(id);
            $('#expedisi').val(id);
        })


        var socket;
        getAllRowTask();
        initWebSocket();

        function initWebSocket() {
            let hostname = window.location.hostname;
            // console.log(hostname);
            socket = new WebSocket('ws://' + hostname + ':8001');

            socket.onopen = function() {
                $('#spConnect').html(`<i class="ri-swap-box-fill"></i>`);
                console.log('WebSocket connection opened');
                socket.send('ping');
            };

            socket.onmessage = function(event) {
                console.log('Received message: ' + event.data);
                getAllRowTask();
            };

            socket.onclose = function(event) {
                $('#spConnect').html(`<i class="ri-alert-fill"></i>`);
                console.log('WebSocket connection closed');
                // Try to re-initiate connection after a delay
                setTimeout(initWebSocket, 5000); // Retry after 5 seconds
            };

            socket.onerror = function(error) {
                console.error('WebSocket error: ' + error);
                // Handle WebSocket error, if necessary
            };
        }

        $("input[type='text']").on("input", function() {
            $(this).val($(this).val().toUpperCase());
        });

        $("#creatask").on("keypress", "input", function(event) {
            if (event.which === 13) {
                event.preventDefault(); // Prevent default behavior of Enter key
                var inputs = $(this).closest("form").find(":input");
                var index = inputs.index(this);

                // Find next empty input field
                for (var i = index + 1; i < inputs.length; i++) {
                    if ($(inputs[i]).is(":text") && $(inputs[i]).val() === '') {
                        $(inputs[i]).focus();
                        break;
                    }
                }
            }
        });

        $('#creatask').on('submit', function(e) {
            e.preventDefault();
            let form = new FormData(this);
            let proses = $('#proses').val();
            if (proses === 'new_task') {
                $.ajax({
                    url: 'createTask',
                    type: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.success == true) {
                            getAllRowTask();
                            $('#createTask').modal('hide');
                            socket.send('ping');
                        }
                    }
                });
            } else {
                $.ajax({
                    url: 'editTask',
                    type: 'POST',
                    data: form,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.success == true) {
                            getAllRowTask();
                            $('#createTask').modal('hide');
                            socket.send('ping');
                        }
                    }
                });
            }

        })

        $('#btnCreate').on('click', function() {
            moment.tz.setDefault('Asia/Jakarta');
            let today = moment().format('YYYY-MM-DD');
            let currentTime = moment().format('HH:mm')
            $('#send_date').val(today);
            $('#sj_date').val(today);

            $('#sj_time').val(currentTime);
            $('#toa').val(currentTime);

            $('#createTaskLabel').text('Create new task');
            $('#btnTask').text('Submit');
            $('#proses').val('new_task');
            $('#createTask').modal('show');
        })

        $('#content').on('click', '.btnEdit', async function() {
            startLoading();
            let id = $(this).data('id');
            let result = await $.post('getTaskById', {
                id: id
            }, function(response) {}, 'json');

            let task = result.task;
            $('#proses').val('edit_task');
            $('#id_task').val(id);
            $('#checker').val(task.checker_id);
            $('#alocation').val(task.alloc_code);
            $('#factory').val(task.factory_code);
            $('#expedisi').val(task.ekspedisi);
            $('#no_truck').val(task.no_truck);
            $('#qty').val(task.qty);
            $('#unloading_sequence').val(task.unload_seq);
            $('#sj').val(task.no_sj);
            $('#sj_date').val(task.sj_date);
            $('#sj_time').val(task.sj_time);
            $('#driver').val(task.driver);
            $('#remarks').val(task.remarks);
            $('#send_date').val(task.sj_send_date);
            $('#toa').val(task.time_arival);
            $('#pintu_unloading').val(task.pintu_unloading);
            $('#btnTask').text('Edit');
            $('#createTaskLabel').text('Edit task');
            $('#createTask').modal('show');
            stopLoading();
        })

        $('#content').on('click', '.btnDelete', function() {
            startLoading();
            let id = $(this).data('id');
            $.post('deleteTransTemp', {
                id: id
            }, function(response) {
                stopLoading();
                if (response.success == true) {
                    getAllRowTask();
                    socket.send('ping');
                }
            }, 'json');

        });

        $('#content').on('click', '.btnUnloading', function() {
            let id = $(this).data('id');
            let proses = $(this).data('proses');
            if (proses === 'start_unloading') {
                startUnloading(id);
            } else {
                stopUnloading(id);
            }
        })

        $('#btnSearch').on('click', getAllRowTask);

        function startUnloading(id) {
            startLoading();
            $.post('startUnloading', {
                id
            }, function(response) {
                stopLoading();
                if (response.success == false) {
                    Swal.fire({
                        icon: 'warning',
                        title: response.message,
                        showCancelButton: true,
                        confirmButtonText: "Reload",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'task'
                        }
                    });
                } else {
                    getAllRowTask();
                    socket.send('ping');
                }
            }, 'json');
        }

        function stopUnloading(id) {
            startLoading();
            $.post('stopUnloading', {
                id
            }, function(response) {
                stopLoading();
                if (response.success == false) {
                    Swal.fire({
                        icon: 'warning',
                        title: response.message,
                        showCancelButton: true,
                        confirmButtonText: "Reload",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'task'
                        }
                    });
                } else {
                    getAllRowTask();
                    socket.send('ping');
                }
            }, 'json');
        }

        $('#content').on('click', '.btnChecking', function() {
            let id = $(this).data('id');
            let proses = $(this).data('proses');
            if (proses === 'start_checking') {
                startChecking(id);
            } else {
                stopChecking(id);
            }
        })

        function startChecking(id) {
            startLoading();
            $.post('startChecking', {
                id
            }, function(response) {
                stopLoading();
                if (response.success == false) {
                    Swal.fire({
                        icon: 'warning',
                        title: response.message,
                        showCancelButton: true,
                        confirmButtonText: "Reload",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'task'
                        }
                    });
                } else {
                    getAllRowTask();
                    socket.send('ping');
                }
            }, 'json');
        }

        function stopChecking(id) {
            startLoading();
            $.post('stopChecking', {
                id
            }, function(response) {
                stopLoading();
                if (response.success == false) {
                    Swal.fire({
                        icon: 'warning',
                        title: response.message,
                        showCancelButton: true,
                        confirmButtonText: "Reload",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'task'
                        }
                    });
                } else {
                    getAllRowTask();
                    socket.send('ping');
                }
            }, 'json');
        }

        $('#content').on('click', '.btnPutaway', function() {
            let id = $(this).data('id');
            let proses = $(this).data('proses');
            if (proses === 'start_putaway') {
                startPutaway(id);
            } else {
                stopPutaway(id);
            }
        })

        function startPutaway(id) {
            startLoading();
            $.post('startPutaway', {
                id
            }, function(response) {
                stopLoading();
                if (response.success == false) {
                    Swal.fire({
                        icon: 'warning',
                        title: response.message,
                        showCancelButton: true,
                        confirmButtonText: "Reload",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'task'
                        }
                    });
                } else {
                    getAllRowTask();
                    socket.send('ping');
                }
            }, 'json');
        }

        function stopPutaway(id) {
            startLoading();
            $.post('stopPutaway', {
                id
            }, function(response) {
                stopLoading();
                if (response.success == false) {
                    Swal.fire({
                        icon: 'warning',
                        title: response.message,
                        showCancelButton: true,
                        confirmButtonText: "Reload",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'task'
                        }
                    });
                } else {
                    getAllRowTask();
                    socket.send('ping');
                }
            }, 'json');
        }

        function getAllRowTask() {
            let search = $('#inSearch').val();
            $.post('getAllRowTask', {
                search
            }, function(response) {
                let content = $('#content');
                content.empty();
                content.html(response)
            });
        }

        function updateClock() {
            var currentDate = new Date();
            var hours = currentDate.getHours().toString().padStart(2, '0');
            var minutes = currentDate.getMinutes().toString().padStart(2, '0');
            var seconds = currentDate.getSeconds().toString().padStart(2, '0');
            var day = currentDate.getDate().toString().padStart(2, '0');
            var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Bulan dimulai dari 0
            var year = currentDate.getFullYear();

            var dateString = year + '-' + month + '-' + day;
            var timeString = hours + ':' + minutes + ':' + seconds;
            var dateTimeString = dateString + ' ' + timeString;

            document.getElementById('clock').innerText = dateTimeString;
        }

        function keepAlive() {
            $.post('keepAlive', {}, function(response) {
                console.log(response);
            }, 'json');
        }

        setInterval(keepAlive, 180000);
        setInterval(updateClock, 1000);
        updateClock();
    });
</script>