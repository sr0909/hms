<x-layout title="Medical Record">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Diagnosis Result</h5>
        </div>
        
        <hr class="hr">
        
        <form method="POST" id="createForm">
        @csrf
            <input type="hidden" id="hidden_diagnosis_id" value="{{ $diagnosis->diagnosis_id ?? '' }}"/>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Diagnosis ID</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="diagnosis_id" name="diagnosis_id" value="{{ $diagnosis->diagnosis_id ?? '' }}" autocomplete="off" maxlength="10" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Medical Record ID</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="medical_record_id" name="medical_record_id" value="{{ $medicalrecordid ?? '' }}" autocomplete="off" maxlength="10" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Diagnosis Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="diagnosis_name" name="diagnosis_name" value="{{ $diagnosis->diagnosis_name ?? '' }}" autocomplete="off" maxlength="255" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Description</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <textarea type="text" row="3" class="form-control" id="diagnosis_description" name="diagnosis_description" autocomplete="off" required>{{ $diagnosis->diagnosis_description ?? '' }}</textarea>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Treatment</h5>
            <button class="btn btn-light" id="btn-create" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create">
                <i class="bi bi-plus-lg h3"></i>
            </button>
        </div>
        
        <hr class="hr">

        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Treatment ID</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Type</th>
                    <th>Name</th>
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
        var medicalRecordId = '{{ $medicalrecordid ?? "" }}';

        var table;
        
        $('#btn-back').css('display', 'block');

        $('#btn-back').on('click', function() {
            window.location.href = '{{ url("/medicalrecord/details") }}/' + medicalRecordId;
        });

        var type = '{{ $type }}';

        if (type == 'create') {
             // Get Diagnosis ID
            $.ajax({
                url: '{{ route("getDiagnosisId") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.state == 'success') {
                        $('#diagnosis_id').val(response.diagnosisId);

                        initializeDataTable(); 
                    }
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                        
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        } else {
            initializeDataTable(); // Initialize the DataTable if not in 'create' mode
        }

        function initializeDataTable() {
            var diagnosisId = $('#diagnosis_id').val();
            
            // Treatment Line Datatable
            table = $('#admin-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('diagnosis.details', ['medicalrecordID' => ':medicalrecordID']) }}".replace(':medicalrecordID', medicalRecordId),
                    data: function (d) {
                        d.diagnosisId = diagnosisId;
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'treatment_id', name: 'treatment_id'},
                    {data: 'start_date', name: 'start_date'},
                    {data: 'end_date', name: 'end_date'},
                    {data: 'type', name: 'type'},
                    {data: 'treatment_name', name: 'treatment_name'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                autoWidth: false,
                columnDefs: [
                    { width: '5%', targets: 0 },
                    { width: '13%', targets: 1 },
                    { width: '12%', targets: 2 },
                    { width: '12%', targets: 3 },
                    { width: '10%', targets: 7 },
                ]
            });
        }
        
        $('#btn-create').click(function(e) {
            var diagnosisId = $('#diagnosis_id').val();
            
            // Check diagnosis header is created or not
            $.ajax({
                url: '{{ route("getDiagnosisCreatedStatus") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', diagnosisId: diagnosisId },
                success: function(response) {
                    if (response.state == 'success') {
                        if (response.createdStatus == true) {
                            window.location.href = '{{ url("medicalrecord") }}/' + medicalRecordId + '/diagnosis/' + diagnosisId + '/treatment/details';
                        } else {
                            Swal.fire('Error', 'Please create the header of diagnosis result first to proceed!', 'error');
                        }
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
            var diagnosisId = $('#diagnosis_id').val();

            window.location.href = '{{ url("medicalrecord") }}/' + medicalRecordId + '/diagnosis/' + diagnosisId + '/treatment/details/' + dataId;
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
                        url: '{{ url("/medicalrecord/treatment/delete") }}/' + dataId,
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

        $('#createForm').validate({
            rules: {
                diagnosis_id: {
                    required: true,
                    maxlength: 10
                },
                medical_record_id: {
                    required: true,
                    maxlength: 10
                },
                diagnosis_name: {
                    required: true,
                    maxlength: 255
                },
                diagnosis_description: {
                    required: true,
                },
            },
            errorPlacement: function(error, element) {
                error.appendTo(element.siblings('.invalid-feedback'));
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            },
            submitHandler: function(form) {
                var formData = {};

                $(form).find(':input').each(function() {
                    var field = $(this);
                    formData[field.attr('name')] = field.val();
                });

                var urls;

                if ($('#hidden_diagnosis_id').val() == '') {
                    urls = '{{ route("diagnosis.create") }}';
                }else{
                    urls = '{{ url("/medicalrecord/diagnosis/edit") }}/' + $('#hidden_diagnosis_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            var diagnosisID = $('#diagnosis_id').val();
                            
                            $('#hidden_diagnosis_id').val(diagnosisID);

                            Swal.fire('Success', message, 'success');

                        }else if (response.state == 'error') {
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
</script>
@endsection
</x-layout>