<x-layout title="Dashboard">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Low Stock Medication</h5>
        </div>

        <hr class="hr">
        
        <table class="table my-3" id="inventory-admin-data">
            <thead>
                <tr>
                    <th>No</th>
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
        // Fetch data for both tables
        $.ajax({
            url: '{{ route("admin.dashboard") }}',
            type: 'GET',
            success: function(response) {
                // Initialize Low Stock Medication DataTable
                $('#inventory-admin-data').DataTable({
                    data: response.inventory,
                    columns: [
                        {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
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
                        { width: '15%', targets: 1 },
                        { width: '10%', targets: 7 },
                    ],
                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td:eq(7)').addClass('text-center');
                    }
                });
            },
            error: function(response) {
                console.error('Error fetching data:', response);
            }
        });
        
        $(document).on('click', '.view-inventory-btn', function() {
            var dataId = $(this).data('id');

            window.location.href = '{{ url("/inventory/details") }}/' + dataId;
        });
    });
</script>
@endsection
</x-layout>