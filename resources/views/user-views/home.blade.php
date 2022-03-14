@extends('template.user-template')

@section('title', 'Login to Cloud Storage')


@section('content')
    <div class="row my-5">
        <div class="col-md-6">
            <div class="lef-image-container">
                <img src="{{ asset('images/primary-image.jpg') }}" class="img-fluid" alt="" srcset="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mx-auto w-70">
                <form action="{{ url('/user/login-process') }}" method="post" id="loginForm">

                    @csrf
                    {{-- initial credential --}}
                    <div class="tab current">
                        <div class="card">
                            <h5 class="card-header text-center bg-blue text-white">Login to your account</h5>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="loginEmail">User Email</label>
                                    <input type="email" name="email" id="loginEmail" class="form-control"
                                        value="{{ old('email') }}">
                                    @error('email')
                                        <small class="form-text text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="loginPass">User Password</label>
                                    <input type="password" name="password" id="loginPass" class="form-control"
                                        placeholder="">
                                    @error('password')
                                        <small class="form-text text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2 overflow-auto mb-5">
                        <div class="float-left">
                            <a class="nav-link text-blue" href="{{ url('forgot-password') }}">Forgot Password?</a>
                        </div>
                        <div class="float-right mt-1">
                            <button type="submit" class="submit btn btn-blue">Login</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>


@endsection

@section('customScript')
    <script>
        $(function() {

            //disable enter action on input field
            $('form#loginForm').bind('keypress keydown keyup', function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                }
            });
            //form validation rules
            $('#loginForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    }
                },
                messages: {
                    email: {
                        required: "Email is required",
                        email: "Incorrect Email"
                    },
                    password: {
                        required: "Password is required",
                    },
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.parent());
                }
            });
        });
    </script>
    <script src="{{ asset('js/puzzle.js') }}"></script>
@endsection
