<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <span class="me-3" id="spConnect"></span>
                        <a href="javascript: void(0);">Dashboards </a>
                    </li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills nav-success mb-3" role="tablist">
            <li class="nav-item waves-effect waves-light" role="presentation">
                <a class="nav-link active btnDash" data-bs-toggle="tab" href="#" data-tab="DashboardDaily" role="tab" aria-selected="false" tabindex="-1">Daily</a>
            </li>
            <li class="nav-item waves-effect waves-light" role="presentation">
                <a class="nav-link btnDash" data-bs-toggle="tab" href="#" role="tab" data-tab="DashboardMonthly" aria-selected="false" tabindex="-1">Monthly</a>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div style="display: block;" class="col-md-12 tab-pane active show tabDash" id="DashboardDaily">
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="card-title mb-0 flex-grow-1"><strong id="clock"></strong></h4>
                    </div>
                    <div class="">
                        <form id="formSearchByDate">
                            <div class="row">
                                <div class="col-sm-12" style="display: contents;">
                                    <div class="input-group">
                                        <span style="margin-top: 5px;"> &nbsp; Activity Date &nbsp;</span>
                                        <input type="date" id="startDate" class="form-control-sm">
                                        <span style="margin-top: 5px;"> &nbsp; to &nbsp;</span>
                                        <input type="date" id="endDate" class="form-control-sm d-inline">
                                        <button class="btn btn-primary btn-sm border-primary text-white" id="btnSearch">
                                            <i class="ri-search-2-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-animate overflow-hidden">
                    <div class="card-header card-primary align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Inbound Summary </h4>
                    </div>
                    <div class="card-body" style="z-index:1 ;">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fs-10 fw-medium text-muted text-truncate mb-1"> Proccess</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span id="spInboundProses">0</span><span class="fs-10 text-muted mb-0"> SJ</span>
                                </h4>
                                <p class="fs-18 fw-semibold ff-secondary mb-0"><span id="sp_qty_proses_in">0</span> <span class="fs-10 text-muted mb-0">Unit</span></p>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fs-10 fw-medium text-muted text-truncate mb-1"> Complete Putaway</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span id="spInboundComplete">0</span><span class="fs-10 text-muted mb-0"> SJ</span>
                                </h4>
                                <p class="fs-18 fw-semibold ff-secondary mb-0"><span id="sp_qty_complete_in">0</span> <span class="fs-10 text-muted mb-0">Unit</span></p>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fs-10 fw-medium text-muted text-truncate mb-1"> Total SJ </p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span id="spInboundTotal">0</span><span class="fs-10 text-muted mb-0"> SJ</span>
                                </h4>
                                <p class="fs-18 fw-semibold ff-secondary mb-0"><span id="sp_qty_total_in">0</span> <span class="fs-10 text-muted mb-0">Unit</span></p>
                            </div>
                            <!-- <div class="flex-grow-1">
                                <p class="text-uppercase fs-10 fw-medium text-muted text-truncate mb-1"> Man Power </p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span id="sp_plan_inb">0</span><span class="fs-10 text-muted mb-0"> Total Alokasi MP</span>
                                </h4>
                                <p class="fs-18 fw-semibold ff-secondary mb-0"><span id="sp_actual_inb">0</span><span class="fs-10 text-muted mb-0"> Actual Alokasi MP</span></p>
                            </div> -->
                            <div class="flex-shrink-0">
                                <div id="cartInbound"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-animate overflow-hidden">
                    <div class="card-header card-success align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Outbound Summary</h4>
                    </div>
                    <div class="card-body" style="z-index:1 ;">
                        <div class="d-flex">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fs-10 fw-medium text-muted text-truncate mb-1"> Unproccess</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span id="spOutboundUnproses">0</span><span class="fs-10 text-muted mb-0"> PL</span>
                                </h4>
                                <p class="fs-18 fw-semibold ff-secondary mb-0"><span id="sp_qty_unproses_out">0</span><span class="fs-10 text-muted mb-0"> Unit</span></p>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fs-10 fw-medium text-muted text-truncate mb-1"> Proccess</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span id="spOutboundProses">0</span><span class="fs-10 text-muted mb-0"> PL</span>
                                </h4>
                                <p class="fs-18 fw-semibold ff-secondary mb-0"><span id="sp_qty_proses_out">0</span><span class="fs-10 text-muted mb-0"> Unit</span></p>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fs-10 fw-medium text-muted text-truncate mb-1"> Complete</p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span id="spOutboundComplete">0</span><span class="fs-10 text-muted mb-0"> PL</span>
                                </h4>
                                <p class="fs-18 fw-semibold ff-secondary mb-0"><span id="sp_qty_complete_out">0</span><span class="fs-10 text-muted mb-0"> Unit</span></p>
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fs-10 fw-medium text-muted text-truncate mb-1"> Total PL </p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span id="spOutboundTotal">0</span><span class="fs-10 text-muted mb-0"> PL</span>
                                </h4>
                                <p class="fs-18 fw-semibold ff-secondary mb-0"><span id="sp_qty_total_out">0</span><span class="fs-10 text-muted mb-0"> Unit</span></p>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-uppercase fs-10 fw-medium text-muted text-truncate mb-1"> Man Power </p>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-0">
                                    <span id="sp_plan">0</span><span class="fs-10 text-muted mb-0"> Total Alokasi MP</span>
                                </h4>
                                <p class="fs-18 fw-semibold ff-secondary mb-0"><span id="sp_actual">0</span><span class="fs-10 text-muted mb-0"> Actual Alokasi MP</span></p>
                            </div>
                            <div class="flex-shrink-0">
                                <div id="cartOutbound"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="divUserProses">
        </div>

        <div class="row project-wrapper">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header card-primary align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Inbound Detail</h4>
                        <div class="flex-shrink-0">
                            <!-- <button type="button" class="btn btn-soft-info btn-sm">
                        Today
                    </button> -->
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-card" id="divInbound">

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header card-success align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Outbound Detail</h4>
                        <div class="flex-shrink-0">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-card" id="divOutbound">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" class="col-md-12 tab-pane tabDash" id="DashboardMonthly">
        <div class="d-felx">
            <!-- <label for="">Activity Date : </label>
            <input type="month" class="form-control-sm" id="inputMonthInbound">
            <button class="btn btn-sm btn-success" id="btnRefreshInboundMonthly">Refresh</button> -->
        </div>

        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="card-title mb-0 flex-grow-1"><strong id="clock"></strong></h4>
                    </div>
                    <input type="month" class="form-control-sm" id="inputMonthInbound">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title mb-0">Monthly Inbound Chart</span>
                    </div>
                    <div class="card-body card-responsive">
                        <div id="inboundMonthly" class="e-charts"></div>
                    </div>
                </div>
                <!-- end card -->
            </div>
            <div class="col-12 col-xl-12">
                <div class="card card-responsive">
                    <div class="card-header">
                        <span class="card-title mb-0">Monthly Outbound Chart</span>
                    </div>
                    <div class="card-body card-responsive">
                        <div id="outboundMonthly" class="e-charts"></div>
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>
    </div>
</div>

<!-- echarts js -->
<script src="<?= base_url('jar/html/default/') ?>assets/libs/echarts/echarts.min.js"></script>



<script>
    $(document).ready(function() {

        var date = new Date();
        var month = date.getMonth() + 1; // getMonth() returns month from 0-11
        var year = date.getFullYear();
        if (month < 10) month = '0' + month; // Add leading zero to single digit months
        var currentMonth = year + '-' + month;
        $('#inputMonthInbound').val(currentMonth);


        $('.btnDash').on('click', function(e) {
            e.preventDefault();
            let tab = $(this).data('tab');
            $('.tabDash').css('display', 'none');
            $('#' + tab).css('display', 'block');

            if (tab == "DashboardMonthly") {
                // let xInboundData = ['2012', '2013', '2014', '2015', '2016'];
                // let yInboundData = [1320, 1332, 1301, 1334, 1390];
                // cartInboundMonthly(xInboundData, yInboundData);
                getInboundMonthly();
                getOutboundMonthly();
            }
        })


        $('#inputMonthInbound').on('change', function() {
            getInboundMonthly();
            getOutboundMonthly();
        })

        var socket;
        initWebSocket();


        getAllByDate();

        $('#formSearchByDate').on('submit', function(e) {
            e.preventDefault();
            getAllByDate();
        })

        function getAllByDate() {

            var today = new Date().toISOString().split('T')[0];
            if ($('#startDate').val() == '') {
                $('#startDate').val(today)
            }
            if ($('#endDate').val() == '') {
                $('#endDate').val(today)
            }

            let dataToPost = {
                start_date: $('#startDate').val(),
                end_date: $('#endDate').val(),
            }

            cartInbound(dataToPost);
            getAllProccessInbound(dataToPost);

            getUserProses(dataToPost);

            cartOutbound(dataToPost);
            getAllProccessOutbound(dataToPost);

            // let sDate = $('#sStartDate').val();
            // let eDate = $('#sEndDate').val();

            // let divTable = $('#divSchedule');
            // divTable.empty();
            // $.ajax({
            //     url: "getTablePickingList",
            //     type: "POST",
            //     data: {
            //         startDate: sDate,
            //         endDate: eDate
            //     },
            //     dataType: 'JSON',
            //     success: function(response) {
            //         if (response.success == true) {
            //             $('#cardPL').empty();
            //             $('#cardPL').html(response.table);
            //             $('#tablePL').dataTable();
            //         }
            //     }
            // });

            // // $.post('', {}, function(response) {

            // // }, 'json');
        }

        function getUserProses(dataToPost) {
            $.post('getUserProses', dataToPost, function(response) {
                if (response.success == true) {
                    $('#divUserProses').empty();
                    $('#divUserProses').html(response.table_user_proses);
                }
            }, 'json');
        }

        function initWebSocket() {
            let hostname = window.location.hostname;
            console.log(hostname);
            socket = new WebSocket('ws://' + hostname + ':8001');

            socket.onopen = function() {
                $('#spConnect').html(`<span class="position-absolute mt-2 translate-middle badge border border-light rounded-circle bg-success p-2"><span class="visually-hidden">Connected</span></span>`);
                // console.log('WebSocket connection opened');
            };

            socket.onmessage = function(event) {
                getAllByDate();
                // getAllProccessInbound();
                // cartInbound();
                // getAllProccessOutbound();
                // cartOutbound();
                // getUserProses();
                // console.log('Received message: ' + event.data);
                // Handle received message
            };

            socket.onclose = function(event) {
                $('#spConnect').html(`<span class="position-absolute mt-2 translate-middle badge border border-light rounded-circle bg-danger p-2"><span class="visually-hidden">Not Connected</span></span>`);
                // console.log('WebSocket connection closed');
                // Try to re-initiate connection after a delay
                setTimeout(initWebSocket, 5000); // Retry after 5 seconds
            };

            socket.onerror = function(error) {
                console.error('WebSocket error : ' + error);
                // Handle WebSocket error, if necessary
            };
        }

        function getAllProccessInbound(dataToPost) {
            $.post('getAllProccessInbound', dataToPost, function(response) {
                let divInbound = $('#divInbound');
                divInbound.empty();
                divInbound.html(response);
            });
        }

        function getAllProccessOutbound(dataToPost) {
            $.post('getAllProccessOutbound', dataToPost, function(response) {
                let divOutbound = $('#divOutbound');
                divOutbound.empty();
                divOutbound.html(response);
            });
        }

        function cartInbound(dataToPost) {

            $.post('getPresentaseInbound', dataToPost, function(response) {

                let data = response.data;

                let presentase = Math.round(data.presentase);

                $('#spInboundProses').text(data.inbound_proses);
                $('#spInboundComplete').text(data.inbound_complete);
                $('#spInboundTotal').text(data.total_inbound);
                $('#sp_qty_proses_in').text(data.qty_proses);
                $('#sp_qty_complete_in').text(data.qty_complete);
                $('#sp_qty_total_in').text(data.total_qty);


                // $('#cartInbound').empty();
                // $('#cartInbound').html(`<div id="ctr" class="apex-charts"></div>`);

                // var options = {
                //     series: [presentase],
                //     chart: {
                //         type: "radialBar",
                //         width: 105,
                //         sparkline: {
                //             enabled: true
                //         }
                //     },
                //     dataLabels: {
                //         enabled: false
                //     },
                //     plotOptions: {
                //         radialBar: {
                //             hollow: {
                //                 margin: 0,
                //                 size: "70%"
                //             },
                //             track: {
                //                 margin: 1
                //             },
                //             dataLabels: {
                //                 show: true,
                //                 name: {
                //                     show: false
                //                 },
                //                 value: {
                //                     show: true,
                //                     fontSize: "16px",
                //                     fontWeight: 600,
                //                     offsetY: 8
                //                 }
                //             }
                //         }
                //     },
                //     colors: ['#0000FF'] // Gunakan warna-warna yang telah Anda definisikan
                // };

                // var chart = new ApexCharts(document.querySelector("#ctr"), options);
                // chart.render();
            }, 'json');
        }

        function cartOutbound(dataToPost) {

            $.post('getPresentaseOutbound', dataToPost, function(response) {

                let data = response.data;

                let presentase = Math.round(data.presentase);

                $('#spOutboundUnproses').text(data.outbound_unproses);
                $('#spOutboundProses').text(data.outbound_proses);
                $('#spOutboundComplete').text(data.outbound_complete);
                $('#spOutboundTotal').text(data.total_pl);
                $('#sp_qty_unproses_out').text(data.qty_unproses);
                $('#sp_qty_proses_out').text(data.qty_proses);
                $('#sp_qty_complete_out').text(data.qty_complete);
                $('#sp_qty_total_out').text(data.total_qty);

                $('#sp_plan').text(response.man_power.total_plan);
                $('#sp_actual').text(response.man_power.user_active);

                // $('#cartOutbound').empty();
                // $('#cartOutbound').html(`<div id="ctro" class="apex-charts"></div>`);

                // var options = {
                //     series: [presentase],
                //     chart: {
                //         type: "radialBar",
                //         width: 105,
                //         sparkline: {
                //             enabled: true
                //         }
                //     },
                //     dataLabels: {
                //         enabled: false
                //     },
                //     plotOptions: {
                //         radialBar: {
                //             hollow: {
                //                 margin: 0,
                //                 size: "70%"
                //             },
                //             track: {
                //                 margin: 1
                //             },
                //             dataLabels: {
                //                 show: true,
                //                 name: {
                //                     show: false
                //                 },
                //                 value: {
                //                     show: true,
                //                     fontSize: "16px",
                //                     fontWeight: 600,
                //                     offsetY: 8
                //                 }
                //             }
                //         }
                //     },
                //     colors: ['#FF5733'] // Gunakan warna-warna yang telah Anda definisikan
                // };

                // var chart = new ApexCharts(document.querySelector("#ctro"), options);
                // chart.render();
            }, 'json');
        }

        function getInboundMonthly() {
            let month = $('#inputMonthInbound').val();
            let elementID = 'inboundMonthly';
            let colorData = 'rgb(64 81 137)';
            let xInboundData = [];
            let yInboundData = [];

            $.post('getMonthlyInbound', {
                month
            }, function(response) {
                let data = response.inbound;
                $.each(data, function(index, obj) {
                    xInboundData.push(obj.formatted_date);
                    yInboundData.push(obj.total_qty);
                });

                renderChartMonthly(xInboundData, yInboundData, elementID, colorData);
            }, 'json');
        }

        function getOutboundMonthly() {
            let month = $('#inputMonthInbound').val();
            let elementID = 'outboundMonthly';
            let colorData = 'rgb(10 179 156)';
            let xData = [];
            let yData = [];

            $.post('getMonthlyOutbound', {
                month
            }, function(response) {
                let data = response.outbound;
                $.each(data, function(index, obj) {
                    xData.push(obj.formatted_date);
                    yData.push(obj.total_qty);
                });

                renderChartMonthly(xData, yData, elementID, colorData);
            }, 'json');
        }

        function renderChartMonthly(xData, yData, elementID, colorData) {
            var app = {};

            var chartDom = document.getElementById(elementID);

            // console.log(echarts);

            var myChart = echarts.init(chartDom);
            var option;

            const posList = [
                'left',
                'right',
                'top',
                'bottom',
                'inside',
                'insideTop',
                'insideLeft',
                'insideRight',
                'insideBottom',
                'insideTopLeft',
                'insideTopRight',
                'insideBottomLeft',
                'insideBottomRight'
            ];
            app.configParameters = {
                rotate: {
                    min: -90,
                    max: 90
                },
                align: {
                    options: {
                        left: 'left',
                        center: 'center',
                        right: 'right'
                    }
                },
                verticalAlign: {
                    options: {
                        top: 'top',
                        middle: 'middle',
                        bottom: 'bottom'
                    }
                },
                position: {
                    options: posList.reduce(function(map, pos) {
                        map[pos] = pos;
                        return map;
                    }, {})
                },
                distance: {
                    min: 0,
                    max: 100
                }
            };
            app.config = {
                rotate: 90,
                align: 'left',
                verticalAlign: 'middle',
                position: 'insideBottom',
                distance: 15,
                onChange: function() {
                    const labelOption = {
                        rotate: app.config.rotate,
                        align: app.config.align,
                        verticalAlign: app.config.verticalAlign,
                        position: app.config.position,
                        distance: app.config.distance
                    };
                    myChart.setOption({
                        series: [{
                                label: labelOption
                            },
                            {
                                label: labelOption
                            },
                            {
                                label: labelOption
                            },
                            {
                                label: labelOption
                            }
                        ]
                    });
                }
            };
            const labelOption = {
                show: true,
                position: app.config.position,
                distance: app.config.distance,
                align: app.config.align,
                verticalAlign: app.config.verticalAlign,
                rotate: app.config.rotate,
                formatter: '{c}  {name|{a}}',
                fontSize: 16,
                rich: {
                    name: {}
                }
            };
            option = {
                tooltip: {
                    trigger: 'axis',
                    axisPointer: {
                        type: 'shadow'
                    }
                },
                legend: {
                    data: ['Unit']
                },
                toolbox: {
                    show: false,
                    orient: 'vertical',
                    left: 'right',
                    top: 'center',
                    feature: {
                        mark: {
                            show: true
                        },
                        dataView: {
                            show: true,
                            readOnly: false
                        },
                        magicType: {
                            show: true,
                            type: ['line', 'bar', 'stack']
                        },
                        restore: {
                            show: true
                        },
                        saveAsImage: {
                            show: true
                        }
                    }
                },
                xAxis: [{
                    type: 'category',
                    axisTick: {
                        show: true
                    },
                    axisLabel: {
                        interval: 0,
                        rotate: 30
                    },
                    data: xData,
                }],
                yAxis: [{
                    type: 'value'
                }],
                series: [{
                    name: '',
                    type: 'bar',
                    color: colorData,
                    barGap: 0,
                    label: labelOption,
                    emphasis: {
                        focus: 'series'
                    },
                    data: yData
                }, ]
            };

            option && myChart.setOption(option);
        }
    });
</script>