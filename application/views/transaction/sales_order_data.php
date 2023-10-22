<link href="<?= base_url() ?>myassets/css/jquery.dataTables.min.css" rel="stylesheet" />
<script src="<?= base_url() ?>myassets/js/jquery-3.7.0.js"></script>
<script src="<?= base_url() ?>myassets/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>




<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Data sales order</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Data sales order</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col col-md-12">
        <div class="card">
            <div class="card-header">
                <a href="<?= base_url('transaction/salesorder') ?>" class="btn btn-primary" id="">Create New</a>
            </div>
            <div class="card-body">
                <table id="order-data" class="display" style="width:100%"></table>
            </div>
        </div>
    </div>
</div>

<!-- Default Modals -->
<div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-xl">
        <div style="background-color: var(--vz-body-bg) !important;" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Order Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body">
                <div class="card" id="demo">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Invoice No</p>
                                        <h5 class="fs-14 mb-0">#VL<span id="invoice-no">25000355</span></h5>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Date</p>
                                        <h5 class="fs-14 mb-0"><span id="invoice-date">23 Nov, 2021</span> <small class="text-muted" id="invoice-time">02:36PM</small></h5>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Payment Status</p>
                                        <span class="badge bg-success-subtle text-success fs-11" id="payment-status">Paid</span>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-3 col-6">
                                        <p class="text-muted mb-2 text-uppercase fw-semibold">Total Amount</p>
                                        <h5 class="fs-14 mb-0">$<span id="total-amount">755.96</span></h5>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4 border-top border-top-dashed">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <h6 class="text-muted text-uppercase fw-semibold mb-3">Billing Address</h6>
                                        <p class="fw-medium mb-2" id="billing-name">David Nichols</p>
                                        <p class="text-muted mb-1" id="billing-address-line-1">305 S San Gabriel Blvd</p>
                                        <p class="text-muted mb-1"><span>Phone: +</span><span id="billing-phone-no">(123) 456-7890</span></p>
                                        <p class="text-muted mb-0"><span>Tax: </span><span id="billing-tax-no">12-3456789</span> </p>
                                    </div>
                                    <!--end col-->
                                    <div class="col-6">
                                        <h6 class="text-muted text-uppercase fw-semibold mb-3">Shipping Address</h6>
                                        <p class="fw-medium mb-2" id="shipping-name">David Nichols</p>
                                        <p class="text-muted mb-1" id="shipping-address-line-1">305 S San Gabriel Blvd</p>
                                        <p class="text-muted mb-1"><span>Phone: +</span><span id="shipping-phone-no">(123) 456-7890</span></p>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                        <div class="col-lg-12">
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                        <thead>
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col">Product Details</th>
                                                <th scope="col">Rate</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col" class="text-end">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="products-list">
                                            <tr>
                                                <th scope="row">01</th>
                                                <td class="text-start">
                                                    <span class="fw-medium">Sweatshirt for Men (Pink)</span>
                                                    <p class="text-muted mb-0">Graphic Print Men & Women Sweatshirt</p>
                                                </td>
                                                <td>$119.99</td>
                                                <td>02</td>
                                                <td class="text-end">$239.98</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">02</th>
                                                <td class="text-start">
                                                    <span class="fw-medium">Noise NoiseFit Endure Smart Watch</span>
                                                    <p class="text-muted mb-0">32.5mm (1.28 Inch) TFT Color Touch Display</p>
                                                </td>
                                                <td>$94.99</td>
                                                <td>01</td>
                                                <td class="text-end">$94.99</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">03</th>
                                                <td class="text-start">
                                                    <span class="fw-medium">350 ml Glass Grocery Container</span>
                                                    <p class="text-muted mb-0">Glass Grocery Container (Pack of 3, White)</p>
                                                </td>
                                                <td>$24.99</td>
                                                <td>01</td>
                                                <td class="text-end">$24.99</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">04</th>
                                                <td class="text-start">
                                                    <span class="fw-medium">Fabric Dual Tone Living Room Chair</span>
                                                    <p class="text-muted mb-0">Chair (White)</p>
                                                </td>
                                                <td>$340.00</td>
                                                <td>01</td>
                                                <td class="text-end">$340.00</td>
                                            </tr>
                                        </tbody>
                                    </table><!--end table-->
                                </div>
                                <div class="border-top border-top-dashed mt-2">
                                    <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                        <tbody>
                                            <tr>
                                                <td>Sub Total</td>
                                                <td class="text-end">$699.96</td>
                                            </tr>
                                            <tr>
                                                <td>Estimated Tax (12.5%)</td>
                                                <td class="text-end">$44.99</td>
                                            </tr>
                                            <tr>
                                                <td>Discount <small class="text-muted">(VELZON15)</small></td>
                                                <td class="text-end">- $53.99</td>
                                            </tr>
                                            <tr>
                                                <td>Shipping Charge</td>
                                                <td class="text-end">$65.00</td>
                                            </tr>
                                            <tr class="border-top border-top-dashed fs-15">
                                                <th scope="row">Total Amount</th>
                                                <th class="text-end">$755.96</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--end table-->
                                </div>
                                <div class="mt-3">
                                    <h6 class="text-muted text-uppercase fw-semibold mb-3">Payment Details:</h6>
                                    <p class="text-muted mb-1">Payment Method: <span class="fw-medium" id="payment-method">Mastercard</span></p>
                                    <p class="text-muted mb-1">Card Holder: <span class="fw-medium" id="card-holder-name">David Nichols</span></p>
                                    <p class="text-muted mb-1">Card Number: <span class="fw-medium" id="card-number">xxx xxxx xxxx 1234</span></p>
                                    <p class="text-muted">Total Amount: <span class="fw-medium" id="">$ </span><span id="card-total-amount">755.96</span></p>
                                </div>
                                <!-- <div class="mt-4">
                                    <div class="alert alert-info">
                                        <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                            <span id="note">All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or
                                                credit card or direct payment online. If account is not paid within 7
                                                days the credits details supplied as confirmation of work undertaken
                                                will be charged the agreed quoted fee noted above.
                                            </span>
                                        </p>
                                    </div>
                                </div> -->
                            </div>
                            <!--end card-body-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
                <!--end card-->

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary ">Save Changes</button> -->
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script src="<?= base_url() ?>myassets/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "<?= base_url('transaction/getDataSalesOrder') ?>",
            method: 'GET',
            dataType: 'JSON',
            success: function(response) {
                let data = response.data.order
                // console.log(data);
                let table = $('#order-data').DataTable({
                    responsive: true,
                    lengthChange: true,
                    data: data, // Data yang akan dimasukkan
                    pageLength: 10, // Batasi jumlah data yang ditampilkan menjadi 5
                    columns: [{
                            data: null,
                            title: 'No.',
                            render: function(data, type, row, meta) {
                                return meta.row + 1; // Menggunakan nomor baris sebagai nomor urut, mulai dari 1
                            }
                        }, {
                            data: null,
                            title: 'Order Id',
                            render: function(data, type, row) {
                                return `${data.id}`;
                            }
                        }, {
                            data: null,
                            title: 'CustName',
                            render: function(data, type, row) {
                                return `${data.CustName}`;
                            }
                        }, {
                            data: null,
                            title: 'Subtotal',
                            render: function(data, type, row) {
                                return `<div style="text-align: right;">${formatCurrency(data.Subtotal)}</div>`;
                            }
                        },
                        {
                            data: null,
                            title: 'DiscPercent',
                            render: function(data, type, row) {
                                return `<div style="text-align: right;">${data.DiscPercent}</div>`;
                            }
                        }, {
                            data: null,
                            title: 'DiscAmount',
                            render: function(data, type, row) {
                                return `<div style="text-align: right;">${formatCurrency(data.DiscAmount)}</div>`;
                            }
                        }, {
                            data: null,
                            title: 'GrandTotal',
                            render: function(data, type, row) {
                                return `<div style="text-align: right;">${formatCurrency(data.GrandTotal)}</div>`;
                            }
                        }, {
                            data: null,
                            title: 'Action',
                            render: function(data, type, row) {
                                return `<button id="addButton" 
                                data-id="${data.id}" 
                                class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#myModal">Detail</button>`;
                            }
                        }
                    ]
                });
            },
            error: function(error) {
                console.error('Gagal mengambil data dari API: ', error);
            }
        });
    })

    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(value);
    }
</script>