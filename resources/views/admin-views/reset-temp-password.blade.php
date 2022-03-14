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
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
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
                                    <form action="{{ route('admin.reset.temp-password.submit') }}" method='post'>
                                        @csrf
                                        <input type="hidden" name="uuid" value="{{ $uuid }}">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputTempPass" type="password"
                                                name="temp_password" value="{{ old('temp_password') }}"
                                                placeholder="name@example.com" required />
                                            <label for="inputTempPass">Temporary Password</label>
                                            @error('temp_password')
                                                <small class="form-text text-danger">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputNewPassword" type="password"
                                                name="password" placeholder="Password" required />
                                            <label for="inputNewPassword">Password</label>
                                            @error('password')
                                                <small class="form-text text-danger">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputConfirmPassword" type="password"
                                                name="password_confirmation" placeholder="Password" required />
                                            <label for="inputConfirmPassword">Confirm Password</label>
                                            @error('password_confirmation')
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

    <script>
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
