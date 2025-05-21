<x-layout title="Appointment">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Appointment Scheduling</h5>
        </div>
        
        <hr class="hr">

        <form method="POST" id="searchForm">
        @csrf
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Date</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="app_date" name="app_date" autocomplete="off" />
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Time</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="app_start_time_id" name="app_start_time_id">
                            <option value="" selected></option>
                            @foreach ($appointmentTimes as $appointmentTime)
                            <option value="{{ $appointmentTime->id }}">{{ $appointmentTime->app_time }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Department</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="dept_id" name="dept_id">
                            <option value="" selected>ALL</option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>

        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Department</th>
                    <th>Doctor Name</th>
                    <th>Years of Experience</th>
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
        $('#btn-back').css('display', 'block');

        $('#btn-back').on('click', function() {
            window.location.href = '{{ route("appointment") }}';
        });
        
        $('#app_date').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy', 
            minDate: new Date()
        });

        var table = $('#admin-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('appointment.search') }}",
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: function (d) {
                    d.app_date = $('#app_date').val();
                    d.app_start_time_id = $('#app_start_time_id').val();
                    d.dept_id = $('#dept_id').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                {data: 'dept_name', name: 'dept_name'},
                {data: 'name', name: 'name'},
                {data: 'years_of_experience', name: 'years_of_experience'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            autoWidth: false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '10%', targets: 4 },
            ]
        });

        // Handle form submission to reload DataTable with new data
        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            
            table.ajax.reload();
        });

        $(document).on('click', '.book-btn', function() {
            var dataId = $(this).data('id');
            var appDate = $('#app_date').val();
            var appStartTimeId = $('#app_start_time_id').val();

            window.location.href = '{{ url("/appointment/details") }}/' + dataId + '?app_date=' + appDate + '&app_start_time_id=' + appStartTimeId;
        });
    });
</script>
@endsection
</x-layout>