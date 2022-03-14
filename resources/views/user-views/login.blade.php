@extends('template.user-template')

@section('title', 'Login to Cloud Storage')


@section('content')
    <div class="mx-auto w-50">
        <form action="{{ url('/user/login-process') }}" method="post" id="loginForm">
            <div class="mx-auto text-center my-2">
                <span class="step active">1</span>
                <span class="step">2</span>
                <span class="step">3</span>
            </div>
            @csrf
            {{-- initial credential --}}
            <div class="tab current">
                <div class="card">
                    <h5 class="card-header text-center bg-blue text-white">Login to your account</h5>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="loginEmail">User Email</label>
                            <input type="email" name="email" id="loginEmail" class="form-control" placeholder="">

                        </div>
                        <div class="form-group">
                            <label for="loginPass">User Password</label>
                            <input type="password" name="password" id="loginPass" class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
            </div>

            {{-- emoji password tab --}}
            <div class="tab">
                <div class="card">
                    <h5 class="card-header bg-blue text-white">Choose Emoji Password</h5>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="emojiPassword">Select your Emoji Password</label>
                            <input type="text" name="emoji_password" id="emojiPassword" class="form-control"
                                placeholder="Choose your emoji">
                        </div>
                    </div>
                </div>
            </div>

            {{-- image password tab --}}
            <div class="tab">
                <div class="card">
                    <h5 class="card-header bg-blue text-white">Select your Image Password</h5>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="chooseFile">Upload File</label>
                            <input type="file" name="image" id="chooseFile" accept="image/*" class="form-control">
                        </div>
                        <input type="hidden" name="image_sequence" id="imageSequence" class="form-control">

                        <div id="img-block" class="sortable">
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-2 overflow-auto mb-5">
                <div class="float-left">
                    <a class="nav-link text-blue" href="{{ url('forgot-password') }}">Forgot Password?</a>
                </div>
                <div class="float-right mt-1">
                    <button type="button" class="previous btn btn-warning">Previous</button>
                    <button type="button" class="next btn btn-secondary">Next</button>
                    <button type="submit" class="submit btn btn-blue">Login</button>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('customScript')
    <script>
        $(function() {
            //initialize emoji
            $('#emojiPassword').emojiPicker({
                width: '100%',
                position: 'left'
            });
            //disable enter action on input field
            $('form#loginForm').bind('keypress keydown keyup', function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                }
            });
            //form validation rules
            var val = {
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                    },
                    emoji_password: {
                        required: true
                    },
                    image: {
                        required: true
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
                    emoji_password: {
                        required: "Please choose emoji password"
                    },
                    image: {
                        required: "Please choose image password"
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.parent());
                }
            }

            //simple multistep intialize
            $("#loginForm").multiStepForm({
                beforeSubmit: function(form, submit) {
                    console.log("called before submiting the form");
                    console.log(form);
                    console.log(submit);
                },
                validations: val,
            });
        });
    </script>
    <script src="{{ asset('js/puzzle.js') }}"></script>
@endsection
