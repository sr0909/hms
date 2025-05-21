<x-layout title="Patient Management">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Patient Management</h5>
        </div>
        
        <hr class="hr">
        
        <form method="POST" id="createForm">
        @csrf
            <input type="hidden" id="hidden_patient_id" value="{{ $patient->patient_id ?? '' }}"/>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">ID</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="patient_id" name="patient_id" value="{{ $patient->patient_id ?? '' }}" autocomplete="off" maxlength="10" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Full Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ $patient->patient_name ?? '' }}" autocomplete="off" maxlength="150" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Identity Card (IC)</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="ic" name="ic" value="{{ $patient->ic ?? '' }}" autocomplete="off" maxlength="12" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Date of Birth</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="dob" name="dob" autocomplete="off" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Email</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $patient->email ?? '' }}" autocomplete="off" maxlength="255" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Phone Number</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $patient->phone ?? '' }}" autocomplete="off" maxlength="20" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Street</label>
                </div>
                <div class="col-sm-10">
                    <div class="input-group">
                        <input type="text" class="form-control" id="street" name="street" value="{{ $patient->street ?? '' }}" autocomplete="off" maxlength="255" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">City</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="city" name="city" value="{{ $patient->city ?? '' }}" autocomplete="off" maxlength="50" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Zip Code</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $patient->zip_code ?? '' }}" autocomplete="off" maxlength="5" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">State</label>
                </div>
                <div class="col-sm-4">
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
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Gender</label>
                </div>
                <div class="col-sm-4">
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
                <div class="col-sm-2 mt-2 pe-0">
                    <label class="fw-medium">Emergency Contact</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="{{ $patient->emergency_contact ?? '' }}" autocomplete="off" maxlength="20" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 pe-0">
                    <label class="fw-medium">Emergency Contact Relationship</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="emergency_contact_relationship" name="emergency_contact_relationship" value="{{ $patient->emergency_contact_relationship ?? '' }}" autocomplete="off" maxlength="30" required/>
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
        $('#btn-back').css('display', 'block');

        $('#btn-back').on('click', function() {
            window.location.href = '{{ route("patient") }}';
        });

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

        var type = '{{ $type }}';

        if (type == 'create') {
             // Get Patient ID
            $.ajax({
                url: '{{ route("getNewPatientId") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}' },
                success: function(response) {
                    if (response.state == 'success') {
                        $('#patient_id').val(response.patientId);
                    }
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                        
                    Swal.fire('Error', errorMessage, 'error');
                }
            });

        }else if (type == 'edit') {
            var dob = '{{ $patient->dob ?? "" }}';
            var formattedDob = dob.split('-').reverse().join('-');
            $('#dob').datepicker('value', formattedDob);

            $('#gender').val('{{ $patient->gender ?? "" }}');
            $('#state').val('{{ $patient->state ?? "" }}');
        }

        $('#createForm').validate({
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

                var urls;

                if ($('#hidden_patient_id').val() == '') {
                    urls = '{{ route("patient.create") }}';
                }else{
                    urls = '{{ url("/patient/edit") }}/' + $('#hidden_patient_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            Swal.fire('Success', message, 'success').then(() => {
                                window.location.href = '{{ route("patient") }}';
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