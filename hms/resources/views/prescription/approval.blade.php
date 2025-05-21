<x-layout title="Prescription">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Prescription Approval</h5>
        </div>
        
        <hr class="hr">

        <!-- <form method="POST" id="createForm">
        @csrf -->
            <input type="hidden" id="hidden_treatment_id" value="{{ $treatment->treatment_id ?? '' }}"/>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Patient Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ $patientName ?? '' }}" autocomplete="off" maxlength="150" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Doctor Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="doctor_name" name="doctor_name" value="{{ $doctorName ?? '' }}" autocomplete="off" maxlength="150" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Diagnosis Result</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="diagnosis_name" name="diagnosis_name" value="{{ $diagnosis->diagnosis_name ?? '' }}" autocomplete="off" maxlength="255" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Treatment</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="treatment_name" name="treatment_name" value="{{ $treatment->treatment_name ?? '' }}" autocomplete="off" maxlength="255" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Diagnosis Description</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <textarea type="text" row="3" class="form-control" id="diagnosis_description" name="diagnosis_description" autocomplete="off" required readonly disabled>{{ $diagnosis->diagnosis_description ?? '' }}</textarea>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Treatment Description</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <textarea type="text" row="3" class="form-control" id="treatment_description" name="treatment_description" autocomplete="off" required readonly disabled>{{ $treatment->treatment_description ?? '' }}</textarea>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Start Date</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="start_date" name="start_date" autocomplete="off" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">End Date</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="end_date" name="end_date" autocomplete="off" readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <!-- <div class="row mt-3">
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form> -->
    </div>
</div>

<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Prescription Line</h5>
            <!-- <button class="btn btn-light" id="btn-create" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create">
                <i class="bi bi-plus-lg h3"></i>
            </button> -->
        </div>
        
        <hr class="hr">

        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Medicine Name</th>
                    <th>Dosage</th>
                    <th>Frequency</th>
                    <th>Duration</th>
                    <th>Instructions</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <div class="row mt-3">
            <div class="col text-end">
                <button class="btn btn-danger" id="btn-reject" type="button">Reject</button>
                <button class="btn btn-success" id="btn-approve" type="button">Approve</button>
            </div>
        </div>
    </div>
</div>

@section('js_content')
<script type="text/javascript">
    $(document).ready(function() {
        $('#btn-back').css('display', 'block');

        $('#btn-back').on('click', function() {
            window.location.href = '{{ route("prescriptionapproval") }}';
        });

        var start_date = '{{ $treatment->start_date ?? '' }}';
        var formattedStartDate = start_date.split('-').reverse().join('-');
        $('#start_date').val(formattedStartDate);

        var end_date = '{{ $treatment->end_date ?? '' }}';
        var formattedEndDate = end_date.split('-').reverse().join('-');
        $('#end_date').val(formattedEndDate);

        var treatmentId = $('#hidden_treatment_id').val();

        // Prescription Line Datatable
        var table = $('#admin-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("prescriptionapproval.approval") }}',
                data: function (d) {
                    d.treatmentId = treatmentId;
                }
            },
            columns: [
                {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                {data: 'medicine_name', name: 'medicine_name'},
                {data: 'dosage', name: 'dosage'},
                {data: 'frequency', name: 'frequency'},
                {data: 'duration', name: 'duration'},
                {data: 'instructions', name: 'instructions'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            autoWidth: false,
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '15%', targets: 1 },
                { width: '10%', targets: 6 },
            ]
        });

        $('#btn-approve').click(function(e) {
            var treatmentId = $('#hidden_treatment_id').val();

            // Approve Prescription
            $.ajax({
                url: '{{ url("prescriptionapproval/approve") }}/' + treatmentId,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.state == 'success') {
                        Swal.fire('Success', response.message, 'success').then(() => {
                            window.location.href = '{{ route("prescriptionapproval") }}';
                        });
                        
                    }else if (response.state == 'error') {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                        
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        });

        $('#btn-reject').click(function(e) {
            var treatmentId = $('#hidden_treatment_id').val();

            // Approve Prescription
            $.ajax({
                url: '{{ url("prescriptionapproval/reject") }}/' + treatmentId,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.state == 'success') {
                        Swal.fire('Success', response.message, 'success').then(() => {
                            window.location.href = '{{ route("prescriptionapproval") }}';
                        });
                        
                    }else if (response.state == 'error') {
                        Swal.fire('Error', response.message, 'error');
                    }
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                        
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        });

        $(document).on('click', '.edit-btn', function() {
            var dataId = $(this).data('id');

            window.location.href = '{{ url("prescriptionapproval/details") }}/' + dataId;
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
                        url: '{{ url("/prescriptionapproval/delete") }}/' + dataId,
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}', id: dataId },
                        success: function(response) {
                            var message = response.message;

                            if (response.state == 'success') {
                                Swal.fire('Success', message, 'success');

                                table.ajax.reload();
                            } else if (response.state == 'error') {
                                Swal.fire('Error', message, 'error');
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