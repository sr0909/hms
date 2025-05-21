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
                        <input type="text" class="form-control" id="patient_name" name="patient_name" value="" autocomplete="off" maxlength="150" required readonly disabled/>
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

<div class="modal fade" id="registerPatientModal" tabindex="-1" aria-labelledby="registerPatientModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="registerPatientForm">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="registerPatientModalLabel">Register As Patient</h1>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Patient ID</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="registerModal_patient_id" name="patient_id" autocomplete="off" maxlength="10" required readonly disabled/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Patient Name</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="registerModal_patient_name" name="patient_name" autocomplete="off" maxlength="150" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">IC</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="ic" name="ic" autocomplete="off" maxlength="12" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Gender</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <select class="form-select" id="gender" name="gender">
                                <option value="" selected></option>    
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Email</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" autocomplete="off" maxlength="255" required readonly disabled/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Phone Number</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="phone" name="phone" autocomplete="off" maxlength="20" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Date of Birth</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="dob" name="dob" autocomplete="off" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Street</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="street" name="street" autocomplete="off" maxlength="255" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">City</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="city" name="city" autocomplete="off" maxlength="50" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Zip Code</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="zip_code" name="zip_code" autocomplete="off" maxlength="5" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">State</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <select class="form-select" id="state" name="state">
                                <option value="" selected></option>
                                <optgroup label="States">
                                    <option value="Johor">Johor</option>
                                    <option value="Kedah">Kedah</option>
                                    <option value="Kelantan">Kelantan</option>
                                    <option value="Malacca">Malacca</option>
                                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                                    <option value="Pahang">Pahang</option>
                                    <option value="Penang">Penang</option>
                                    <option value="Perak">Perak</option>
                                    <option value="Perlis">Perlis</option>
                                    <option value="Sabah">Sabah</option>
                                    <option value="Sarawak">Sarawak</option>
                                    <option value="Selangor">Selangor</option>
                                    <option value="Terengganu">Terengganu</option>
                                </optgroup>
                                <optgroup label="Federal Territories">
                                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                                    <option value="Labuan">Labuan</option>
                                    <option value="Putrajaya">Putrajaya</option>
                                </optgroup>
                            </select>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2 pe-0">
                        <label class="fw-medium">Emergency Contact</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" autocomplete="off" maxlength="20" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 pe-0">
                        <label class="fw-medium">Emergency Contact Relationship</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control" id="emergency_contact_relationship" name="emergency_contact_relationship" autocomplete="off" maxlength="30" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-light close-button" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

@section('js_content')
<script type="text/javascript">
    $(document).ready(function() {
        var type = '{{ $type }}';

        $('#btn-back').css('display', 'block');

        $('#btn-back').on('click', function() {
            if (type == 'create') {
                window.location.href = '{{ route("appointment.search") }}';
            }else{
                window.location.href = '{{ route("appointment") }}';
            }
        });

        var patientIsRegistered = '{{ $patientIsRegistered }}';

        // Get Patient ID
        $.ajax({
            url: '{{ route("getPatientId") }}',
            type: 'POST',
            data: { _token: '{{ csrf_token() }}', patientIsRegistered: patientIsRegistered },
            success: function(response) {
                if (response.state == 'success') {
                    if (patientIsRegistered == true) {
                        $('#patient_id').val(response.patientId);
                        $('#patient_name').val(response.patientName);
                    }else{
                        $('#registerModal_patient_id').val(response.patientId);
                    }
                }
            },
            error: function(response) {
                var errorMessage = response.responseJSON.message;
                    
                Swal.fire('Error', errorMessage, 'error');
            }
        });

        // Show registerPatientModal if the user is not registered as patient yet
        if (patientIsRegistered == false) {
            $('#registerPatientModal').modal('show');
        }

        $('#ic').on('keypress', function (e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            // Allow only numbers
            if (charCode < 48 || charCode > 57) {
                e.preventDefault();
            }
        });

        $('#dob').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy', 
            maxDate: new Date(),
        });

        $('#app_date').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy', 
            minDate: new Date()
        });

        $('#app_date').datepicker('value', '{{ $app_date ?? '' }}');
        $('#app_start_time_id').val('{{ $app_start_time_id ?? "" }}');
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
            $('#patient_name').val('{{ $patient_name ?? "" }}');
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
                console.log(formData);

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

        $('#registerPatientForm').validate({
            rules: {
                patient_id: {
                    required: true,
                    maxlength: 10
                },
                patient_name: {
                    required: true,
                    maxlength: 150
                },
                ic: {
                    required: true,
                    maxlength: 12
                },
                gender: {
                    required: true,
                    maxlength: 1
                },
                email: {
                    required: true,
                    maxlength: 255
                },
                phone: {
                    required: true,
                    maxlength: 20
                },
                dob: {
                    required: true,
                },
                street: {
                    required: true,
                    maxlength: 255
                },
                city: {
                    required: true,
                    maxlength: 50
                },
                zip_code: {
                    required: true,
                    maxlength: 5
                },
                state: {
                    required: true,
                    maxlength: 50
                },
                emergency_contact: {
                    required: true,
                    maxlength: 20
                },
                emergency_contact_relationship: {
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

                $.ajax({
                    url: '{{ route("patient.create") }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            Swal.fire('Success', message, 'success');

                            $(form)[0].reset();
                            $('.is-invalid').removeClass('is-invalid');

                            $('#registerPatientModal').modal('hide');

                            // table.ajax.reload();
                            window.location.reload();

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