<div class="row">
    <div class="col-xl-3 col-md-3">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <strong class="text-uppercase fs-16 text-bold mb-0">ON PICKING</strong>
                    </div>
                </div>
                <div class="align-items-end justify-content-between mt-1 overflow-hidden">
                    <?php foreach (getDestOnPick()->result() as $key => $dp) {
                        if (($key + 1) % 5 == 0) {
                            echo '<br/>';
                        }
                    ?>
                        <span style="max-width: fit-content;" class="avatar-title bg-primary d-inline-block text-light rounded-2 fs-5 px-2 m-1"><?= $dp->dest ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <strong class="text-uppercase fs-16 text-bold mb-0">ON CHECKING</strong>
                    </div>
                </div>
                <div class="align-items-end justify-content-between mt-1 overflow-hidden">
                    <?php foreach (getDestOnCheck()->result() as $key => $dc) {
                        if (($key + 1) % 5 == 0) {
                            echo '<br/>';
                        }
                    ?>
                        <span style="max-width: fit-content;" class="avatar-title bg-primary d-inline-block text-light rounded-2 fs-5 px-2 m-1"><?= $dc->dest ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <strong class="text-uppercase fs-16 text-bold mb-0">ON SCANNING</strong>
                    </div>
                </div>
                <div class="align-items-end justify-content-between mt-1 overflow-hidden">
                    <?php foreach (getDestOnScan()->result() as $key => $ds) {
                        if (($key + 1) % 5 == 0) {
                            echo '<br/>';
                        }
                    ?>
                        <span style="max-width: fit-content;" class="avatar-title bg-primary d-inline-block text-light rounded-2 fs-5 px-2 m-1"><?= $ds->dest ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <strong class="text-uppercase fs-16 text-bold mb-0">ON LOAD</strong>
                    </div>
                </div>
                <div class="align-items-end justify-content-between mt-1 overflow-hidden">
                    <?php foreach (getDestOnLoad()->result() as $key => $dl) {
                        if (($key + 1) % 5 == 0) {
                            echo '<br/>';
                        }
                    ?>
                        <span style="max-width: fit-content;" class="avatar-title bg-primary d-inline-block text-light rounded-2 fs-5 px-2 m-1"><?= $dl->dest ?></span>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>