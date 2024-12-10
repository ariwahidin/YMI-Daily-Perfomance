<?php
// var_dump($task->result());
// die;
?>

<?php foreach ($task->result() as $data) { ?>
    <div class="row">
        <div class="col">
            <div class="card bg-success-subtle">
                <div class="card-header card-primary">
                    <div style="font-size: 11px;" class="row">
                        <div class="col-md-3 col-6 ps-3">
                            <p class="m-0">Activity Date : <span> <?= $data->activity_date ?? '' ?></span></p>
                            <p class="m-0">Dest : <span style="font-size: 11px;" class="badge badge-pill bg-danger"><strong><?= $data->dest ?? '' ?></strong></span></p>
                            <p class="m-0">PL No :
                            <ul>

                                <?php foreach (getPlNo($data->id)->result() as $pl) { ?>
                                    <li class="fs-8">
                                        <span class="badge badge-pill bg-success">
                                            <strong><?= $pl->pl_no ?? '' ?></strong>
                                        </span>
                                    </li>
                                <?php } ?>
                            </ul>
                            </p>
                            <p class="m-0">Pintu Loading : <span><?= $data->pintu_loading ?? '' ?></span></p>
                            <p class="m-0">Remarks : <span><?= $data->remarks ?? '' ?></span></p>
                        </div>
                        <div class="col-md-2 col-6">
                            <p class="m-0">Picker :
                            <ul>
                                <?php foreach (getPickerOB($data->id)->result() as $picker) { ?>
                                    <li class="fs-8">
                                        <span class="badge badge-pill bg-success">
                                            <strong><?= $picker->fullname ?? '' ?></strong>
                                        </span>
                                    </li>
                                <?php } ?>
                            </ul>
                            </p>
                            <p class="m-0">Checker :
                            <ul>
                            </ul>
                            </p>
                            <p class="m-0">Scanner : </p>
                            <ul>
                            </ul>
                        </div>
                        <div class="col-md-6 pt-1">
                            <button class="btn btn-sm btn-success btnEdit" data-id="<?= $data->id ?>">Edit</button>
                            <button class="btn btn-sm btn-danger btnDelete" data-id="<?= $data->id ?>">Delete</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-header p-2 ps-3">
                                    <span class="m-0 fw-semibold fs-14">Picking</span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <?php $start_picking = duration($data->id)->start_picking ?>
                                                <?php $stop_picking = duration($data->id)->stop_picking ?>
                                                <span class="text-muted">Start : </span>
                                                <span class="text-muted"> <?= $start_picking == null ? '' : date('H:i', strtotime($start_picking)) ?> </span>
                                            </h5>
                                            <h5 class="text-success fs-14 mb-0">
                                                <span class="text-muted">Stop : </span>
                                                <span class="text-muted"> <?= $stop_picking  == null ? '' : date('H:i', strtotime($stop_picking)) ?>
                                                </span>
                                            </h5>
                                            <h5 class="text-success fs-14 mb-0">
                                                <span class="text-muted">Duration : </span>
                                                <span class="text-muted"><?php echo countDuration($start_picking, $stop_picking) ?></span>
                                            </h5>
                                        </div>
                                        <div class="align-items-end">
                                            <div class="avatar-sm flex-shrink-0">

                                                <?php if ($data->picking_status == 'open') { ?>
                                                    <button class="btn btn-sm btn-success rounded fs-2 btnActivity" data-id="<?= $data->id ?>" data-name="Start Picking" data-proses="start_picking" data-activity="picking">
                                                        <i class="bx bx-play"></i>
                                                    </button>
                                                <?php } ?>

                                                <?php if ($data->picking_status == 'processing') { ?>
                                                    <button class="btn btn-sm btn-danger rounded fs-2 btnActivity" data-id="<?= $data->id ?>" data-name="Stop Picking" data-proses="stop_picking" data-activity="picking">
                                                        <i class="bx bx-stop"></i>
                                                    </button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-header p-2 ps-3">
                                    <span class="m-0 fw-semibold fs-14">Checking</span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <?php $start_checking = duration($data->id)->start_checking ?>
                                        <?php $stop_checking = duration($data->id)->stop_checking ?>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <span class="text-muted">Start : </span>
                                                <span class="text-muted"><?= $start_checking == null ? '' : date('H:i', strtotime($start_checking)) ?></span>
                                            </h5>
                                            <h5 class="text-success fs-14 mb-0">
                                                <span class="text-muted">Stop : </span>
                                                <span class="text-muted"><?= $stop_checking == null ? '' : date('H:i', strtotime($stop_checking)) ?></span>
                                            </h5>
                                            <h5 class="text-success fs-14 mb-0">
                                                <span class="text-muted">Duration : </span>
                                                <span class="text-muted"><?php echo countDuration($start_checking, $stop_checking) ?></span>
                                            </h5>
                                        </div>
                                        <div class="align-items-end">
                                            <div class="avatar-sm flex-shrink-0">
                                                <?php if ($data->checking_status == 'open') { ?>
                                                    <button class="btn btn-sm btn-success rounded fs-2 btnActivity" data-id="<?= $data->id ?>" data-name="Start Checking" data-proses="start_checking" data-activity="checking">
                                                        <i class="bx bx-play"></i>
                                                    </button>
                                                <?php } ?>

                                                <?php if ($data->checking_status == 'processing') { ?>
                                                    <button class="btn btn-sm btn-danger rounded fs-2 btnActivity" data-id="<?= $data->id ?>" data-name="Stop Checking" data-proses="stop_checking" data-activity="checking">
                                                        <i class="bx bx-stop"></i>
                                                    </button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-header p-2 ps-3">
                                    <span class="m-0 fw-semibold fs-14">Scanning</span>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <?php $start_scanning = duration($data->id)->start_scanning ?>
                                        <?php $stop_scanning = duration($data->id)->stop_scanning ?>
                                        <div class="flex-shrink-0">
                                            <h5 class="text-success fs-14 mb-0">
                                                <span class="text-muted">Start : </span>
                                                <span class="text-muted"><?= $start_scanning == null ? '' : date('H:i', strtotime($start_scanning)) ?></span>
                                            </h5>
                                            <h5 class="text-success fs-14 mb-0">
                                                <span class="text-muted">Stop : </span>
                                                <span class="text-muted"><?= $stop_scanning == null ? '' : date('H:i', strtotime($stop_scanning)) ?></span>
                                            </h5>
                                            <h5 class="text-success fs-14 mb-0">
                                                <span class="text-muted">Duration : </span>
                                                <span class="text-muted"><?php echo countDuration($start_scanning, $stop_scanning) ?></span>
                                            </h5>
                                        </div>
                                        <div class="align-items-end">
                                            <div class="avatar-sm flex-shrink-0">
                                                <div class="avatar-sm flex-shrink-0">
                                                    <?php if ($data->scanning_status == 'open') { ?>
                                                        <button class="btn btn-sm btn-success rounded fs-2 btnActivity" data-id="<?= $data->id ?>" data-name="Start Scanning" data-proses="start_scanning" data-activity="scanning">
                                                            <i class="bx bx-play"></i>
                                                        </button>
                                                    <?php } ?>

                                                    <?php if ($data->scanning_status == 'processing') { ?>
                                                        <button class="btn btn-sm btn-danger rounded fs-2 btnActivity" data-id="<?= $data->id ?>" data-name="Stop Scanning" data-proses="stop_scanning" data-activity="scanning">

                                                            <i class="bx bx-stop"></i>
                                                        </button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php } ?>