<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>HMS</title>

        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"/>

        <!--Bootstrap CSS-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!--End of Bootstrap CSS-->
    </head>
    <body>
        <div class="container-fluid text-center min-vh-100 d-flex align-items-center justify-content-center">
            <div class="row">
                <div class="col-sm-6 px-5 d-flex flex-column align-items-center justify-content-center">
                    <form method="POST" id="loginForm" class="w-100">
                    @csrf
                    <div class="row mb-2">
                        <img src="{{ asset('images/logo-white-1.png') }}" alt="HMS Logo">
                    </div>
                    <div class="row mb-2">
                        <div class="input-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Username" autocomplete="off" required/>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required/>
                            <span class="input-group-text">
                                <i class="bi bi-eye-slash-fill" id="togglePassword" style="cursor: pointer;"></i>
                            </span>
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <a href="#" id="showSignUpModal" class="float-start" style="font-size: 13px;">Don't have an account?</a>
                        </div>
                        <div class="col-sm-6">
                            <a href="#" id="showForgetPassModal" class="float-end" style="font-size: 13px;">Forget Password?</a>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="d-grid gap-2">
                            <input type="submit" class="btn btn-primary" value="Login" />
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-sm-6 min-vh-100 px-0">
                    <img src="{{ asset('images/background.png') }}" class="img-fluid" style="height: 100%;" alt="HMS">
                </div>
            </div>
        </div>

        <div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signUpModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" id="signUpForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold" id="signUpModalLabel">Sign Up</h1>
                        <button type="button" class="btn-close close-button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 mt-2">
                                <label class="fw-medium">Email</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="email" name="email" autocomplete="off" required/>
                                    <div class="invalid-feedback text-start"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 mt-2">
                                <label class="fw-medium">Username</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="signup_name" name="name" autocomplete="off" required/>
                                    <div class="invalid-feedback text-start"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-4 mt-2">
                                <label class="fw-medium">Password</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="password" class="form-control" id="signup_password" name="password" autocomplete="off" required/>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light close-button" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Sign Up</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="forgetPassModal" tabindex="-1" aria-labelledby="forgetPassModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" id="forgetPassForm">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold" id="forgetPassModalLabel">Forget Password</h1>
                        <button type="button" class="btn-close forgetPass-close-button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-sm-4 mt-2">
                                <label class="fw-medium">Email</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="forgetpass_email" name="email" autocomplete="off" required/>
                                    <div class="invalid-feedback text-start"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light forgetPass-close-button" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Reset Password Link</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $('#togglePassword').on('click', function() {
                    var passwordField = $('#password');
                    var type = (passwordField.attr('type') === 'password') ? 'text' : 'password';
                    passwordField.attr('type', type);

                    $(this).toggleClass('bi-eye-slash-fill bi-eye-fill');
                });

                $('.close-button').on('click', function() {
                    $('#signUpForm')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                });

                $('.forgetPass-close-button').on('click', function() {
                    $('#forgetPassForm')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                });

                $('#showSignUpModal').click(function(e) {
                    e.preventDefault();

                    $('#signUpModal').modal('show');
                });

                $('#showForgetPassModal').click(function(e) {
                    e.preventDefault();

                    $('#forgetPassModal').modal('show');
                });

                // Sign Up Form
                $('#signUpForm').validate({
                    rules: {
                        email: {
                            required: true
                        },
                        name: {
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
                            url: '{{ route("signup") }}',
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                var message = response.message;
                                
                                if (response.state == 'success') {
                                    Swal.fire('Success', message, 'success');

                                    $(form)[0].reset();
                                    $('.is-invalid').removeClass('is-invalid');

                                    $('#signUpModal').modal('hide');

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

                // Forget Password
                $('#forgetPassForm').validate({
                    rules: {
                        email: {
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
                            url: '{{ route("forgetpassword") }}',
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                var message = response.message;
                                
                                if (response.state == 'success') {
                                    Swal.fire('Success', message, 'success');

                                    $(form)[0].reset();
                                    $('.is-invalid').removeClass('is-invalid');

                                    $('#forgetPassModal').modal('hide');

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

                // Login
                $('#loginForm').validate({
                    // Define validation rules
                    rules: {
                        name: {
                            required: true
                        },
                        password: {
                            required: true
                        }
                    },
                    // Define where to place error message
                    errorPlacement: function(error, element) {
                        error.appendTo(element.siblings('.invalid-feedback'));
                    },
                    // Define how to highlight invalid fields
                    highlight: function(element) {
                        $(element).addClass('is-invalid');
                    },
                    // Define how to unhighlight valid fields
                    unhighlight: function(element) {
                        $(element).removeClass('is-invalid');
                    },
                    // Define submit handler
                    submitHandler: function(form) {
                        var formData = {};

                        // Collect the form data
                        $(form).find(':input').each(function() {
                            var field = $(this);
                            formData[field.attr('name')] = field.val();
                        });

                        // Ajax request for login
                        $.ajax({
                            url: '{{ route("login") }}',
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                if (response.state == 'success') {
                                    // Redirect to the URL specified in the response
                                    window.location.href = response.redirect; 
                                }
                            },
                            error: function(response) {
                                var errorMessage = response.responseJSON.message;
                                
                                // Display error message using sweet alert
                                Swal.fire('Error', errorMessage, 'error');
                            }
                        });
                    }
                });
            });
        </script>
    </body>
</html>