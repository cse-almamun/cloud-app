@extends('template.user-template')

@section('title', 'Create a new account')


@section('content')
    <div class="w-100 mx-auto">
        <form action="{{ url('/user/registration-process') }}" id="registrationForm" method="POST"
            enctype="multipart/form-data">
            <div class="mx-auto text-center my-2">
                <span class="step active">1</span>
                <span class="step">2</span>
                <span class="step">3</span>
            </div>
            @csrf
            {{-- personal information tab --}}
            <div class="tab current">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName"
                                        value="{{ old('firstName') }}" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName"
                                        value="{{ old('lastName') }}" placeholder="Last Name" required>
                                </div>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email') }}" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="emailConfirm">Confirm Email</label>
                                    <input type="email" class="form-control" id="emailConfirm" name="emailConfirm"
                                        value="{{ old('emailConfirm') }}" placeholder="Email" required>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="passwordConfirm">Confimr Password</label>
                                    <input type="password" class="form-control" id="passwordConfirm"
                                        name="passwordConfirm" placeholder="Password" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="telephone">Enter Phone Number</label>
                            <input type="tel" id="telephone" name="telephone" class="form-control"
                                value="{{ old('telephone') }}" required>
                        </div>
                        <span id="lblValid" class="hide" style="color:green;">✓ Valid</span>
                        <span id="lblError" class="hide" style="color:red;">Invalid number</span>
                    </div>
                    <div class="col-md-6">
                        <div class="image-container">
                            <img class="img-fluid" src="{{ asset('images/primary-image.jpg') }}" alt="" srcset="">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-row">
                            <div class="col-md-12 col">
                                <div class="form-group">
                                    <label for="questionOne">Secuirty Question-1</label>
                                    <select class="form-control" name="question_one" id="questionOne" required>
                                        @foreach ($questions as $ques)
                                            <option value="{{ $ques->uuid }}">{{ $ques->question }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col">
                                <div class="form-group">
                                    <label for="questionOneAnswer">Answer Question 1</label>
                                    <input type="text" name="question_one_ans" id="questionOneAnswer" class="form-control"
                                        value="{{ old('question_one_ans') }}" placeholder="type your answer" required>
                                    <div class="form-text text-muted small">The answer is case sensitive. </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-row">
                            <div class="col-md-12 col">
                                <div class="form-group">
                                    <label for="questionTwo">Secuirty Question-2</label>
                                    <select class="form-control" name="question_two" id="questionTwo" required>
                                        @foreach ($questions as $ques)
                                            <option value="{{ $ques->uuid }}">{{ $ques->question }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col">
                                <div class="form-group">
                                    <label for="questionTwoAnswer">Answer Question 2</label>
                                    <input type="text" name="question_two_ans" id="questionTwoAnswer" class="form-control"
                                        value="{{ old('question_two_ans') }}" placeholder="type your answer" required>
                                    <div class="form-text text-muted small">The answer is case sensitive. </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-row">
                            <div class="col-md-12 col">
                                <div class="form-group">
                                    <label for="questionThree">Secuirty Question-3</label>
                                    <select class="form-control" name="question_three" id="questionThree" required>
                                        @foreach ($questions as $ques)
                                            <option value="{{ $ques->uuid }}">{{ $ques->question }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col">
                                <div class="form-group">
                                    <label for="questionThreeAnswer">Answer Question 3</label>
                                    <input type="text" name="question_three_ans" id="questionThreeAnswer"
                                        class="form-control" value="{{ old('question_three_ans') }}"
                                        placeholder="type your answer" required>
                                    <div class="form-text text-muted small">The answer is case sensitive. </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- image password tab --}}
            <div class="tab">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="data" value="" id="image-data" class="form-control" required>
                        <div class="form-group">
                            <label for="chooseFile">Upload Secuirty Image</label>
                            <input type="file" name="image" id="chooseFile" accept="image/*" class="form-control"
                                placeholder="" required>
                            <div class="form-text text-muted small">Please choose your security image and remeber your
                                puzzle sequence.</div>
                        </div>
                        <input type="hidden" name="image_sequence" id="imageSequence" class="form-control" required>
                        <div id="img-block" class="sortable"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="image-container">
                            <img class="img-fluid" src="{{ asset('images/primary-image.jpg') }}" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>

            {{-- emoji password tab --}}
            <div class="tab">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="emojiPassword">Select your Emoji Password</label>
                            <input type="password" name="emoji_password" id="emojiPassword" class="form-control"
                                value="{{ old('emoji_password') }}" placeholder="Choose your emoji" required>
                            <div class="form-text text-muted small">Please remeber your choosen emoji's sequence.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="image-container">
                            <img class="img-fluid" src="{{ asset('images/primary-image.jpg') }}" alt="" srcset="">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Croppie Modal -->
            <div class="modal fade" id="croppieModal" data-bs-backdrop="static" data-bs-keyboard="false"
                aria-labelledby="croppieModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="croppieModalLabel">Profile Picture Preview</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="cropped-image"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="cancelCropping"
                                data-bs-dismiss="modal">Close</button>
                            <button type="button" id="cropButton" class="btn btn-primary">Crop</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- style="float:right; margin-top: 5px;" --}}
            <div class="p-2 overflow-auto mb-5">
                <div class="float-left">
                    <a class="nav-link text-blue" href="{{ url('/') }}">Already have account?</a>
                </div>
                <div class="float-right mt-1">
                    <button type="button" class="previous btn btn-warning">Previous</button>
                    <button type="button" class="next btn btn-secondary">Next</button>
                    <button class="submit btn btn-blue">Register</button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('customScript')
    <script>
        $(function() {
            $('form#registrationForm').bind('keypress keydown keyup', function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                }
            });
            //form validation rules
            var val = {
                rules: {
                    firstName: {
                        required: true,
                    },
                    lastName: {
                        required: true,
                    },
                    password: {
                        required: true,
                        pwcheck: true,
                    },
                    passwordConfirm: {
                        required: true,
                        equalTo: "#password"
                    },
                    email: {
                        required: true,
                        email: true,
                        remote: {
                            url: '/user/check-email',
                            type: 'post'
                        }
                    },
                    emailConfirm: {
                        required: true,
                        equalTo: "#email"
                    },
                    telephone: {
                        required: true,
                        remote: {
                            url: '/user/check-phone',
                            type: 'post'
                        },
                    },
                    question_one: {
                        required: true,
                        questionDuplicate: true
                    },
                    question_one_ans: {
                        required: true,
                    },
                    question_two: {
                        required: true,
                        questionDuplicate: true
                    },
                    question_two_ans: {
                        required: true,
                    },
                    question_three: {
                        required: true,
                        questionDuplicate: true
                    },
                    question_three_ans: {
                        required: true,
                    },
                    emoji_password: {
                        required: true,
                        minlength: 5
                    },
                    image: {
                        required: true
                    }
                },
                messages: {
                    firstName: {
                        required: "This is required",
                    },
                    lastName: {
                        required: "This is required",
                    },
                    password: {
                        required: "This is required",
                    },
                    passwordConfirm: {
                        required: "This is required",
                        equalTo: "Password didn't match"
                    },
                    email: {
                        required: "Email required",
                        email: "Incorrect Email",
                        remote: 'Email alredy in use'
                    },
                    emailConfirm: {
                        required: "This si required",
                        equalTo: "Email didn't match"
                    },
                    telephone: {
                        required: "Telephone Number is required",
                        remote: 'Number alredy in use',
                    },
                    question_one: {
                        required: "Please select your question",
                        questionDuplicate: "Question already selected"
                    },
                    question_one_ans: {
                        required: "Please type your answer"
                    },
                    question_two: {
                        required: "Please select your question",
                        questionDuplicate: "Question already selected"
                    },
                    question_two_ans: {
                        required: "Please type your answer"
                    },
                    question_three: {
                        required: "Please select your question",
                        questionDuplicate: "Question already selected"
                    },
                    question_three_ans: {
                        required: "Please type your answer"
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
            $("form#registrationForm").multiStepForm({
                beforeSubmit: function(form, submit) {
                    console.log("called before submiting the form");
                    console.log(form);
                    console.log(submit);
                },
                validations: val,
            });

            //check phone validation
            var telInput = $("#telephone");
            var errorMsg = $("#lblError");
            var validMsg = $("#lblValid");
            telInput.intlTelInput();


            function FormatNumber() {
                var number = telInput.val();
                var classf = $(".iti__selected-flag > div").attr("class");
                var flag = classf.slice(-2);
                var formattedNumber = intlTelInputUtils.formatNumber(number, flag, intlTelInputUtils
                    .numberFormat
                    .INTERNATIONAL);
                telInput.val(formattedNumber.slice(formattedNumber.indexOf(' ') + 1, formattedNumber
                    .length));
            }
            telInput.keyup(function() {
                FormatNumber();
            });
            telInput.keydown(function() {
                telInput.removeClass("error");
                errorMsg.addClass("hide");
                validMsg.addClass("hide");
            });

            telInput.blur(function() {
                if ($.trim(telInput.val())) {
                    if (telInput.intlTelInput("isValidNumber")) {
                        validMsg.removeClass("hide");
                    } else {
                        telInput.addClass("error");
                        errorMsg.removeClass("hide");
                        validMsg.addClass("hide");
                    }
                }
            });


            //check question dulplicate validation
            $.validator.addMethod('questionDuplicate', function() {
                let q1, q2, q3;
                q1 = $("#questionOne").val();
                q2 = $("#questionTwo").val();
                q3 = $("#questionThree").val();
                if (q1 === q2 || q2 === q3 || q3 === q1) {
                    return false;
                }
                return true;
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

            $('#emojiPassword').emojiPicker({
                width: '100%',
                position: 'left'
            });



        });
    </script>
    <script src="{{ asset('js/puzzle.js') }}"></script>
@endsection
