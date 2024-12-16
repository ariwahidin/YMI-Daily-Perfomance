<link href="<?= base_url() ?>myassets/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>myassets/js/jquery-3.7.0.js"></script>
<script src="<?= base_url() ?>myassets/js/jquery.dataTables.min.js"></script>


<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard Ekspedisi</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                </ol>
            </div>

        </div>
    </div>
</div>



<div class="row">
    <div class="col-12" id="cardContainer">
    </div>
</div>



<div class="row" id="reportContent">

    <div class="col-xl-12">
        <div class="card">

            <div class="card-header bg-success align-items-center d-flex">
                <input type="text" class="form-control" style="width: 200px; margin-right: 10px; display:none;" id="sChecker" placeholder="Checker">
                <input type="date" class="form-control" style="width: 200px; margin-right: 10px;" id="sStartDate" placeholder="Start Date">
                <input type="date" class="form-control" style="width: 200px; margin-right: 10px;" id="sEndDate" placeholder="End Date">
                <button class="btn btn-outline-primary btn-icon waves-effect waves-light" id="sButton"><i class="ri-filter-fill"></i></button>
                <button style="margin-left: 10px;" class="btn btn-outline-primary " id="btnExcel">Excel</button>
            </div>

            <div class="card-body">
                <div class="table-responsive" id="tablePlace">

                </div>
            </div>

        </div>
    </div>
</div>




<script src="<?= base_url() ?>myassets/js/exceljs.min.js"></script>


<script>
    $(document).ready(function() {
        var socket;
        initWebSocket();
        getRowComplete();


        function initWebSocket() {
            socket = new WebSocket(urlWebsocket);

            socket.onopen = function() {
                // $('#spConnect').html(`<span class="position-absolute mt-2 translate-middle badge border border-light rounded-circle bg-success p-2"><span class="visually-hidden">Connected</span></span>`);
            };

            socket.onmessage = function(event) {
                // getAllByDate();
                getRowComplete();
            };

            socket.onclose = function(event) {
                // $('#spConnect').html(`<span class="position-absolute mt-2 translate-middle badge border border-light rounded-circle bg-danger p-2"><span class="visually-hidden">Not Connected</span></span>`);
                setTimeout(initWebSocket, 5000);
            };

            socket.onerror = function(error) {
                console.error('WebSocket error : ' + error);
            };
        }

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
            }, function(response) {
                let task = response.task;
                $('#proses').val('edit_task');
                $('#id_task').val(id);
                $('#no_pl').val(task.no_pl);
                $('#pl_date').val(task.pl_date);
                $('#pl_time').val(formatTime(task.pl_time));
                $('#ekspedisi').val(task.ekspedisi);
                $('#no_truck').val(task.no_truck);
                $('#qty').val(task.qty);
                $('#checker_id').val(task.checker_id);
                $('#driver').val(task.driver);
                $('#remarks').val(task.remarks);
                $('#btnTask').text('Edit');
                $('#createTaskLabel').text('Edit task');
                $('#createTask').modal('show');
                stopLoading();
            }, 'json');
        });



        $('#tablePlace').on('click', '.btnDelete', function() {
            let id = $(this).data('id');
            Swal.fire({
                icon: 'question',
                title: "Are you sure to delete this activity?",
                showCancelButton: true,
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('deleteTaskCompleted', {
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
                    // return;

                    var headers = Object.keys(dataAct.data[0]);


                    // return;


                    var workbook = new ExcelJS.Workbook();
                    var sheet1 = workbook.addWorksheet('Summary Outbound');



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


                    if (dataAct.data_picker.length > 0) {
                        var headers_picker = Object.keys(dataAct.data_picker[0]);
                        var sheet2 = workbook.addWorksheet('Picker Detail');
                        sheet2.addRow(headers_picker).eachCell(function(row, rowNumber) {
                            row.fill = {
                                type: 'pattern',
                                pattern: 'solid',
                                fgColor: {
                                    argb: 'FFFF00'
                                }
                            };
                            sheet2.columns.forEach(function(column) {
                                var maxLength = 0;
                                column.eachCell(function(cell) {
                                    var columnLength = cell.value ? cell.value.toString().length : 10;
                                    if (columnLength > maxLength) {
                                        maxLength = columnLength;
                                    }
                                });
                                column.width = maxLength < 10 ? 10 : maxLength;
                            });
                        });
                        sheet2.eachRow(function(row) {
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
                        dataAct.data_picker.forEach(function(row, ) {
                            var rowData = headers_picker.map(function(header) {
                                return row[header];
                            });
                            sheet2.addRow(rowData);
                            // Menentukan lebar kolom berdasarkan isi
                            sheet2.columns.forEach(function(column) {
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
                            sheet2.eachRow(function(row) {
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
                    }

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

            $.ajax({
                url: "tableReport",
                type: "POST",
                data: {
                    startDate: sDate,
                    endDate: eDate
                },
                dataType: 'JSON',
                success: function(response) {
                    if (response.success == true) {
                        let divTable = $('#tablePlace');
                        divTable.empty();

                        divTable.html(response.summary);
                        $('#tableOutboundActivities').DataTable({
                            // sort: false,
                            order: [
                                [12, 'asc']
                            ],
                            paginate: false,
                            fixedHeader: true,
                            scrollY: 400, // Tinggi area scrolling
                            scrollCollapse: true
                        });

                        $.get(
                            "cardHeader", {

                            },
                            function(data) {
                                $('#cardContainer').html(data.html);
                            }, "JSON"
                        );
                    }
                }
            });
        }
    })
</script>