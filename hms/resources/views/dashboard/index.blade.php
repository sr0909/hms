<x-layout title="Dashboard">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Upcoming Appointment</h5>
        </div>

        <hr class="hr">
        
        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Duration</th>
                    <th>Department</th>
                    <th>Doctor Name</th>
                    <th>Type</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Recent Medical Records</h5>
        </div>

        <hr class="hr">
        
        <table class="table my-3" id="medicalrecord-admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Department</th>
                    <th>Doctor Name</th>
                    <th>Notes</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<iframe id="print-frame" style="display:none;"></iframe>

@section('js_content')
<script type="text/javascript">
    $(document).ready(function() {
        // Fetch data for both tables
        $.ajax({
            url: '{{ route("dashboard") }}',
            type: 'GET',
            success: function(response) {
                // Initialize Upcoming Appointment DataTable
                $('#admin-data').DataTable({
                    data: response.appointments,
                    columns: [
                        {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'app_date', name: 'app_date'},
                        {data: 'app_time', name: 'app_time'},
                        {data: 'formatted_duration', name: 'formatted_duration'},
                        {data: 'dept_name', name: 'dept_name'},
                        {data: 'doctor_name', name: 'doctor_name'},
                        {data: 'type', name: 'type'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    autoWidth: false,
                    columnDefs: [
                        { width: '5%', targets: 0 },
                        { width: '12%', targets: 1 },
                        { width: '10%', targets: 6 },
                        { width: '10%', targets: 7 },
                    ],
                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td:eq(7)').addClass('text-center');
                    }
                });

                // Initialize Recent Medical Records DataTable
                $('#medicalrecord-admin-data').DataTable({
                    data: response.medical_records,
                    columns: [
                        {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'medical_record_date', name: 'medical_record_date'},
                        {data: 'dept_name', name: 'dept_name'},
                        {data: 'doctor_name', name: 'doctor_name'},
                        {data: 'notes', name: 'notes'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                    autoWidth: false,
                    columnDefs: [
                        { width: '5%', targets: 0 },
                        { width: '10%', targets: 5 },
                    ],
                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td:eq(5)').addClass('text-center');
                    }
                });
            },
            error: function(response) {
                console.error('Error fetching data:', response);
            }
        });

        $(document).on('click', '.view-appointment-btn', function() {
            var dataId = $(this).data('id');

            window.location.href = '{{ url("/appointment/details") }}/' + dataId;
        });

        $(document).on('click', '.view-medical-record-btn', function() {
            var dataId = $(this).data('id');

            $.ajax({
                url: '{{ url("/medicalrecord/print") }}/' + dataId,
                type: 'GET',
                success: function(response) {
                    var printFrame = $('#print-frame');
                    var doc = printFrame[0].contentDocument || printFrame[0].contentWindow.document;
                    doc.open();
                    doc.write(response);
                    doc.close();
                    printFrame[0].contentWindow.focus();
                    printFrame[0].contentWindow.print();
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        });
    });
</script>
@endsection
</x-layout>