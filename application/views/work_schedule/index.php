<link href="<?= base_url() ?>myassets/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>myassets/js/jquery-3.7.0.js"></script>
<script src="<?= base_url() ?>myassets/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>myassets/js/xlsx.full.min.js"></script>
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
    <div class="col-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <span style="margin-top: 8px;">Start Date : </span>&nbsp;
                <input type="date" class="form-control d-inline" style="width: 150px; margin-right: 10px;" id="sStartDate" placeholder="Start Date">
                <span style="margin-top: 8px;">to : </span>&nbsp;
                <input type="date" class="form-control d-inline" style="width: 150px; margin-right: 10px;" id="sEndDate" placeholder="End Date">
                <span style="margin-top: 8px;">Employee : </span>&nbsp;
                <!-- <input type="text" class="form-control" style="width: 180px; margin-right: 10px;" id="sUser"> -->
                <select id="sUser" class="form-control d-inline" style="width: 180px;">
                    <option value="all">All</option>
                    <?php
                    foreach ($users->result() as $data) {
                    ?>
                        <option value="<?= $data->id ?>"><?= $data->fullname ?></option>
                    <?php
                    }
                    ?>
                </select>
                &nbsp;
                <button class="btn btn-outline-success" id="sButton"><i class="ri-filter-fill"></i></button>
                <button class="btn btn-info" id="btnAdd">New</button>
                <button class="btn btn-success" id="btnUploadSchedule">Upload</button>
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
                            <!-- <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Day</label>
                                    <input type="text" class="form-control" id="day" name="day" value="<?= date('l') ?>" placeholder="" required readonly>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= date('Y-m-d') ?>" placeholder="" required>
                                </div>
                                <div class="form-group col-6">
                                    <label for="name" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="start_time" value="08:00" name="start_time" placeholder="" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= date('Y-m-d') ?>" placeholder="" required>
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

<div class="modal fade" id="modalUploadForm" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headerForm"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="excelScheduleForm">
                    <div class="row">

                        <div class="form-group nowrap">
                            <label for="">Choose Excel File</label>
                            <input type="file" class="form-control" id="fileExcel" accept=".xls,.xlsx">
                            <!-- <button type="button" class="btn btn-primary" id="uploadExcel">Upload</button> -->
                        </div>
                        <div class="mt-2" id="divTable"></div>

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

<script></script>

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

        $('#excelScheduleForm').on('submit', function(e) {
            e.preventDefault();

            // console.log(jsonExcel.rows.length);
            // return;

            if (jsonExcel.rows) {
                $.ajax({
                    url: 'createWithExcel',
                    type: 'POST',
                    data: {
                        schedule: JSON.stringify(jsonExcel),
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        if (response.success == true) {
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                getTableSchedule();
                                $('#modalUploadForm').modal('hide');
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
                Swal.fire({
                    icon: 'error',
                    title: 'Data not found',
                    text: 'Please choose file correctly'
                });
            }





            // if (form_proses === 'add_new') {
            //     $.ajax({
            //         url: 'createSchedule',
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
            //                     // window.location.href = 'index';
            //                     getTableSchedule();
            //                     $('#modalForm').modal('hide');
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
            // } else {
            //     $.ajax({
            //         url: 'editSchedule',
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
            //                     // window.location.href = 'index';
            //                     getTableSchedule();
            //                     $('#modalForm').modal('hide');
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

        $('#btnUploadSchedule').on('click', function() {
            $('#modalUploadForm').modal('show');
        })


        //Begin Manage Excel

        var selectedFile;
        var jsonExcel = {};

        // Objek yang menampung nama kolom yang ditentukan dari sistem
        var systemColumnNames = {
            columnName1: "user_id",
            columnName2: "fullname",
            columnName3: "position_id",
            columnName4: "start_date",
            columnName5: "start_time",
            columnName6: "end_date",
            columnName7: "end_time",
            // Tambahkan lebih banyak nama kolom jika diperlukan
        };

        // document.getElementById("fileExcel").addEventListener("change", function(event) {
        // });

        document.getElementById("fileExcel").addEventListener("change", function() {
            selectedFile = event.target.files[0];
            if (selectedFile) {
                var fileReader = new FileReader();
                fileReader.onload = function(event) {
                    var data = event.target.result;

                    try {
                        var workbook = XLSX.read(data, {
                            type: "binary",
                        });

                        var excelData = {
                            rows: [],
                            totalQty: 0
                        };

                        workbook.SheetNames.forEach((sheet) => {
                            let table = document.createElement("table");
                            table.setAttribute("id", "excelTable");
                            let rowObject = XLSX.utils.sheet_to_row_object_array(
                                workbook.Sheets[sheet]
                            );
                            var headers = Object.keys(rowObject[0]);

                            // Validasi nama kolom
                            // var systemColumnKeys = Object.keys(systemColumnNames);
                            // if (headers.length !== systemColumnKeys.length ||
                            //     !systemColumnKeys.every(key => headers.includes(systemColumnNames[key]))) {

                            //     alert("Column names do not match the system-defined column names.");
                            //     return;
                            // }

                            // Validasi kolom ketiga untuk format tanggal
                            var dateRegex = /^\d{4}-\d{2}-\d{2}$/; // Format tanggal: YYYY-MM-DD
                            var invalidDateFound = false;
                            for (var i = 0; i < rowObject.length; i++) {
                                var rowData = rowObject[i];
                                if (!dateRegex.test(convertExcelSerialToDate(rowData[systemColumnNames.columnName4]))) {
                                    invalidDateFound = true;
                                    break;
                                }
                            }

                            // if (invalidDateFound) {
                            //     alert("Data in column 'Expire' must be in date format (YYYY-MM-DD).");
                            //     return; // Stop further processing if invalid date found
                            // }

                            var headerRow = table.insertRow(-1);
                            headers.forEach(function(header) {
                                var cell = headerRow.insertCell(-1);
                                cell.innerHTML = header;
                            });



                            // Konversi nilai tanggal dari format serial Excel ke format JavaScript
                            rowObject.forEach(function(rowData) {
                                var dateSerial = parseFloat(rowData[systemColumnNames.columnName4]);
                                var convertedDate = convertExcelSerialToDate(dateSerial);
                                rowData[systemColumnNames.columnName4] = convertedDate;

                                var desimalTime = parseFloat(rowData[systemColumnNames.columnName5]);
                                var convertedTime = konversiDesimalKeWaktu(desimalTime);
                                rowData[systemColumnNames.columnName5] = convertedTime;

                                var dateSerial = parseFloat(rowData[systemColumnNames.columnName6]);
                                var convertedDate = convertExcelSerialToDate(dateSerial);
                                rowData[systemColumnNames.columnName6] = convertedDate;

                                var desimalTime = parseFloat(rowData[systemColumnNames.columnName7]);
                                var convertedTime = konversiDesimalKeWaktu(desimalTime);
                                rowData[systemColumnNames.columnName7] = convertedTime;

                                excelData.rows.push(rowData);

                                // Hitung total kuantitas
                                // var qty = parseInt(rowData[systemColumnNames.columnName4]) || 0;
                                // excelData.totalQty += qty;
                            });
                        });

                        // Tampilkan tabel
                        displayTable(excelData);

                        console.log(excelData);
                        jsonExcel = excelData;
                    } catch (error) {
                        console.error("Error parsing Excel file:", error);
                        alert("Error parsing Excel file. Please make sure the file is valid.");
                    }
                };
                fileReader.readAsBinaryString(selectedFile);
            }
        });



        // Function to display table
        function displayTable(excelData) {
            var table = document.createElement("table");
            table.setAttribute("id", "excelTable");
            table.setAttribute("class", "table table-bordered table-sm");

            var headers = Object.values(systemColumnNames); // Mengambil nilai kolom dari objek systemColumnNames

            // Header row
            var headerRow = table.insertRow(-1);
            headers.unshift("No.");
            headers.forEach(function(header) {
                var cell = headerRow.insertCell(-1);
                cell.innerHTML = header;
            });

            // Data rows
            excelData.rows.forEach(function(rowData, index) {
                var row = table.insertRow(-1);
                headers.forEach(function(header) {
                    var cell = row.insertCell(-1);
                    if (header === "No.") {
                        cell.innerHTML = index + 1; // Nomor urut dimulai dari 1
                    } else {
                        cell.innerHTML = rowData[header];
                    }
                });
            });

            // Total Qty row
            // var totalRow = table.insertRow(-1);
            // var totalQtyCell = totalRow.insertCell(-1);
            // totalQtyCell.colSpan = headers.length - 1; // Mengatur kolom keempat
            // totalQtyCell.style.fontWeight = "bold";
            // totalQtyCell.innerHTML = "Total Qty:";
            // var totalValueCell = totalRow.insertCell(-1);
            // totalQtyCell.className = "total-qty-cell"; // Menambahkan kelas untuk penataan CSS
            // totalValueCell.style.fontWeight = "bold";
            // totalValueCell.innerHTML = excelData.totalQty;

            var divTable = document.getElementById("divTable");
            divTable.innerHTML = "";
            divTable.appendChild(table);
        }

        // Function to convert Excel serial date to JavaScript date
        function convertExcelSerialToDate(serial) {
            var utcDays = Math.floor(serial - 25569);
            var utcValue = utcDays * 86400;
            var dateInfo = new Date(utcValue * 1000);
            var year = dateInfo.getUTCFullYear();
            var month = dateInfo.getUTCMonth() + 1;
            var day = dateInfo.getUTCDate();
            return year + "-" + (month < 10 ? "0" + month : month) + "-" + (day < 10 ? "0" + day : day);
        }

        function konversiDesimalKeWaktu(desimal) {
            // Validasi nilai desimal
            if (desimal < 0 || desimal >= 1) {
                return "Nilai desimal harus berada di antara 0 dan 1";
            }

            // Hitung jam, menit, dan detik
            var totalDetik = Math.floor(desimal * 86400); // 86400 detik dalam sehari
            var jam = Math.floor(totalDetik / 3600);
            var sisaDetik = totalDetik % 3600;
            var menit = Math.floor(sisaDetik / 60);
            var detik = sisaDetik % 60;

            // Format waktu dengan menambahkan nol di depan jika perlu
            var waktu = pad(jam, 2) + ":" + pad(menit, 2) + ":" + pad(detik, 2);
            return waktu;
        }

        // Fungsi untuk menambahkan nol di depan angka jika perlu
        function pad(num, size) {
            var s = num + "";
            while (s.length < size) s = "0" + s;
            return s;
        }

        //End Manage Excel


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
            let sUser = $('#sUser').val();

            let divTable = $('#divSchedule');
            divTable.empty();
            $.ajax({
                url: "getTableSchedule",
                type: "POST",
                data: {
                    startDate: sDate,
                    endDate: eDate,
                    sUser: sUser
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
            $('#start_date').val($(this).data('start-date'));
            $('#end_date').val($(this).data('end-date'));
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
                    getTableSchedule();
                    // Swal.fire({
                    //     position: "top-end",
                    //     icon: "success",
                    //     title: response.message,
                    //     showConfirmButton: false,
                    //     timer: 1500
                    // }).then(function() {
                    //     window.location.href = 'index';
                    // })
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