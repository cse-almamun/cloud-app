@extends('template.user-template')
@section('title', 'Cloud Storage')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-lg mt-5">
                <div class="card-header bg-primary">
                    <h3 class="text-center font-weight-light text-white my-2">Password Recovery</h3>
                </div>
                <div class="card-body">

                    <form action="{{ url('reset-password') }}" method="POST" id="reset_form">
                        @csrf
                        <input type="hidden" class="form-control" name="email" value="{{ request()->get('email') }}"
                            required readonly>
                        <input type="hidden" class="form-control" name="token" value="{{ $token }}" required
                            readonly>
                        <div class="form-floating mb-3">
                            <label for="inputNewPassword">New Password</label>
                            <input type="password" class="form-control" name="password" id="inputNewPassword"
                                placeholder="new password" required />
                        </div>
                        <div class="form-floating mb-3">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation" id="confirmPassword"
                                placeholder="retype your password" required />
                        </div>
                        <div class="small mb-3 text-muted">Enter your email address and we will send you a link
                            to reset your password.</div>
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <a class="small" href="{{ url('login') }}">Return to login</a>
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center py-3">
                    <div class="small"><a href="{{ url('registration') }}">Need an account? Sign up!</a></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScript')
    <script>
        $(document).ready(function() {
            $('#reset_form').validate({
                rules: {
                    password: {
                        required: true,
                        pwcheck: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#inputNewPassword"
                    },
                },
                message: {
                    password: {
                        required: "This is required",
                    },
                    password_confirmation: {
                        required: "This is required",
                        equalTo: "Password didn't match"
                    },
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.parent());
                }
            });

            //password check validation function
            $.validator.addMethod("pwcheck", function(value, element) {
                return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
                    &&
                    value.length > 8 &&
                    /[a-z]/.test(value) // has a lowercase letter
                    &&
                    /[A-Z]/.test(value) // has a uppercase letter
                    &&
                    /[=!\-._@#$%&]/.test(value) // has a special charter
                    &&
                    /\d/.test(value) //has a digit
            }, function(value, element) {
                let password = $(element).val();
                if (!(/^(.{8,20}$)/.test(password))) {
                    return 'Password must be between 8 to 20 characters long.';
                } else if (!(/^(?=.*[A-Z])/.test(password))) {
                    return 'Password must contain at least one uppercase.';
                } else if (!(/^(?=.*[a-z])/.test(password))) {
                    return 'Password must contain at least one lowercase.';
                } else if (!(/^(?=.*[0-9])/.test(password))) {
                    return 'Password must contain at least one digit.';
                } else if (!(/^(?=.*[-._!@#$%^&*])/.test(password))) {
                    return "Password must contain special characters from '-._!@#$%^&*'";
                }
                return false;
            });
        });
    </script>
@endsection
