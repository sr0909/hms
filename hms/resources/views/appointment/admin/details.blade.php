<x-layout title="Appointment">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Appointment Scheduling</h5>
        </div>
        
        <hr class="hr">

        <form method="POST" id="createForm">
        @csrf
            <input type="hidden" id="hidden_appointment_id" value="{{ $appointment->id ?? '' }}"/>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Date</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="app_date" name="app_date" autocomplete="off" required/>
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
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Doctor Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="doctor_name" name="doctor_name" value="{{ $doctor_name ?? '' }}" autocomplete="off" maxlength="150" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Duration</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="duration" name="duration">
                            <option value="" selected></option>
                            <option value="1">1 hour</option>
                            <option value="2">2 hours</option>
                            <option value="3">3 hours</option>
                            <option value="4">4 hours</option>
                        </select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Department</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="dept_id" name="dept_id" readonly disabled>
                            <option value="" selected></option>
                            @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Type</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="type" name="type">
                            <option value="" selected></option>
                            <option value="Check Up">Check Up</option>
                            <option value="Consultation">Consultation</option>
                        </select>
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
                        <input type="text" class="form-control" id="patient_id" name="patient_id" value="" autocomplete="off" maxlength="10" required readonly disabled/>
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
                        <input type="text" class="form-control" id="edit_patient_name" name="patient_name" value="" autocomplete="off" maxlength="150" required readonly disabled/>
                        @endif
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Status</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="status" name="status">
                            <option value="Scheduled" selected>Scheduled</option>
                            <option value="Completed">Completed</option>
                            <option value="Incompleted">Incompleted</option>
                            <option value="Cancelled">Cancelled</option>
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
                        <textarea type="text" row="3" class="form-control" id="notes" name="notes" value="" autocomplete="off"></textarea>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2 mt-3">
                <div class="col text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@section('js_content')
<script type="text/javascript">
    $(document).ready(function() {
        var type = '{{ $type }}';

        $('#btn-back').css('display', 'block');

        $('#btn-back').on('click', function() {
            window.location.href = '{{ route("appointment") }}';
        });

        $('#app_date').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy', 
            minDate: new Date()
        });

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

        $('#dept_id').val('{{ $dept_id ?? "" }}');

        if (type == 'edit') {
            var app_date = '{{ $appointment->app_date ?? '' }}';
            var formattedAppDate = app_date.split('-').reverse().join('-');
            $('#app_date').datepicker('value', formattedAppDate);

            $('#app_start_time_id').val('{{ $appointment->app_start_time_id ?? "" }}');
            $('#duration').val('{{ $appointment->duration ?? "" }}');
            $('#dept_id').val('{{ $appointment->dept_id ?? "" }}');
            $('#type').val('{{ $appointment->type ?? "" }}');
            $('#patient_id').val('{{ $appointment->patient_id ?? "" }}');
            $('#edit_patient_name').val('{{ $patient_name ?? "" }}');
            $('#status').val('{{ $appointment->status ?? "" }}');
            $('#notes').val('{{ $appointment->notes ?? "" }}');
        }

        $('#createForm').validate({
            rules: {
                app_date: {
                    required: true,
                },
                app_start_time_id: {
                    required: true,
                },
                doctor_name: {
                    required: true,
                    maxlength: 150
                },
                duration: {
                    required: true,
                    maxlength: 50
                },
                dept_id: {
                    required: true,
                },
                type: {
                    required: true,
                    maxlength: 50
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

                formData['doctor_id'] = '{{ $doctor_id ?? "" }}';

                var urls;

                if ($('#hidden_appointment_id').val() == '') {
                    urls = '{{ route("appointment.create") }}';
                }else{
                    urls = '{{ url("/appointment/edit") }}/' + $('#hidden_appointment_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            Swal.fire('Success', message, 'success').then(() => {
                                window.location.href = '{{ route("appointment") }}';
                            });
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