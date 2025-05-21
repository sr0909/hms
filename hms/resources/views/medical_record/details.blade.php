<x-layout title="Medical Record">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Medical Record</h5>
        </div>
        
        <hr class="hr">
        
        <form method="POST" id="createForm">
        @csrf
            <input type="hidden" id="hidden_medical_record_id" value="{{ $medicalrecord->medical_record_id ?? '' }}"/>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">ID</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="medical_record_id" name="medical_record_id" value="{{ $medicalrecord->medical_record_id ?? '' }}" autocomplete="off" maxlength="10" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Created Date</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="medical_record_date" name="medical_record_date" value="" autocomplete="off" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Patient ID</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="patient_id" name="patient_id" value="{{ $medicalrecord->patient_id ?? '' }}" autocomplete="off" maxlength="10" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Patient Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        @if ($type == 'create')
                        <select class="form-select" id="patient_name" name="patient_name" autocomplete="off"></select>
                        @elseif ($type == 'edit')
                        <input type="text" class="form-control" id="edit_patient_name" name="patient_name" value="{{ $patientname ?? '' }}" autocomplete="off" maxlength="150" required readonly disabled/>
                        @endif
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Created By</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="doctor_name" name="doctor_name" value="{{ $doctorname ?? '' }}" autocomplete="off" maxlength="150" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Status</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="status" name="status">
                            <option value="Open" selected>Open</option>
                            <option value="Closed">Closed</option>
                        </select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Notes</label>
                </div>
                <div class="col-sm-10">
                    <div class="input-group">
                        <textarea type="text" row="3" class="form-control" id="notes" name="notes" autocomplete="off">{{ $medicalrecord->notes ?? '' }}</textarea>
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
            <h5 class="card-title">Diagnosis Result</h5>
            <button class="btn btn-light" id="btn-create" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create">
                <i class="bi bi-plus-lg h3"></i>
            </button>
        </div>
        
        <hr class="hr">

        <table class="table my-3" id="admin-data">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Diagnosis ID</th>
                    <th>Name</th>
                    <th>Description</th>
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
        var table;

        $('#btn-back').css('display', 'block');

        $('#btn-back').on('click', function() {
            window.location.href = '{{ route("medicalrecord") }}';
        });

        var type = '{{ $type }}';

        if (type == 'create') {
             // Get Medical Record ID
            $.ajax({
                url: '{{ route("getMedicalRecordId") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.state == 'success') {
                        $('#medical_record_id').val(response.medicalRecordId);

                        initializeDataTable(); 
                    }
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                        
                    Swal.fire('Error', errorMessage, 'error');
                }
            });

            // Get today's date
            var today = new Date();

            // Format the date as dd-mm-YYYY
            var formattedDate = ('0' + today.getDate()).slice(-2) + '-' +
                                ('0' + (today.getMonth() + 1)).slice(-2) + '-' +
                                today.getFullYear();

            // Set the value of the input field Created Date
            $('#medical_record_date').val(formattedDate);

        } else if (type == 'edit') {
            var medical_record_date = '{{ $medicalrecord->medical_record_date ?? '' }}';
            var formattedMRDate = medical_record_date.split('-').reverse().join('-');
            $('#medical_record_date').val(formattedMRDate);

            $('#status').val('{{ $medicalrecord->status ?? "" }}');

            initializeDataTable(); 
        }

        $('#patient_name').select2({
            placeholder: "Select a patient",
            minimumInputLength: 1,
            ajax: {
                url: '{{ route("getPatientNameList") }}',
                type: 'POST',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term, // Search term
                        _token: '{{ csrf_token() }}'
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id: item.patient_id,
                                text: item.patient_name
                            };
                        })
                    };
                },
                cache: true
            }
        });

        $('#patient_name').on('select2:select', function (e) {
            var data = e.params.data;
            $('#patient_id').val(data.id);
        });

        function initializeDataTable() {
            var medicalRecordId = $('#medical_record_id').val();

            // Diagnosis Line Datatable
            table = $('#admin-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('medicalrecord.details') }}",
                    data: function (d) {
                        d.medicalRecordId = medicalRecordId;
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name:'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'diagnosis_id', name: 'diagnosis_id'},
                    {data: 'diagnosis_name', name: 'diagnosis_name'},
                    {data: 'diagnosis_description', name: 'diagnosis_description'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                autoWidth: false,
                columnDefs: [
                    { width: '5%', targets: 0 },
                    { width: '13%', targets: 1 },
                    { width: '10%', targets: 4 },
                ]
            });
        }

        $('#btn-create').click(function(e) {
            var medicalRecordId = $('#medical_record_id').val();

            // Check medical record header is created or not
            $.ajax({
                url: '{{ route("getMRCreatedStatus") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', medicalRecordId: medicalRecordId },
                success: function(response) {
                    if (response.state == 'success') {
                        if (response.createdStatus == true) {
                            window.location.href = '{{ url("medicalrecord") }}/' + medicalRecordId + '/diagnosis/details';
                        } else {
                            Swal.fire('Error', 'Please create the header of medical record first to proceed!', 'error');
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
            var medicalRecordId = $('#medical_record_id').val();

            window.location.href = '{{ url("medicalrecord") }}/' + medicalRecordId + '/diagnosis/details/' + dataId;
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
                        url: '{{ url("/medicalrecord/diagnosis/delete") }}/' + dataId,
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
                medical_record_id: {
                    required: true,
                    maxlength: 10
                },
                medical_record_date: {
                    required: true
                },
                patient_id: {
                    required: true,
                    maxlength: 10
                },
                patient_name: {
                    required: true,
                    maxlength: 150
                },
                status: {
                    required: true,
                    maxlength: 30
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

                if ($('#hidden_medical_record_id').val() == '') {
                    urls = '{{ route("medicalrecord.create") }}';
                }else{
                    urls = '{{ url("/medicalrecord/edit") }}/' + $('#hidden_medical_record_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            var MRID = $('#medical_record_id').val();

                            $('#hidden_medical_record_id').val(MRID);

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