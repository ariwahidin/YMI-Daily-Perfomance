<style>
    table tr td {
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
</style>

<link href="<?= base_url() ?>myassets/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>myassets/js/jquery-3.7.0.js"></script>
<script src="<?= base_url() ?>myassets/js/jquery.dataTables.min.js"></script>


<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Report Outbound</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                </ol>
            </div>

        </div>
    </div>
</div>





<div class="row" id="reportContent">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <!-- <h4 class="card-title mb-0 flex-grow-1">Completed Activities</h4> -->
                <input type="text" class="form-control" style="width: 200px; margin-right: 10px; display:none;" id="sChecker" placeholder="Checker">
                <input type="date" class="form-control" style="width: 200px; margin-right: 10px;" id="sStartDate" placeholder="Start Date">
                <input type="date" class="form-control" style="width: 200px; margin-right: 10px;" id="sEndDate" placeholder="End Date">
                <button class="btn btn-outline-primary btn-icon waves-effect waves-light" id="sButton"><i class="ri-filter-fill"></i></button>
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

                    <div class="row g-4 mb-3">
                        <div class="col-lg-4">
                            <label for="task-status" class="form-label">No Truck</label>
                            <input type="text" id="no_truck" name="no_truck" class="form-control" value="">
                        </div>
                        <div class="col col-lg-4">
                            <label for="priority-field" class="form-label">Expedisi</label>
                            <!-- <input type="text" id="expedisi" name="expedisi" class="form-control" placeholder="" value=""> -->
                            <select class="form-control" name="expedisi" id="expedisi" required>
                                <option value="">Choose Ekspedisi</option>
                                <?php foreach ($ekspedisi->result() as $e) { ?>
                                    <option value="<?= $e->id ?>"><?= $e->name ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col col-lg-4">
                            <label for="priority-field" class="form-label">Driver</label>
                            <input type="text" id="driver" name="driver" class="form-control" placeholder="" value="">
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

<script src="<?= base_url() ?>myassets/js/exceljs.min.js"></script>


<script>
    $(document).ready(function() {
        getRowComplete();

        // $('#sButton').on('click', function() {
        //     let checker = $('#sChecker').val().trim();
        //     let startDate = $('#sStartDate').val().trim();
        //     let endDate = $('#sEndDate').val().trim();
        //     let dataToPost = {
        //         checker: checker,
        //         startDate: startDate,
        //         endDate: endDate
        //     }
        //     getRowComplete(dataToPost);
        // })

        // $('#tablePlace').on('click', '.btnEdit', async function() {
        //     startLoading();
        //     let id = $(this).data('id');
        //     let result = await $.post('getTaskCompleteById', {
        //         id: id
        //     }, function(response) {}, 'json');

        //     let task = result.task;
        //     $('#proses').val('edit_task');
        //     $('#id_task').val(id);
        //     $('#checker').val(task.checker_id);
        //     $('#alocation').val(task.alloc_code);
        //     $('#factory').val(task.factory_code);
        //     $('#expedisi').val(task.ekspedisi);
        //     $('#no_truck').val(task.no_truck);
        //     $('#qty').val(task.qty);
        //     $('#sj').val(task.no_sj);
        //     $('#sj_date').val(task.sj_date);
        //     $('#send_date').val(task.sj_send_date);
        //     $('#toa').val(task.time_arival);
        //     $('#sj_time').val(task.sj_time);
        //     $('#driver').val(task.driver);
        //     $('#remarks').val(task.remarks);
        //     $('#pintu_unloading').val(task.pintu_unloading);
        //     $('#btnTask').text('Edit');
        //     $('#createTaskLabel').text('Edit task');
        //     $('#createTask').modal('show');
        //     stopLoading();
        // });

        // $('#creatask').on('submit', function(e) {
        //     e.preventDefault();
        //     let form = new FormData(this);
        //     let proses = $('#proses').val();
        //     $.ajax({
        //         url: 'editTaskCompleted',
        //         type: 'POST',
        //         data: form,
        //         processData: false,
        //         contentType: false,
        //         dataType: 'JSON',
        //         success: function(response) {
        //             if (response.success == true) {
        //                 getRowComplete();
        //                 $('#createTask').modal('hide');
        //             }
        //         }
        //     });
        // })




        // $('#tablePlace').on('click', '.btnDelete', function() {
        //     let id = $(this).data('id');
        //     Swal.fire({
        //         icon: 'question',
        //         title: "Are you sure to delete this activity?",
        //         showCancelButton: true,
        //         confirmButtonText: "Yes",
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             $.post('deleteCompleteActivity', {
        //                 id: id
        //             }, function(response) {
        //                 if (response.success == true) {
        //                     Swal.fire("Deleted!", "", "success");
        //                     getRowComplete();
        //                 }
        //             }, 'json');
        //         } else if (result.isDenied) {
        //             Swal.fire("Changes are not saved", "", "info");
        //         }
        //     });
        // })

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
                    // return;

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
                        a.download = 'YMI Daily Performance Outbound.xlsx';
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
                        sort: false
                    });
                }
            });
        }
    })
</script>