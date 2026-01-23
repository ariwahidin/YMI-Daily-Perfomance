<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Executive Dashboard (Effective DC 1 : 18 April 2024, DC 2 : 16 Oktober 2024)</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <span class="me-3" id="spConnect"></span>
                        <a href="javascript: void(0);">Total Stock DC</a>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">

        <div class="card crm-widget">
            <div class="card-header">
                <span class="card-title mb-0">Monthly Transaction DC 1 & DC 2</span>
                <input type="month" class="form-control-sm float-end" id="inputDateSummaryTransaction">
            </div>
            <div class="card-body p-0">
                <div class="row row-cols-xxl-4 row-cols-md-4 row-cols-1 g-0">
                    <div class="col">
                        <div class="py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">WHS CODE <i class="ri-check-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-hotel-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span>DC 1 & DC 2</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">TOTAL IN <span id="totalInDate" class="text-muted text-sm"></span> <i class="ri-arrow-down-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-inbox-archive-fill display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span id="totalInboundDC1DC2"><?= number_format($stock->TOTAL_INBOUND); ?></span></h2>
                                </div>
                            </div>
                            <span class="badge bg-danger-subtle text-danger fs-12">DC 1 : <span id="totalInboundDC1"><?= number_format($stock_detail[0]->TOTAL_INBOUND); ?></span></span>
                            <span class="badge bg-danger-subtle text-danger fs-12">DC 2 : <span id="totalInboundDC2"><?= number_format($stock_detail[1]->TOTAL_INBOUND); ?></span></span>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">TOTAL OUT <span id="totalOutDate" class="text-muted text-sm"></span> <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-inbox-unarchive-fill display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span id="totalOutboundDC1DC2"><?= number_format($stock->TOTAL_OUTBOUND); ?></span></h2>
                                </div>
                            </div>
                            <span class="badge bg-danger-subtle text-danger fs-12">DC 1 :  <span id="totalOutboundDC1"><?= number_format($stock_detail[0]->TOTAL_OUTBOUND); ?></span></span>
                            <span class="badge bg-danger-subtle text-danger fs-12">DC 2 : <span id="totalOutboundDC2"><?= number_format($stock_detail[1]->TOTAL_OUTBOUND); ?></span></span>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-lg-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">STOCK NOW <i class="ri-check-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-motorbike-fill display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span><?= number_format($stock->STOCK_TODAY); ?></span></h2>
                                </div>
                            </div>
                            <span class="badge bg-danger-subtle text-danger fs-12">DC 1 : <?= number_format($stock_detail[0]->STOCK_TODAY); ?></span>
                            <span class="badge bg-danger-subtle text-danger fs-12">DC 2 : <?= number_format($stock_detail[1]->STOCK_TODAY); ?></span>
                        </div>
                    </div>
                </div><!-- end row -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div>
</div>

<div class="row">
    <div class="col-6 col-xl-6">
        <div class="card">
            <div class="card-header">
                <span class="card-title mb-0">Occupancy DC 1</span>
            </div>
            <div class="card-body card-responsive">
                <div id="occupDC1" class="e-charts"></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-6">
        <div class="card">
            <div class="card-header">
                <span class="card-title mb-0">Occupancy DC 2</span>
            </div>
            <div class="card-body card-responsive">
                <div id="occupDC2" class="e-charts"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <span class="card-title mb-0">Monitoring Stock & Space Available DC 1 & DC 2</span>
                <input type="month" class="form-control-sm float-end" id="inputMonthStock">
            </div>
            <div class="card-body card-responsive">
                <div id="stockMonthly" class="e-charts"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-12">
        <div class="card">
            <div class="card-header">
                <span class="card-title mb-0">Monthly Inbound DC 1 & DC 2</span>
                <input type="month" class="form-control-sm float-end" id="inputMonthInbound">
            </div>
            <div class="card-body card-responsive">
                <div id="inboundMonthly" class="e-charts"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-12">
        <div class="card card-responsive">
            <div class="card-header">
                <span class="card-title mb-0">Monthly Outbound DC 1 & DC 2</span>
                <input type="month" class="form-control-sm float-end" id="inputMonthOutbound">
            </div>
            <div class="card-body card-responsive">
                <div id="outboundMonthly" class="e-charts"></div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('jar/html/default/') ?>assets/libs/echarts/echarts.min.js"></script>

<script>
    $(document).ready(function() {


        var date = new Date();
        var month = date.getMonth() + 1; // getMonth() returns month from 0-11
        var year = date.getFullYear();
        if (month < 10) month = '0' + month; // Add leading zero to single digit months
        var currentMonth = year + '-' + month;
        $('#inputMonthStock').val(currentMonth);
        $('#inputMonthInbound').val(currentMonth);
        $('#inputMonthOutbound').val(currentMonth);
        $('#inputDateSummaryTransaction').val(currentMonth);

        getStockMonthly();
        getInboundMonthly();
        getOutboundMonthly();


        $('#inputDateSummaryTransaction').on('change', function() {
            getTransactionMonthly();
        })

        $('#inputMonthStock').on('change', function() {
            getStockMonthly();
        })


        $('#inputMonthInbound').on('change', function() {
            getInboundMonthly();

        })

        $('#inputMonthOutbound').on('change', function() {
            getOutboundMonthly();
        })

        function getTransactionMonthly() {
            let month = $('#inputDateSummaryTransaction').val();
            let date = new Date(month);
            let dateFormat = date.toLocaleString('default', {
                month: 'long',
                year: 'numeric'
            });
            console.log("Get Transaction : ", month);


            $.post('getSummaryTransactionMonthly', {
                month
            }, function(response) {
                // let data = response.inbound;
                // $.each(data, function(index, obj) {
                //     xInboundData.push(obj.formatted_date);
                //     dc1_qty.push(obj.total_qty_in_dc_1);
                //     dc2_qty.push(obj.total_qty_in_dc_2);
                // });

                // renderChartMonthly(xInboundData, dc1_qty, dc2_qty, elementID, colorData);

                if (response.success == true) {
                    var totalInboundDC1DC2 = response.summary[0].TOTAL_INBOUND + response.summary[1].TOTAL_INBOUND
                    $('#totalInDate').text('(' + dateFormat + ')');
                    $('#totalInboundDC1').text(response.summary[0].TOTAL_INBOUND.toLocaleString());
                    $('#totalInboundDC2').text(response.summary[1].TOTAL_INBOUND.toLocaleString());
                    $('#totalInboundDC1DC2').text(totalInboundDC1DC2.toLocaleString());


                    var totalOutboundDC1DC2 = response.summary[0].TOTAL_OUTBOUND + response.summary[1].TOTAL_OUTBOUND
                    $('#totalOutDate').text('(' + dateFormat + ')');
                    $('#totalOutboundDC1').text(response.summary[0].TOTAL_OUTBOUND.toLocaleString());
                    $('#totalOutboundDC2').text(response.summary[1].TOTAL_OUTBOUND.toLocaleString());
                    $('#totalOutboundDC1DC2').text(totalOutboundDC1DC2.toLocaleString());
                }


            }, 'json');

        }

        function getStockMonthly() {
            let month = $('#inputMonthStock').val();
            let elementID = 'stockMonthly';
            let colorData = 'rgb(64 81 137)';
            let xInboundData = [];
            let dc1_qty = [];
            let dc2_qty = [];

            $.post('getStockMonthly', {
                month
            }, function(response) {
                let data = response.stock_dc;
                $.each(data, function(index, obj) {
                    xInboundData.push(obj.formatted_date);
                    dc1_qty.push(obj.stock);
                    dc2_qty.push(obj.stock2);
                });

                renderChartMonthlyStock(xInboundData, dc1_qty, dc2_qty, elementID, colorData);
            }, 'json');
        }

        function getInboundMonthly() {
            let month = $('#inputMonthInbound').val();
            let elementID = 'inboundMonthly';
            let colorData = 'rgb(64 81 137)';
            let xInboundData = [];
            let dc1_qty = [];
            let dc2_qty = [];

            $.post('getMonthlyInboundExecutive', {
                month
            }, function(response) {
                let data = response.inbound;
                $.each(data, function(index, obj) {
                    xInboundData.push(obj.formatted_date);
                    dc1_qty.push(obj.total_qty_in_dc_1);
                    dc2_qty.push(obj.total_qty_in_dc_2);
                });

                renderChartMonthly(xInboundData, dc1_qty, dc2_qty, elementID, colorData);
            }, 'json');
        }


        function getOutboundMonthly() {
            let month = $('#inputMonthOutbound').val();
            let elementID = 'outboundMonthly';
            let colorData = 'rgb(10 179 156)';
            let xData = [];
            let dc1_qty = [];
            let dc2_qty = [];

            $.post('getMonthlyOutboundExecutive', {
                month
            }, function(response) {
                let data = response.outbound;
                $.each(data, function(index, obj) {
                    xData.push(obj.formatted_date);
                    dc1_qty.push(obj.total_qty_out_dc_1);
                    dc2_qty.push(obj.total_qty_out_dc_2);
                });

                renderChartMonthly(xData, dc1_qty, dc2_qty, elementID, colorData);
            }, 'json');
        }

        function renderChartMonthly(xData, dc1_qty, dc2_qty, elementID, colorData) {

            console.log(xData)

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
                    data: ['DC 1', 'DC 2']
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
                        name: 'DC 1',
                        type: 'bar',
                        color: 'rgb(6 24 61)',
                        barGap: 0,
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },
                        data: dc1_qty
                    },
                    {
                        name: 'DC 2',
                        type: 'bar',
                        color: 'rgb(255 109 16)',
                        barGap: 0,
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },
                        data: dc2_qty
                    },
                ]
            };

            option && myChart.setOption(option);
        }



        getOccupancy()


        function getOccupancy() {


            let stock_dc_1 = 0;
            let stock_dc_2 = 0;




            $.ajax({
                url: 'getStockDetailDC',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success == true) {

                        let data_dc1 = {
                            'stock': stock_dc_1,
                            'capacity': 10500,
                            'elementID': 'occupDC1',
                            'title': 'Occupancy DC 1',
                            'subtext': 'Monitoring Stock & Space Available DC 1'
                        }

                        let data_dc2 = {
                            'stock': stock_dc_2,
                            'capacity': 20000,
                            'elementID': 'occupDC2',
                            'title': 'Occupancy DC 2',
                            'subtext': 'Monitoring Stock & Space Available DC 2'
                        }

                        data_dc1.stock = response.data[0].STOCK_TODAY
                        data_dc2.stock = response.data[1].STOCK_TODAY

                        renderOccupancyPie(data_dc1)
                        renderOccupancyPie(data_dc2)
                    }
                }
            })

        }

        function renderOccupancyPie(data) {
            var chartDom = document.getElementById(data.elementID);
            var myChart = echarts.init(chartDom);
            var option;

            let qty_capacity = data.capacity
            let qty_stock = data.stock

            let qty_capacity_avail = qty_capacity - qty_stock
            let percent_capacity_avail = (qty_capacity_avail / qty_capacity) * 100

            let qty_capacty_usage = qty_stock
            let percent_capacty_usage = (qty_capacty_usage / qty_capacity) * 100

            option = {
                title: {
                    text: data.title,
                    subtext: data.subtext,
                    left: 'center'
                },
                tooltip: {
                    trigger: 'item'
                },
                legend: {
                    orient: 'vertical',
                    left: 'left'
                },
                series: [{
                    name: 'Capacity : ' + qty_capacity,
                    type: 'pie',
                    radius: '50%',
                    data: [{
                            value: qty_capacty_usage,
                            name: 'Space Usage ' + percent_capacty_usage.toFixed(2) + ' %'
                        },
                        {
                            value: qty_capacity_avail,
                            name: 'Space Available ' + percent_capacity_avail.toFixed(2) + ' %'
                        }
                    ],
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }]
            };

            option && myChart.setOption(option);
        }

        function renderChartMonthlyStock(xData, dc1_qty, dc2_qty, elementID, colorData) {

            console.log(xData)

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
                    data: ['DC 1', 'DC 2']
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
                        name: 'DC 1',
                        type: 'bar',
                        color: 'rgb(6 24 61)',
                        barGap: 0,
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },
                        data: dc1_qty,
                        markLine: {
                            data: [{
                                yAxis: 10500,
                                name: 'Threshold'
                            }],
                            lineStyle: {
                                color: 'rgb(6 24 61)',
                                type: 'dashed'
                            },
                            label: {
                                position: 'end',
                                formatter: 'DC 1 Capacity: 10,500'
                            }
                        }
                    },
                    {
                        name: 'DC 2',
                        type: 'bar',
                        color: 'rgb(255 109 16)',
                        barGap: 0,
                        label: labelOption,
                        emphasis: {
                            focus: 'series'
                        },
                        data: dc2_qty,
                        markLine: {
                            data: [{
                                yAxis: 20000,
                                name: 'Threshold'
                            }],
                            lineStyle: {
                                color: 'rgb(255 109 16)',
                                type: 'dashed'
                            },
                            label: {
                                position: 'end',
                                formatter: 'DC 1 Capacity: 20,000'
                            }
                        }
                    },
                ]
            };

            option && myChart.setOption(option);
        }
    })
</script>