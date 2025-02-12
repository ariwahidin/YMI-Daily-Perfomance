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
                            <h5 class="text-muted text-uppercase fs-13">TOTAL IN <i class="ri-arrow-down-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-inbox-archive-fill display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span><?= number_format($stock->TOTAL_INBOUND); ?></span></h2>
                                </div>
                            </div>
                            <span class="badge bg-danger-subtle text-danger fs-12">DC 1 : <?= number_format($stock_detail[0]->TOTAL_INBOUND); ?></span>
                            <span class="badge bg-danger-subtle text-danger fs-12">DC 2 : <?= number_format($stock_detail[1]->TOTAL_INBOUND); ?></span>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">TOTAL OUT <i class="ri-arrow-up-circle-line text-success fs-18 float-end align-middle"></i></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-inbox-unarchive-fill display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h2 class="mb-0"><span><?= number_format($stock->TOTAL_OUTBOUND); ?></span></h2>
                                </div>
                            </div>
                            <span class="badge bg-danger-subtle text-danger fs-12">DC 1 : <?= number_format($stock_detail[0]->TOTAL_OUTBOUND); ?></span>
                            <span class="badge bg-danger-subtle text-danger fs-12">DC 2 : <?= number_format($stock_detail[1]->TOTAL_OUTBOUND); ?></span>
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
    </div><!-- end col -->
</div>

<div class="row">
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
        $('#inputMonthInbound').val(currentMonth);
        $('#inputMonthOutbound').val(currentMonth);

        getInboundMonthly();
        getOutboundMonthly();

        $('#inputMonthInbound').on('change', function() {
            getInboundMonthly();
        })
        $('#inputMonthOutbound').on('change', function() {
            getOutboundMonthly();
        })

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
    })
</script>