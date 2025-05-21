<x-layout title="Appointment">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Appointment</h5>
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
                        <option value="Scheduled" selected>Scheduled</option>
                        <option value="Completed">Completed</option>
                        <option value="Incompleted">Incompleted</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>
        
        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Duration</th>
                    @if (Auth::user()->hasRole('normal user'))
                        <th>Doctor Name</th>
                    @elseif (Auth::user()->hasRole('doctor'))
                        <th>Patient Name</th>
                    @endif
                    <th>Department</th>
                    <th>Type</th>
                    <th>Status</th>
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
                url: '{{ route("appointment") }}',
                data: function (d) {
                    d.filter_status = $('#filter_status').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                {data: 'app_date', name: 'app_date'},
                {data: 'app_time', name: 'app_time'},
                {data: 'formatted_duration', name: 'formatted_duration'},
                @if (Auth::user()->hasRole('normal user'))
                    { data: 'doctor_name', name: 'doctor_name' },
                @elseif (Auth::user()->hasRole('doctor'))
                    { data: 'patient_name', name: 'patient_name' },
                @endif
                {data: 'dept_name', name: 'dept_name'},
                {data: 'type', name: 'type'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            autoWidth: false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '12%', targets: 1 },
                { width: '10%', targets: 7 },
                { width: '10%', targets: 8 },
            ]
        });

        $('#filter_status').change(function() {
            table.ajax.reload();
        });

        $('#btn-create').click(function(e) {
            @if (Auth::user()->hasRole('normal user'))
                window.location.href = '{{ route("appointment.search") }}';
            @elseif (Auth::user()->hasRole('doctor'))
                window.location.href = '{{ route("admin.appointment.details") }}';
            @endif
        });

        $(document).on('click', '.edit-btn', function() {
            var dataId = $(this).data('id');

            // Normal user (patient) portal
            @if (Auth::user()->hasRole('normal user'))
                window.location.href = '{{ url("/appointment/details") }}/' + dataId;
            // Doctor portal
            @elseif (Auth::user()->hasRole('doctor'))
                window.location.href = '{{ url("/admin/appointment/details") }}/' + dataId;
            @endif
        });

        $(document).on('click', '.delete-btn', function() {
            var dataId = $(this).data('id');

            Swal.fire({
                title: "Are you sure to delete this appointment?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{ url("/appointment/delete") }}/' + dataId,
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