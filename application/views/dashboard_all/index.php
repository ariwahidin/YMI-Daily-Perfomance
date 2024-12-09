
<div class="row">
    <div style="display: block;" class="col-md-12 tab-pane active show tabDash" id="DashboardDaily">
        <div class="row project-wrapper">
            <div class="col-xl-6">
                <div class="card">

                    <div class="card-header card-primary align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Inbound</h4>
                        <div class="flex-shrink-0">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-card" id="divInbound">
                            <table class="table table-sm table-responsive table-bordered border-secondary table-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>DC</th>
                                        <th>SJ Total</th>
                                        <th>SJ Complete</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6">
                <div class="card">

                    <div class="card-header card-success align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Outbound</h4>
                        <div class="flex-shrink-0">
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive table-card" id="divOutbound">
                            <table class="table table-sm table-responsive table-bordered border-secondary table-nowrap align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>DC</th>
                                        <th>PL Total</th>
                                        <th>PL Proses</th>
                                        <th>PL Complete</th>
                                        <th>SJ Total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
    <div style="display: none;" class="col-md-12 tab-pane tabDash" id="DashboardMonthly">
        <div class="d-felx">
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

<script src="<?= base_url('jar/html/default/') ?>assets/libs/echarts/echarts.min.js"></script>
<script>
    $(document).ready(function() {

    });
</script>

