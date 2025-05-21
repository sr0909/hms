<x-layout title="Inventory Management">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Inventory Management</h5>
            <button class="btn btn-light" id="btn-create" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create">
                <i class="bi bi-plus-lg h3"></i>
            </button>
        </div>
        
        <hr class="hr">

        <div class="row mb-4">
            <div class="col-sm-2 mt-2">
                <label class="fw-medium">Filter By Status</label>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <select class="form-select" id="filter_status" name="filter_status">
                        <option value="ALL">ALL</option>
                        <option value="Active" selected>Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>
            </div>
        </div>
        
        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Medicine ID</th>
                    <th>Medicine Name</th>
                    <th>Batch No.</th>
                    <th>Expiry Date</th>
                    <th>Qty</th>
                    <th>Reorder Level</th>
                    <th>Reorder Qty</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

@section('js_content')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#admin-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("inventory") }}',
                data: function (d) {
                    d.filter_status = $('#filter_status').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                {data: 'medicine_id', name: 'medicine_id'},
                {data: 'medicine_name', name: 'medicine_name'},
                {data: 'batch_no', name: 'batch_no'},
                {data: 'expiry_date', name: 'expiry_date'},
                {data: 'quantity', name: 'quantity'},
                {data: 'reorder_level', name: 'reorder_level'},
                {data: 'reorder_quantity', name: 'reorder_quantity'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            autoWidth: false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '13%', targets: 1 },
                { width: '10%', targets: 8 },
            ]
        });

        $('#filter_status').change(function() {
            table.ajax.reload();
        });

        $('#btn-create').click(function(e) {
            window.location.href = '{{ route("inventory.details") }}';
        });

        $(document).on('click', '.edit-btn', function() {
            var dataId = $(this).data('id');

            window.location.href = '{{ url("/inventory/details") }}/' + dataId;
        });

        $(document).on('click', '.delete-btn', function() {
            var dataId = $(this).data('id');

            Swal.fire({
                title: "Are you sure to delete this?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{ url("/inventory/delete") }}/' + dataId,
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}', id: dataId },
                        success: function(response) {
                            var message = response.message;

                            if (response.state == 'success') {
                                Swal.fire('Success', message, 'success');

                                table.ajax.reload();
                            }
                        },
                        error: function(response) {
                            var errorMessage = response.responseJSON.message;
                        
                            Swal.fire('Error', errorMessage, 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
</x-layout>