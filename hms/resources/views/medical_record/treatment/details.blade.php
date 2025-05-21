<x-layout title="Medical Record">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Treatment</h5>
        </div>
        
        <hr class="hr">
        
        <form method="POST" id="createForm">
        @csrf
            <input type="hidden" id="hidden_treatment_id" value="{{ $treatment->treatment_id ?? '' }}"/>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Treatment ID</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="treatment_id" name="treatment_id" value="{{ $treatment->treatment_id ?? '' }}" autocomplete="off" maxlength="10" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Diagnosis ID</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="diagnosis_id" name="diagnosis_id" value="{{ $diagnosisid ?? '' }}" autocomplete="off" maxlength="10" required readonly disabled/>
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
                        <input type="text" class="form-control" id="start_date" name="start_date" autocomplete="off" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">End Date</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="end_date" name="end_date" autocomplete="off"/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Type</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="type_id" name="type_id">
                            <option value="" selected></option>
                            @foreach ($treatmentTypes as $treatmentType)
                            <option value="{{ $treatmentType->id }}">{{ $treatmentType->type }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Status</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="status" name="status">
                            <option value="Scheduled" selected>Scheduled</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Pending">Pending</option>
                            <option value="Approved" disabled>Approved</option>
                            <option value="Rejected" disabled>Rejected</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Treatment Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="treatment_name" name="treatment_name" value="{{ $treatment->treatment_name ?? '' }}" autocomplete="off" maxlength="255" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Description</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <textarea type="text" row="3" class="form-control" id="treatment_description" name="treatment_description" autocomplete="off" required>{{ $treatment->treatment_description ?? '' }}</textarea>
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

<div class="card border-light mt-2" id="prescriptionContainer" style="width: 100%; display: none;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Prescription</h5>
            <button class="btn btn-light" id="btn-create" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Create">
                <i class="bi bi-plus-lg h3"></i>
            </button>
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
    </div>
</div>

@section('js_content')
<script type="text/javascript">
    $(document).ready(function() {
        var medicalRecordId = '{{ $medicalrecordid ?? "" }}';
        var diagnosisId = '{{ $diagnosisid ?? "" }}';
        
        var table;
        
        $('#btn-back').css('display', 'block');

        $('#btn-back').on('click', function() {
            window.location.href = '{{ url("medicalrecord") }}/' + medicalRecordId + '/diagnosis/details/' + diagnosisId;
        });

        $('#start_date').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy',
            minDate: new Date(new Date().setHours(0, 0, 0, 0))
        }).on('change', function (e) {
            var startDate = $('#start_date').datepicker().value();
            $('#end_date').datepicker().destroy();
            $('#end_date').datepicker({
                uiLibrary: 'bootstrap5',
                format: 'dd-mm-yyyy',
                minDate: startDate
            });
        });

        $('#end_date').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy',
            minDate: new Date(new Date().setHours(0, 0, 0, 0))
        });

        $('#type_id').on('change', function() {
            var treatmentTypeId = $(this).val();

            if (treatmentTypeId == 1) {
                $('#prescriptionContainer').css('display', 'block');
            } else {
                $('#prescriptionContainer').css('display', 'none');
            }
        });

        var type = '{{ $type }}';

        if (type == 'create') {
             // Get Treatment ID
            $.ajax({
                url: '{{ route("getTreatmentId") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.state == 'success') {
                        $('#treatment_id').val(response.treatmentId);

                        initializeDataTable();
                    }
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                        
                    Swal.fire('Error', errorMessage, 'error');
                }
            });

        }else if (type == 'edit') {
            var start_date = '{{ $treatment->start_date ?? "" }}';
            var formattedStartDate = start_date.split('-').reverse().join('-');
            $('#start_date').val(formattedStartDate);

            var end_date = '{{ $treatment->end_date ?? "" }}';
            if (end_date) {
                var formattedEndDate = end_date.split('-').reverse().join('-');
                $('#end_date').datepicker('value', formattedEndDate);
            }

            $('#type_id').val('{{ $treatment->type_id ?? "" }}');
            $('#status').val('{{ $treatment->status ?? "" }}');
            // $('#status').val('{{ $treatment->status ?? "" }}').trigger('change'); 

            var treatmentTypeId = $('#type_id').val();

            if (treatmentTypeId == 1) {
                $('#prescriptionContainer').css('display', 'block');

                initializeDataTable();
            } else {
                $('#prescriptionContainer').css('display', 'none');
            }
        }

        function initializeDataTable() {
            var treatmentId = $('#treatment_id').val();

            // Prescription Line Datatable
            table = $('#admin-data').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url("medicalrecord") }}/' + medicalRecordId + '/diagnosis/' + diagnosisId + '/treatment/details',
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
        }

        $('#btn-create').click(function(e) {
            var treatmentId = $('#treatment_id').val();
            
            // Check treatment header is created or not
            $.ajax({
                url: '{{ route("getTreatmentCreatedStatus") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', treatmentId: treatmentId },
                success: function(response) {
                    if (response.state == 'success') {
                        if (response.createdStatus == true) {
                            window.location.href = '{{ url("medicalrecord") }}/' + medicalRecordId + '/diagnosis/' + diagnosisId + '/treatment/' + treatmentId + '/prescription/details';

                        } else {
                            Swal.fire('Error', 'Please create the header of treatment first to proceed!', 'error');
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
            var treatmentId = $('#treatment_id').val();

            window.location.href = '{{ url("medicalrecord") }}/' + medicalRecordId + '/diagnosis/' + diagnosisId + '/treatment/' + treatmentId + '/prescription/details/' + dataId;
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
                        url: '{{ url("/medicalrecord/prescription/delete") }}/' + dataId,
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
                treatment_id: {
                    required: true,
                    maxlength: 10
                },
                diagnosis_id: {
                    required: true,
                    maxlength: 10
                },
                start_date: {
                    required: true,
                },
                type_id: {
                    required: true,
                },
                status: {
                    required: true,
                    maxlength: 30
                },
                treatment_name: {
                    required: true,
                    maxlength: 255
                },
                treatment_description: {
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

                if ($('#hidden_treatment_id').val() == '') {
                    urls = '{{ route("treatment.create") }}';
                }else{
                    urls = '{{ url("/medicalrecord/treatment/edit") }}/' + $('#hidden_treatment_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            var treatmentID = $('#treatment_id').val();
                            
                            $('#hidden_treatment_id').val(treatmentID);

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