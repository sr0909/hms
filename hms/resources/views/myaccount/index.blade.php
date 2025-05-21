<x-layout title="My Account">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">My Account</h5>
        </div>
        
        <hr class="hr">
        
        <form method="POST" id="createForm">
        @csrf
            @if (Auth::user()->hasRole('normal user'))
                <input type="hidden" id="hidden_patient_id" value="{{ $loginuser->patient_id ?? '' }}"/>
            @else
                <input type="hidden" id="hidden_staff_id" value="{{ $loginuser->id ?? '' }}"/>
            @endif
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Full Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        @if (Auth::user()->hasRole('normal user'))
                            <input type="text" class="form-control" id="patient_name" name="patient_name" value="{{ $loginuser->patient_name ?? '' }}" autocomplete="off" maxlength="150" required/>
                        @else
                            <input type="text" class="form-control" id="name" name="name" value="{{ $loginuser->name ?? '' }}" autocomplete="off" maxlength="150" required/>
                        @endif
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
            @if (Auth::user()->hasRole('normal user'))
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Identity Card (IC)</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="ic" name="ic" value="{{ $loginuser->ic ?? '' }}" autocomplete="off" maxlength="12" required/>
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
            @endif
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Email</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $loginuser->email ?? '' }}" autocomplete="off" maxlength="255" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Phone Number</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $loginuser->phone ?? '' }}" autocomplete="off" maxlength="20" required/>
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
                        <input type="text" class="form-control" id="street" name="street" value="{{ $loginuser->street ?? '' }}" autocomplete="off" maxlength="255" required/>
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
                        <input type="text" class="form-control" id="city" name="city" value="{{ $loginuser->city ?? '' }}" autocomplete="off" maxlength="50" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Zip Code</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $loginuser->zip_code ?? '' }}" autocomplete="off" maxlength="5" required/>
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
                @if (Auth::user()->hasRole('normal user'))
                    <div class="col-sm-2 mt-2 pe-0">
                        <label class="fw-medium">Emergency Contact</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" value="{{ $loginuser->emergency_contact ?? '' }}" autocomplete="off" maxlength="20" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                @else
                    <div class="col-sm-2 mt-2">
                        <label class="fw-medium">Date of Birth</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="staff_dob" name="dob" autocomplete="off" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                @endif
            </div>
            @if (Auth::user()->hasRole('normal user'))
            <div class="row mb-2">
                <div class="col-sm-2 pe-0">
                    <label class="fw-medium">Emergency Contact Relationship</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="emergency_contact_relationship" name="emergency_contact_relationship" value="{{ $loginuser->emergency_contact_relationship ?? '' }}" autocomplete="off" maxlength="30" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row mb-2 mt-3">
                <div class="col text-end">
                    <button class="btn btn-light" id="btn-changepass" type="button">Change Password</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="changePassForm">
            @csrf
            <div class="modal-header">
                <h1 class="modal-title fs-5 fw-bold" id="createModalLabel">Change Password</h1>
                <button type="button" class="btn-close close-button" data-bs-dismiss="modal" aria-label="Close"></button>
                <input type="hidden" id="hidden_changePassForm_patient_id" value="{{ $loginuser->patient_id ?? '' }}"/>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Old Password</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="password" class="form-control" id="old_password" name="old_password" autocomplete="off" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">New Password</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" autocomplete="off" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4 mt-2">
                        <label class="fw-medium">Confirm Password</label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="off" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light close-button" data-bs-dismiss="modal">Close</button>
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
        var role = '{{ $role }}';

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

        $('#staff_dob').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy', 
            maxDate: new Date(),
        });

        var dob = '{{ $loginuser->dob ?? "" }}';
        var formattedDob = dob.split('-').reverse().join('-');
        @if (Auth::user()->hasRole('normal user'))
            $('#dob').datepicker('value', formattedDob);
        @else
            $('#staff_dob').datepicker('value', formattedDob);
        @endif

        $('#gender').val('{{ $loginuser->gender ?? "" }}');
        $('#state').val('{{ $loginuser->state ?? "" }}');

        $('.close-button').on('click', function() {
            $('#changePassForm')[0].reset();
            $('.is-invalid').removeClass('is-invalid');

            // $('#hidden_dept_id').val('');
        });

        $('#btn-changepass').click(function(e) {
            e.preventDefault();

            $('#createModal').modal('show');
        });

        $('#changePassForm').validate({
            rules: {
                old_password: {
                    required: true
                },
                password: {
                    required: true
                },
                confirm_password: {
                    required: true
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
                    url: '{{ route("changePass") }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            Swal.fire('Success', message, 'success');

                            $(form)[0].reset();
                            $('.is-invalid').removeClass('is-invalid');

                            $('#createModal').modal('hide');

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

        $('#createForm').validate({
            rules: {
                patient_name: {
                    required: function(element) {
                        return role == 'patient';
                    },
                    maxlength: 150
                },
                name: {
                    required: function(element) {
                        return role == 'staff';
                    },
                    maxlength: 150
                },
                ic: {
                    required: function(element) {
                        return role == 'patient';
                    },
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
                    required: function(element) {
                        return role == 'patient';
                    },
                    maxlength: 20
                },
                emergency_contact_relationship: {
                    required: function(element) {
                        return role == 'patient';
                    },
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

                if (role == 'patient') {
                    urls = '{{ url("/myaccount/edit") }}/' + $('#hidden_patient_id').val();
                } else {
                    urls = '{{ url("/staff/myaccount/edit") }}/' + $('#hidden_staff_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
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