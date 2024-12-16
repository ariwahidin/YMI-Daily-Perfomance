<style>
    /* table tr td {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    } */
</style>

<link href="<?= base_url() ?>myassets/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>myassets/js/jquery-3.7.0.js"></script>
<script src="<?= base_url() ?>myassets/js/jquery.dataTables.min.js"></script>


<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Report Inbound</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                </ol>
            </div>

        </div>
    </div>
</div>


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


                    <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <label for="priority-field" class="form-label">Factory Code</label>
                            <!-- <input type="text" id="factory" name="factory" class="form-control" value=""> -->
                            <select class="form-control" name="factory" id="factory" required>
                                <option value="">Choose Factory</option>
                                <?php foreach ($factory->result() as $f) { ?>
                                    <option value="<?= $f->id ?>"><?= $f->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col col-lg-3 col-xs-6">
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

                    <div class="row form-group">
                        <div class="col col-lg-3 col-xs-6">
                            <label for="task-status" class="form-label">No Truck</label>
                            <!-- <input type="text" id="no_truck" name="no_truck" class="form-control" value=""> -->
                            <select class="form-control" name="no_truck" id="no_truck" required>
                                <option value="">Choose No Truck</option>
                                <?php foreach ($ekspedisi->result() as $e) { ?>
                                    <option value="<?= $e->no_truck ?>" data-id="<?= $e->id ?>"> <?= $e->no_truck ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col col-lg-3 col-xs-6">
                            <label for="priority-field" class="form-label">Expedisi</label>
                            <select class="form-control" name="expedisi" id="expedisi" required>
                                <option value="">Choose Ekspedisi</option>
                                <?php foreach ($ekspedisi->result() as $e) { ?>
                                    <option value="<?= $e->id ?>"><?= $e->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3 col-6">
                            <label for="priority-field" class="form-label">Driver</label>
                            <input type="text" id="driver" name="driver" class="form-control" placeholder="" value="">
                        </div>
                        <div class="form-group col-lg-3 col-6">
                            <label for="" class="form-label">Unloading Sequence Number</label>
                            <input type="number" id="unloading_sequence" name="unloading_sequence" class="form-control" placeholder="" value="" required>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-6 col-lg-3">
                            <label for="task-status" class="form-label">Alocation Code</label>
                            <input type="text" id="alocation" name="alocation" class="form-control" value="">
                        </div>
                        <div class="col-6 col-lg-3">
                            <label for="task-assign-input" class="form-label">Pintu Unloading</label>
                            <input type="text" id="pintu_unloading" name="pintu_unloading" class="form-control" value="">
                        </div>
                        <div class="col-6 col-lg-3">
                            <label for="task-status" class="form-label">Qty</label>
                            <input type="number" id="qty" name="qty" class="form-control" placeholder="" value="">
                        </div>
                        <div class="col-6 col-lg-3">
                            <label for="task-status" class="form-label">Time of arival</label>
                            <input type="time" id="toa" name="toa" class="form-control" placeholder="" value="">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col col-lg-3">
                            <label for="task-assign-input" class="form-label">Checker</label>
                            <select class="form-control" name="checker" id="checker" required>
                                <option value="">Choose Checker</option>
                                <?php foreach ($checker->result() as $c) { ?>
                                    <option value="<?= $c->id ?>"><?= $c->fullname ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col col-lg-3">
                            <label for="" class="form-label">Activity Date</label>
                            <input type="date" id="activity_date" name="activity_date" class="form-control" value="" required>
                        </div>

                        <div class="col-lg-6">
                            <label for="priority-field" class="form-label">Remarks</label>
                            <input type="text" id="remarks" name="remarks" class="form-control" value="">
                        </div>
                    </div>
                    <br>
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-ghost-success" data-bs-dismiss="modal"><i class="ri-close-fill align-bottom"></i> Close</button>
                        <button type="submit" class="btn btn-primary" id="btnTask">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





<div class="row" id="reportContent">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header bg-primary align-items-center d-flex">
                <!-- <h4 class="card-title mb-0 flex-grow-1">Completed Activities</h4> -->
                <input type="text" class="form-control" style="display:none; width: 200px; margin-right: 10px;" id="sChecker" placeholder="Checker">
                <input type="date" class="form-control" style="width: 200px; margin-right: 10px;" id="sStartDate" placeholder="Start Date">
                <input type="date" class="form-control" style="width: 200px; margin-right: 10px;" id="sEndDate" placeholder="End Date">
                <button class="btn btn-outline-success" id="sButton"><i class="ri-filter-fill"></i></button>
                <button style="margin-left: 10px;" class="btn btn-outline-success" id="btnExcel">Excel</button>
            </div>

            <div class="card-body">
                <!-- <p class="text-muted">Use <code>table</code> class to show bootstrap-based default table.</p> -->
                <div class="live-preview">
                    <div class="table-responsive" id="tablePlace">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="<?= base_url() ?>myassets/js/exceljs.min.js"></script>


<script>
    $(document).ready(function() {
        getRowComplete();

        $('#sButton').on('click', function() {
            let checker = $('#sChecker').val().trim();
            let startDate = $('#sStartDate').val().trim();
            let endDate = $('#sEndDate').val().trim();
            let dataToPost = {
                checker: checker,
                startDate: startDate,
                endDate: endDate
            }
            getRowComplete(dataToPost);
        })

        $('#tablePlace').on('click', '.btnEdit', async function() {
            startLoading();
            let id = $(this).data('id');
            let result = await $.post('getTaskCompleteById', {
                id: id
            }, function(response) {}, 'json');

            // alert('test')

            let task = result.task;
            $('#proses').val('edit_task');
            $('#id_task').val(id);
            $('#checker').val(task.checker_id);
            $('#alocation').val(task.alloc_code);
            $('#factory').val(task.factory_code);
            $('#expedisi').val(task.ekspedisi);
            $('#no_truck').val(task.no_truck);
            $('#qty').val(task.qty);
            $('#sj').val(task.no_sj);
            $('#sj_date').val(task.sj_date);
            $('#send_date').val(task.sj_send_date);
            $('#toa').val(task.time_arival);
            $('#sj_time').val(task.sj_time);
            $('#driver').val(task.driver);
            $('#remarks').val(task.remarks);
            $('#pintu_unloading').val(task.pintu_unloading);
            $('#btnTask').text('Edit');
            $('#unloading_sequence').val(task.unload_seq);
            $('#activity_date').val(task.activity_date);
            $('#createTaskLabel').text('Edit task');
            stopLoading();
            $('#createTask').modal('show');
        });

        $('#creatask').on('submit', function(e) {
            e.preventDefault();
            let form = new FormData(this);
            let proses = $('#proses').val();
            $.ajax({
                url: 'editTaskCompleted',
                type: 'POST',
                data: form,
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(response) {
                    if (response.success == true) {
                        getRowComplete();
                        $('#createTask').modal('hide');
                    }
                }
            });
        })




        $('#tablePlace').on('click', '.btnDelete', function() {
            let id = $(this).data('id');
            Swal.fire({
                icon: 'question',
                title: "Are you sure to delete this activity?",
                showCancelButton: true,
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('deleteCompleteActivity', {
                        id: id
                    }, function(response) {
                        if (response.success == true) {
                            Swal.fire("Deleted!", "", "success");
                            getRowComplete();
                        }
                    }, 'json');
                } else if (result.isDenied) {
                    Swal.fire("Changes are not saved", "", "info");
                }
            });
        })

        $('#btnExcel').on('click', downloadExcel);

        function downloadExcel() {
            startLoading();
            setTimeout(async function() {
                    stopLoading();
                    let checker = $('#sChecker').val().trim();
                    let startDate = $('#sStartDate').val().trim();
                    let endDate = $('#sEndDate').val().trim();
                    let dataToPost = {
                        checker: checker,
                        startDate: startDate,
                        endDate: endDate
                    }
                    let dataAct = await $.post('getDataExcel', dataToPost, function() {}, 'json');

                    var headers = Object.keys(dataAct.data[0]);
                    var workbook = new ExcelJS.Workbook();
                    var sheet1 = workbook.addWorksheet('Sheet 1');


                    sheet1.addRow(headers).eachCell(function(row, rowNumber) {
                        row.fill = {
                            type: 'pattern',
                            pattern: 'solid',
                            fgColor: {
                                argb: 'FFFF00'
                            }
                        };
                    });

                    // Menentukan lebar kolom berdasarkan isi
                    sheet1.columns.forEach(function(column) {
                        var maxLength = 0;
                        column.eachCell(function(cell) {
                            var columnLength = cell.value ? cell.value.toString().length : 10;
                            if (columnLength > maxLength) {
                                maxLength = columnLength;
                            }
                        });
                        column.width = maxLength < 10 ? 10 : maxLength;
                    });

                    // Menambahkan border ke seluruh tabel
                    sheet1.eachRow(function(row) {
                        row.eachCell(function(cell) {
                            cell.border = {
                                top: {
                                    style: 'thin'
                                },
                                left: {
                                    style: 'thin'
                                },
                                bottom: {
                                    style: 'thin'
                                },
                                right: {
                                    style: 'thin'
                                }
                            };
                        });
                    });



                    dataAct.data.forEach(function(row, ) {
                        var rowData = headers.map(function(header) {
                            return row[header];
                        });
                        sheet1.addRow(rowData);
                        // Menentukan lebar kolom berdasarkan isi
                        sheet1.columns.forEach(function(column) {
                            var maxLength = 0;
                            column.eachCell(function(cell) {
                                var columnLength = cell.value ? cell.value.toString().length : 10;
                                if (columnLength > maxLength) {
                                    maxLength = columnLength;
                                }
                            });
                            column.width = maxLength < 10 ? 10 : maxLength;
                        });

                        // Menambahkan border ke seluruh tabel
                        sheet1.eachRow(function(row) {
                            row.eachCell(function(cell) {
                                cell.border = {
                                    top: {
                                        style: 'thin'
                                    },
                                    left: {
                                        style: 'thin'
                                    },
                                    bottom: {
                                        style: 'thin'
                                    },
                                    right: {
                                        style: 'thin'
                                    }
                                };
                            });
                        });
                    });

                    workbook.xlsx.writeBuffer().then(function(buffer) {
                        var blob = new Blob([buffer], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });
                        var url = window.URL.createObjectURL(blob);
                        var a = document.createElement('a');
                        a.href = url;
                        a.download = 'YMI Daily Performance.xlsx';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                    });
                },
                3000);
        }

        function getRowComplete() {
            var today = new Date().toISOString().split('T')[0];
            if ($('#sStartDate').val() == '') {
                $('#sStartDate').val(today)
            }
            if ($('#sEndDate').val() == '') {
                $('#sEndDate').val(today)
            }

            let sDate = $('#sStartDate').val();
            let eDate = $('#sEndDate').val();

            let divTable = $('#tablePlace')
            divTable.empty();
            $.ajax({
                url: "tableReport",
                type: "POST",
                data: {
                    startDate: sDate,
                    endDate: eDate
                },
                success: function(data) {
                    divTable.html(data);
                    $('#tableCompleteActivities').DataTable({
                        sort: false,
                        paginate: false,
                        fixedHeader: true,
                        scrollY: 400, // Tinggi area scrolling
                        scrollCollapse: true
                    });
                }
            });
        }
    })
</script>
<script>
    // function getRowComplete(dataToPost = null) {
    //     var today = new Date().toISOString().split('T')[0];
    //     let date;
    //     if (dataToPost != null) {
    //         date = $('#sStartDate').val() + ' until ' + $('#sEndDate').val();
    //     } else {
    //         date = today + ' until ' + today;
    //     }

    //     let excelName = 'YMI Daily Activity ' + date;
    //     $.ajax({
    //         url: "<?= base_url('inbound/getRowCompleteAct') ?>",
    //         type: "POST",
    //         data: dataToPost,
    //         success: function(data) {

    //             if (tableComlpeteActivity != null) {
    //                 tableComlpeteActivity.destroy();
    //             }
    //             $("#tableCompleteActivities tbody").html(data);

    //             tableComlpeteActivity = $('#tableCompleteActivities').DataTable();
    //         }
    //     });
    // }

    // function formatTime(time) {
    //     var hours = time.getHours();
    //     var minutes = time.getMinutes();
    //     var seconds = time.getSeconds();

    //     minutes = minutes < 10 ? '0' + minutes : minutes;
    //     seconds = seconds < 10 ? '0' + seconds : seconds;

    //     return hours + ':' + minutes + ':' + seconds;
    // }

    // function formatDateTime(time) {
    //     let year = time.getFullYear();
    //     let month = String(time.getMonth() + 1).padStart(2, '0');
    //     let day = String(time.getDate()).padStart(2, '0');
    //     let hours = String(time.getHours()).padStart(2, '0');
    //     let minutes = String(time.getMinutes()).padStart(2, '0');
    //     let seconds = String(time.getSeconds()).padStart(2, '0');
    //     let formattedTime = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    //     return formattedTime;
    // }

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

    // setTimeout(stopLoading, 1250);
    // setInterval(keepAlive, 180000);
    // setInterval(updateClock, 1000);
    // updateClock();
</script>