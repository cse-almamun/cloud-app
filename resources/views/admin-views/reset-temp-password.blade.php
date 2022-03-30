<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Reset Admin Temporary Password</title>
    <link href="{{ asset('user-dash/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('admin-dash/css/custom-style.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" />
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script> --}}
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">

                                <div class="card-header">
                                    <h3 class="text-center font-weight-light">Reset Temp Password</h3>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.reset.temp-password.submit') }}" method='post'
                                        id="admin-password-reset">
                                        @csrf
                                        <div class="mb-2">
                                            <label for="inputEmail">Email</label>
                                            <input class="form-control" id="inputEmail" type="email" name="email"
                                                value="{{ old('email') }}" placeholder="example@mail.com" required />
                                            @error('email')
                                                <small class="form-text text-danger">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                        <div class="mb-2">
                                            <label for="inputTempPass">Temporary Password</label>
                                            <input class="form-control" id="inputTempPass" type="password"
                                                name="temp_password" value="{{ old('temp_password') }}"
                                                placeholder="Your temporary password" required />
                                            @error('temp_password')
                                                <small class="form-text text-danger">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col">
                                                <div class="mb-2">
                                                    <label for="inputNewPassword">Password</label>
                                                    <input class="form-control" id="inputNewPassword" type="password"
                                                        name="password" placeholder="New Password" required />
                                                    @error('password')
                                                        <small class="form-text text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="mb-2">
                                                    <label for="inputConfirmPassword">Confirm Password</label>
                                                    <input class="form-control" id="inputConfirmPassword"
                                                        type="password" name="password_confirmation"
                                                        placeholder="Re-type new password" required />
                                                    @error('password_confirmation')
                                                        <small class="form-text text-danger">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                        <div class="mb-2">
                                            <label for="emojiPassword">Choose your Emoji Password</label>
                                            <input data-emoji-picker="true" class="form-control" id="emojiPassword"
                                                type="text" name="emoji_password" placeholder="Choose emoji password"
                                                required />
                                            @error('emoji_password')
                                                <small class="form-text text-danger">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center mt-4 mb-0">
                                            <button type="submit" class="btn btn-primary">Reset Password</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2021</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="{{ asset('user-dash/js/scripts.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    {{-- Emoji Picker JS --}}
    <script src="{{ asset('js/emojiPicker.js') }}"></script>
    {{-- jQuery Form Validation JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>
    <script>
        (() => {
            new EmojiPicker()
        })()

        $('#admin-password-reset').validate({
            rules: {
                temp_password: {
                    required: true,
                },
                password: {
                    required: true,
                    pwcheck: true
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#inputNewPassword"
                },
                emoji_password: {
                    required: true
                }
            },
            message: {
                temp_password: {
                    required: "Temporary password is required",
                },
                password: {
                    required: "New password is required",

                },
                password_confirmation: {
                    required: "Confirm password is required",
                    equalTo: "Password didn't match"
                },
                emoji_password: {
                    required: "Emoji password is required"
                }
            },

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



        @if (Session::has('message'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
            toastr.error("{{ session('error') }}");
        @endif
    </script>
</body>

</html>
