<link href="<?= base_url() ?>myassets/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@latest/dist/css/select2.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>myassets/js/jquery-3.7.0.js"></script>
<script src="<?= base_url() ?>myassets/js/jquery.dataTables.min.js"></script>

<style>
    .select2-container {
        z-index: 1600;
        /* Atur z-index sesuai kebutuhan */
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Outbound Task</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Outbound Task</a>
                        <span id="spConnect"></span>
                    </li>
                </ol>
            </div>

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
                                <input type="text" id="inSearch" class="form-control border-0 dash-filter-picker shadow" placeholder="Search picking list">
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-header p-3 bg-success-subtle">
                <h5 class="modal-title" id="createTaskLabel">Create Activity Outbound</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="createTaskBtn-close" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="task-error-msg" class="alert alert-danger py-2"></div>
                <form autocomplete="off" action="#" id="creatask">
                    <input type="hidden" id="proses" name="proses" class="form-control">
                    <input type="hidden" id="id_task" name="id_task" class="form-control">


                    <div class="row g-4 mb-3">
                        <div class="col col-lg-4">
                            <label for="" class="form-label">No picking list</label>
                            <select name="no_pl" id="no_pl" class="form-control" style="width: 200px; height: 50px;">
                            </select>
                            <!-- <input type="text" id="no_pl" name="no_pl" class="form-control" placeholder="" value="" required> -->
                        </div>
                        <div class="col col-lg-4">
                            <label for="" class="form-label">Picking list date</label>
                            <input type="date" id="pl_date" name="pl_date" class="form-control" placeholder="" value="" required>
                        </div>
                        <div class="col col-lg-4">
                            <label for="" class="form-label">Picking list time</label>
                            <input type="time" id="pl_time" name="pl_time" class="form-control" placeholder="" value="">
                        </div>
                    </div>

                    <div class="row g-4 mb-3">
                        <div class="col col-lg-3">
                            <label for="priority-field" class="form-label">Checker</label>
                            <select class="form-control" name="checker_id" id="checker_id" required>
                                <option value="">Choose checker</option>
                                <?php foreach ($checker->result() as $check) { ?>
                                    <option value="<?= $check->id ?>"><?= $check->fullname ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col col-lg-3">
                            <label for="priority-field" class="form-label">No truck</label>
                            <input type="text" id="no_truck" name="no_truck" class="form-control" placeholder="" value="">
                        </div>
                        <div class="col col-lg-3">
                            <label for="priority-field" class="form-label">Driver</label>
                            <input type="text" id="driver" name="driver" class="form-control" placeholder="" value="">
                        </div>
                        <div class="col col-lg-3">
                            <label for="priority-field" class="form-label">Ekspedisi</label>
                            <select class="form-control" name="ekspedisi" id="ekspedisi" required>
                                <option value="">Choose ekspedisi</option>
                                <?php foreach ($ekspedisi->result() as $eks) { ?>
                                    <option value="<?= $eks->id ?>"><?= $eks->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row g-4 mb-3">
                        <div class="col col-lg-4">
                            <label for="priority-field" class="form-label">Qty</label>
                            <input type="number" id="qty" name="qty" class="form-control" placeholder="" value="">
                        </div>
                        <div class="col-lg-8">
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

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/select2@latest/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        var socket;
        getAllRowTask();
        initWebSocket();



        // $('#createTask').modal('show');

        $('#btnCreate').on('click', function() {



            $.get('getPickingListAdm', {}, function(response) {

                if (response.success == true) {
                    let selPL = $('#no_pl');
                    selPL.empty();

                    let opt = `<option value="">Choose Picking Listss </option>`;
                    response.picking_list.forEach(function(elem) {
                        opt += `<option value="${elem.id}">${elem.pl_no}</option>`;
                    });
                    selPL.html(opt);;

                    // console.log(opt);
                    // .select2();
                    $('#no_pl').select2({
                        tags: true,
                        dropdownParent: $("#createTask")
                    });

                    $('#btnTask').text('Create');
                    $('#createTaskLabel').text('Create new');
                    $('#proses').val('new_task');
                    $('#createTask').modal('show');

                    // $('#createTask').on('shown.bs.modal', function() {
                    //     // $('.js-example-basic-single').select2('open');
                    //     $('.js-example-basic-single').focus();

                    // });
                }
            }, 'json');

        });

        $('#no_pl').on('change', function() {
            let id = $(this).val();
            if (id != '') {
                $.post('getPickingListAdmById', {
                    id: id
                }, function(response) {
                    let data = response.picking_list;
                    $('#no_truck').val(data.no_truck);
                    $('#qty').val(data.tot_qty);
                }, 'json');
            }
        })

        function initWebSocket() {
            let hostname = window.location.hostname;
            // console.log(hostname);
            socket = new WebSocket('ws://' + hostname + ':8001');

            socket.onopen = function() {
                $('#spConnect').html(`<i class="ri-swap-box-fill"></i>`);
                // console.log('WebSocket connection opened');
                socket.send('ping');
            };

            socket.onmessage = function(event) {
                // console.log('Received message: ' + event.data);
                getAllRowTask();
            };

            socket.onclose = function(event) {
                $('#spConnect').html(`<i class="ri-alert-fill"></i>`);
                // console.log('WebSocket connection closed');
                // Try to re-initiate connection after a delay
                setTimeout(initWebSocket, 5000); // Retry after 5 seconds
            };

            socket.onerror = function(error) {
                console.error('WebSocket error: ' + error);
                // Handle WebSocket error, if necessary
            };
        }

        // $("input[type='text']").on("input", function() {
        //     $(this).val($(this).val().toUpperCase());
        // });

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
                            socket.send('ping');
                            $('#createTask').modal('hide');
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

        // $('#btnCreate').on('click', function() {
        //     moment.tz.setDefault('Asia/Jakarta');
        //     let today = moment().format('YYYY-MM-DD');
        //     let currentTime = moment().format('HH:mm')
        //     $('#send_date').val(today);
        //     $('#sj_date').val(today);

        //     $('#sj_time').val(currentTime);
        //     $('#toa').val(currentTime);

        //     $('#createTaskLabel').text('Create new task');
        //     $('#btnTask').text('Submit');
        //     $('#proses').val('new_task');
        //     $('#createTask').modal('show');
        // })

        $('#content').on('click', '.btnEdit', async function() {
            startLoading();
            let id = $(this).data('id');
            let result = await $.post('getTaskById', {
                id: id
            }, function(response) {
                let task = response.data;
                $('#proses').val('edit_task');
                $('#id_task').val(id);
                $('#no_pl').val(task.no_pl);
                $('#pl_date').val(task.pl_date);
                $('#pl_time').val(formatTime(task.pl_time));
                $('#ekspedisi').val(task.ekspedisi);
                $('#no_truck').val(task.no_truck);
                $('#qty').val(task.qty);
                $('#checker_id').val(task.checker_id);
                // $('#sj_date').val(task.sj_date);
                // $('#sj_time').val(task.sj_time);
                $('#driver').val(task.driver);
                $('#remarks').val(task.remarks);
                // $('#send_date').val(task.sj_send_date);
                // $('#toa').val(task.time_arival);
                // $('#pintu_unloading').val(task.pintu_unloading);
                $('#btnTask').text('Edit');
                $('#createTaskLabel').text('Edit task');
                $('#createTask').modal('show');
                stopLoading();
            }, 'json');
        })

        $('#content').on('click', '.btnDelete', function() {
            startLoading();
            let id = $(this).data('id');
            $.post('deleteOut', {
                id: id
            }, function(response) {
                stopLoading();
                if (response.success == true) {
                    getAllRowTask();
                    socket.send('ping');
                }
            }, 'json');

        });

        $('#content').on('click', '.btnActivity', function() {
            startLoading();
            let dataToPost = {
                id: $(this).data('id'),
                proses: $(this).data('proses')
            };

            $.post('prosesActivity', dataToPost, function(response) {
                if (response.success == true) {
                    stopLoading();
                    getAllRowTask();
                    socket.send('ping');
                }
            }, 'json');
        })

        $('#btnSearch').on('click', getAllRowTask);

        // function startUnloading(id) {
        //     startLoading();
        //     $.post('startUnloading', {
        //         id
        //     }, function(response) {
        //         stopLoading();
        //         if (response.success == false) {
        //             Swal.fire({
        //                 icon: 'warning',
        //                 title: response.message,
        //                 showCancelButton: true,
        //                 confirmButtonText: "Reload",
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'task'
        //                 }
        //             });
        //         } else {
        //             getAllRowTask();
        //             socket.send('ping');
        //         }
        //     }, 'json');
        // }

        // function stopUnloading(id) {
        //     startLoading();
        //     $.post('stopUnloading', {
        //         id
        //     }, function(response) {
        //         stopLoading();
        //         if (response.success == false) {
        //             Swal.fire({
        //                 icon: 'warning',
        //                 title: response.message,
        //                 showCancelButton: true,
        //                 confirmButtonText: "Reload",
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'task'
        //                 }
        //             });
        //         } else {
        //             getAllRowTask();
        //             socket.send('ping');
        //         }
        //     }, 'json');
        // }

        // $('#content').on('click', '.btnChecking', function() {
        //     let id = $(this).data('id');
        //     let proses = $(this).data('proses');
        //     if (proses === 'start_checking') {
        //         startChecking(id);
        //     } else {
        //         stopChecking(id);
        //     }
        // })

        // function startChecking(id) {
        //     startLoading();
        //     $.post('startChecking', {
        //         id
        //     }, function(response) {
        //         stopLoading();
        //         if (response.success == false) {
        //             Swal.fire({
        //                 icon: 'warning',
        //                 title: response.message,
        //                 showCancelButton: true,
        //                 confirmButtonText: "Reload",
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'task'
        //                 }
        //             });
        //         } else {
        //             getAllRowTask();
        //             socket.send('ping');
        //         }
        //     }, 'json');
        // }

        // function stopChecking(id) {
        //     startLoading();
        //     $.post('stopChecking', {
        //         id
        //     }, function(response) {
        //         stopLoading();
        //         if (response.success == false) {
        //             Swal.fire({
        //                 icon: 'warning',
        //                 title: response.message,
        //                 showCancelButton: true,
        //                 confirmButtonText: "Reload",
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'task'
        //                 }
        //             });
        //         } else {
        //             getAllRowTask();
        //             socket.send('ping');
        //         }
        //     }, 'json');
        // }

        // $('#content').on('click', '.btnPutaway', function() {
        //     let id = $(this).data('id');
        //     let proses = $(this).data('proses');
        //     if (proses === 'start_putaway') {
        //         startPutaway(id);
        //     } else {
        //         stopPutaway(id);
        //     }
        // })

        // function startPutaway(id) {
        //     startLoading();
        //     $.post('startPutaway', {
        //         id
        //     }, function(response) {
        //         stopLoading();
        //         if (response.success == false) {
        //             Swal.fire({
        //                 icon: 'warning',
        //                 title: response.message,
        //                 showCancelButton: true,
        //                 confirmButtonText: "Reload",
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'task'
        //                 }
        //             });
        //         } else {
        //             getAllRowTask();
        //             socket.send('ping');
        //         }
        //     }, 'json');
        // }

        // function stopPutaway(id) {
        //     startLoading();
        //     $.post('stopPutaway', {
        //         id
        //     }, function(response) {
        //         stopLoading();
        //         if (response.success == false) {
        //             Swal.fire({
        //                 icon: 'warning',
        //                 title: response.message,
        //                 showCancelButton: true,
        //                 confirmButtonText: "Reload",
        //             }).then((result) => {
        //                 if (result.isConfirmed) {
        //                     window.location.href = 'task'
        //                 }
        //             });
        //         } else {
        //             getAllRowTask();
        //             socket.send('ping');
        //         }
        //     }, 'json');
        // }

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

        function formatTime(timeString) {
            var timeComponents = timeString.split(':');

            if (timeComponents.length !== 3) {
                return 'Invalid time format';
            }

            var hours = parseInt(timeComponents[0]);
            var minutes = parseInt(timeComponents[1]);
            var seconds = parseInt(timeComponents[2]);

            if (isNaN(hours) || isNaN(minutes) || isNaN(seconds)) {
                return 'Invalid time format';
            }

            hours = (hours < 10) ? '0' + hours : hours;
            minutes = (minutes < 10) ? '0' + minutes : minutes;
            seconds = (seconds < 10) ? '0' + seconds : seconds;

            var formattedTime = hours + ':' + minutes + ':' + seconds;

            return formattedTime;
        }

        // function updateClock() {
        //     var currentDate = new Date();
        //     var hours = currentDate.getHours().toString().padStart(2, '0');
        //     var minutes = currentDate.getMinutes().toString().padStart(2, '0');
        //     var seconds = currentDate.getSeconds().toString().padStart(2, '0');
        //     var day = currentDate.getDate().toString().padStart(2, '0');
        //     var month = (currentDate.getMonth() + 1).toString().padStart(2, '0'); // Bulan dimulai dari 0
        //     var year = currentDate.getFullYear();

        //     var dateString = year + '-' + month + '-' + day;
        //     var timeString = hours + ':' + minutes + ':' + seconds;
        //     var dateTimeString = dateString + ' ' + timeString;

        //     document.getElementById('clock').innerText = dateTimeString;
        // }

        // function keepAlive() {
        //     $.post('keepAlive', {}, function(response) {
        //         console.log(response);
        //     }, 'json');
        // }

        // setInterval(keepAlive, 180000);
        // setInterval(updateClock, 1000);
        // updateClock();
    });
</script>