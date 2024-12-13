<link href="<?= base_url() ?>myassets/css/select2.min.css" rel="stylesheet" />
<style>
    .swal2-container {
        z-index: 9999;
    }

    .modal-header {
        cursor: move;
    }

    .detail-row {
        background-color: #f8f9fa;
    }

    .sub-table {
        width: 100%;
        margin-bottom: 0;
    }

    .hover-expand:hover {
        cursor: pointer;
    }
</style>
<div class="row">
    <div class="col col-md-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Outbound List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Outbound List</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary d-flex">
                <span style="white-space: nowrap; color: whitesmoke; padding-top: 10px;">Activity Date : &nbsp; </span>
                <input type="text" class="form-control" style="display:none; width: 200px; margin-right: 10px;" id="sChecker" placeholder="Checker">
                <input type="date" class="form-control" style="width: 200px; margin-right: 10px;" id="sStartDate" placeholder="Start Date">
                <input type="date" class="form-control" style="width: 200px; margin-right: 10px;" id="sEndDate" placeholder="End Date">
                <button class="btn btn-outline-success" id="sButton"><i class="ri-filter-fill"></i></button>&nbsp;&nbsp;
            </div>
            <div class="card-body">
                <div class="table-responsive table-card" id="tableContainer">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Outbound</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Remarks</label>
                        <input type="text" class="form-control" name="editRemarks" id="editRemarks" required>
                        <input type="hidden" name="editId" id="editId">
                        <input type="hidden" name="uid" id="uid">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveEdit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Bootstrap 5 JS dan Popper.js -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script> -->

<!-- DataTables JS -->
<!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> -->

<script>
    $(document).ready(function() {
        let table = null;

        getTable();

        function getTable() {
            var today = new Date().toISOString().split('T')[0];
            if ($('#sStartDate').val() == '') {
                $('#sStartDate').val(today)
            }
            if ($('#sEndDate').val() == '') {
                $('#sEndDate').val(today)
            }

            let sDate = $('#sStartDate').val();
            let eDate = $('#sEndDate').val();
            $.post('getTableOutbound', {
                start_date: sDate,
                end_date: eDate
            }, function(response) {
                $('#tableContainer').html(response.table);
                if (table) table.destroy();
                table = $('#outboundTable').DataTable({});
            }, 'JSON')
        }

        $('#sButton').on('click', function() {
            getTable();
        });

        // Event untuk expand/collapse detail
        $('#tableContainer').on('click', '#outboundTable tbody td.dt-control', function() {
            const tr = $(this).closest('tr');
            let id = $(this).data('id');

            console.log(id);
            // console.log(tr);
            // return;

            const row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                $.get('getDetailOutbound/' + id, {
                    id
                }, function(response) {
                    const rowData = response.data;
                    const detailHtml = `
                    <table class="sub-table table table-bordered">
                        <thead>
                            <tr>
                                <th>PL No.</th>
                                <th>Dealer</th>
                                <th>No Truck</th>
                                <th>SJ No</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${rowData.map(subId => `
                                <tr>
                                    <td>${subId.pl_no}</td>
                                    <td>${subId.dealer_det}</td>
                                    <td>${subId.no_truck}</td>
                                    <td>${subId.sj_no}</td>
                                    <td>${subId.remarks}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;
                    row.child(detailHtml).show();
                    tr.addClass('shown');
                }, 'JSON');

            }
        });

        $('#tableContainer').on('click', '.btnEdit', function() {
            const items = $(this).data('items');
            $('#editRemarks').val(items.remarks);
            $('#editId').val(items.id);
            $('#uid').val(items.uid);
            $('#editModal').modal('show');
        });

        $("#editForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'editOutbound',
                type: 'POST',
                data: $('#editForm').serialize(),
                dataType: 'JSON',
                success: function(response) {
                    if (response.success) {
                        $('#editModal').modal('hide');
                        getTable();
                    }
                }
            })
            // $.post('editOutbound', {
            //     data: $('#editForm').serialize()
            // }, function(response) {
            //     if (response.success) {
            //         $('#editModal').modal('hide');
            //         getTable();
            //     }
            // }, 'JSON')
        });

    });
</script>