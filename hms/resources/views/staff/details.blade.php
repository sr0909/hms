<x-layout title="Staff Management">
<div class="card border-light mt-2" style="width: 100%;">
    <div class="card-body pt-1">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Staff Management</h5>
        </div>
        
        <hr class="hr">
        
        <form method="POST" id="createForm">
        @csrf
            <input type="hidden" id="hidden_staff_id" value="{{ $staff->id ?? '' }}"/>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Role</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <select class="form-select" id="role" name="role">
                            <option value="" selected></option>
                            <option value="admin">Administrator</option>
                            <option value="doctor">Doctor</option>
                            <option value="pharmacist">Pharmacist</option>
                        </select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">ID</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="id" name="id" value="{{ $staff->id ?? '' }}" autocomplete="off" maxlength="10" required readonly disabled/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="doctorInfo" style="display: none;">
                <div class="row mb-2">
                    <div class="col-sm-2 mt-2">
                        <label class="fw-medium">Department</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <select class="form-select" id="dept_id" name="dept_id">
                                <option value="" selected></option>
                                @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                    <div class="col-sm-2 mt-2 pe-0">
                        <label class="fw-medium">Years of Experience</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="number" class="form-control" id="years_of_experience" name="years_of_experience" value="{{ $doctor->years_of_experience ?? '' }}" min="1" max="100" autocomplete="off" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Full Name</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $staff->name ?? '' }}" autocomplete="off" maxlength="150" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Email</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $staff->email ?? '' }}" autocomplete="off" maxlength="255" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
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
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Phone Number</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $staff->phone ?? '' }}" autocomplete="off" maxlength="20" required/>
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
                        <input type="text" class="form-control" id="street" name="street" value="{{ $staff->street ?? '' }}" autocomplete="off" maxlength="255" required/>
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
                        <input type="text" class="form-control" id="city" name="city" value="{{ $staff->city ?? '' }}" autocomplete="off" maxlength="50" required/>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Zip Code</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="zip_code" name="zip_code" value="{{ $staff->zip_code ?? '' }}" autocomplete="off" maxlength="5" required/>
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
                    <label class="fw-medium">Salary</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="salary" name="salary" value="{{ $staff->salary ?? '' }}" autocomplete="off" maxlength="11" />
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2">
                    <label class="fw-medium">Hired Date</label>
                </div>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="hired_date" name="hired_date" autocomplete="off" required/>
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
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
                <div class="col-sm-2 mt-2 terminatedDateContainer" style="display: none;">
                    <label class="fw-medium">Terminated Date</label>
                </div>
                <div class="col-sm-4 terminatedDateContainer" style="display: none;">
                    <div class="input-group">
                        <input type="text" class="form-control" id="terminated_date" name="terminated_date" autocomplete="off" />
                        <div class="invalid-feedback text-start"></div>
                    </div>
                </div>
            </div>

            <div id = 'accInfoContainer'>
                <h5 class="card-title" style="margin-top: 30px;">Account Info</h5>

                <hr class="hr">

                <div class="row mb-2">
                    <div class="col-sm-2 mt-2">
                        <label class="fw-medium">Username</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" class="form-control" id="username" name="username" autocomplete="off" maxlength="255" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                    <div class="col-sm-2 mt-2">
                        <label class="fw-medium">Password</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" autocomplete="off" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-2 mt-2">
                        <label class="fw-medium">Confirm Password</label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" autocomplete="off" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
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
            window.location.href = '{{ route("staffmanagement") }}';
        });

        $('#role').change(function() {
            var role = $(this).val();

            if (role == 'doctor') {
                $('.doctorInfo').css('display', 'block');
                $('#dept_id').attr('required', true);
                $('#years_of_experience').attr('required', true);
            }else{
                $('.doctorInfo').css('display', 'none');
                $('#dept_id').removeAttr('required');
                $('#years_of_experience').removeAttr('required');
            }

            $.ajax({
                url: '{{ route("getStaffId") }}',
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', role: role },
                success: function(response) {
                    if (response.state == 'success') {
                        $('#id').val(response.staffId);
                    }
                },
                error: function(response) {
                    var errorMessage = response.responseJSON.message;
                        
                    Swal.fire('Error', errorMessage, 'error');
                }
            });
        });

        $('#status').change(function() {
            var status = $(this).val();

            if (status == 'Inactive') {
                $('.terminatedDateContainer').css('display', 'block');
            }else{
                $('.terminatedDateContainer').css('display', 'none');
            }
        });

        // Function to format date as dd-mm-yyyy
        function formatDate(date) {
            var day = String(date.getDate()).padStart(2, '0');
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var year = date.getFullYear();
            return day + '-' + month + '-' + year;
        }

        // Get today's date
        var today = new Date();
        var formattedToday = formatDate(today);

        $('#dob').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy', 
            maxDate: new Date(),
        });

        $('#hired_date').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy', 
            value: formattedToday
        });

        $('#terminated_date').datepicker({
            uiLibrary: 'bootstrap5',
            format: 'dd-mm-yyyy', 
            value: formattedToday
        });

        $('#salary').on('keypress', function (e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            // Allow only numbers and a single dot
            if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                e.preventDefault();
            }
            // Ensure only one dot is allowed
            if (charCode == 46 && $(this).val().indexOf('.') != -1) {
                e.preventDefault();
            }
        });

        var type = '{{ $type }}';

        if (type == 'edit') {
            $('#accInfoContainer').css('display', 'none');

            var staffRole = '{{ $role }}';

            if ( staffRole == 'doctor') {
                $('.doctorInfo').css('display', 'block');
                $('#dept_id').attr('required', true);
                $('#years_of_experience').attr('required', true);

                $('#dept_id').val('{{ $doctor->dept_id ?? "" }}');
            }

            $('#role').attr('readonly', true);
            $('#role').attr('disabled', true);
            $('#role').val(staffRole);

            $('#email').attr('readonly', true);
            $('#email').attr('disabled', true);

            $('#gender').val('{{ $staff->gender ?? "" }}');
            $('#state').val('{{ $staff->state ?? "" }}');
            $('#status').val('{{ $staff->status ?? "" }}');

            var dob = '{{ $staff->dob ?? '' }}';
            var formattedDob = dob.split('-').reverse().join('-');
            $('#dob').datepicker('value', formattedDob);

            var hiredDate = '{{ $staff->hired_date ?? '' }}';
            var formattedHiredDate = hiredDate.split('-').reverse().join('-');
            $('#hired_date').datepicker('value', formattedHiredDate);

            var terminatedDate = '{{ $staff->terminated_date ?? '' }}';
            if (terminatedDate) {
                var formattedTerminatedDate = terminatedDate.split('-').reverse().join('-');
                $('#terminated_date').datepicker('value', formattedTerminatedDate);
            }
        }

        $('#createForm').validate({
            rules: {
                role: {
                    required: true,
                    maxlength: 50
                },
                id: {
                    required: true,
                    maxlength: 10
                },
                name: {
                    required: true,
                    maxlength: 150
                },
                email: {
                    required: true,
                    maxlength: 255
                },
                gender: {
                    required: true,
                    maxlength: 1
                },
                phone: {
                    required: true,
                    maxlength: 20
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
                dob: {
                    required: true,
                },
                hired_date: {
                    required: true,
                },
                salary: {
                    maxlength: 11
                },
                status: {
                    required: true,
                    maxlength: 30
                },
                username: {
                    required: function(element) {
                        return type == 'create';
                    },
                    maxlength: 255
                },
                password: {
                    required: function(element) {
                        return type == 'create';
                    },
                },
                confirm_password: {
                    required: function(element) {
                        return type == 'create';
                    },
                },
                dept_id: {
                    required: function(element) {
                        return $('#role').val() == 'doctor';
                    },
                    maxlength: 7
                },
                years_of_experience: {
                    required: function(element) {
                        return $('#role').val() == 'doctor';
                    },
                    maxlength: 3,
                    min: 1,
                    max: 100
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

                if ($('#hidden_staff_id').val() == '') {
                    urls = '{{ route("staffmanagement.create") }}';
                }else{
                    urls = '{{ url("/staffmanagement/edit") }}/' + $('#hidden_staff_id').val();
                }

                $.ajax({
                    url: urls,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        var message = response.message;
                        
                        if (response.state == 'success') {
                            Swal.fire('Success', message, 'success').then(() => {
                                window.location.href = '{{ route("staffmanagement") }}';
                            });

                            // $(form)[0].reset();
                            // $('.is-invalid').removeClass('is-invalid');

                            // $('#hidden_staff_id').val('');

                            // $('.doctorInfo').css('display', 'none');

                            // window.location.reload();
                            // window.location.href = '{{ route("staffmanagement") }}';

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