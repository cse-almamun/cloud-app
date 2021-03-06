@extends('template.user-template')

@section('title', 'Reset Security Password')

@section('content')
    @if ($data->action === 'emoji-password')
        <div class="mx-auto w-50 mw-100 my-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">Chnage your emoji password</h5>
                </div>
                <div class="card-body">

                    <form action="{{ route('user.reset.emoji-password.submit') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" class="form-control" value="{{ $data->id }}">
                        <input type="hidden" name="uuid" class="form-control" value="{{ $data->uuid }}">
                        <div class="form-group">
                            <label>Input your OTP</label>
                            <input type="number" name="otp" class="form-control" placeholder="" aria-describedby="helpId"
                                required>
                            <small id="helpId" class="text-muted">Check your reset email to get OTP code</small>
                        </div>
                        <div class="form-group">
                            <label for="">Choose your new emoji password</label>
                            <input type="password" name="emoji_password" id="emojiPassword" class="form-control"
                                placeholder="" aria-describedby="helpId" required>
                            <small id="helpId" class="text-muted">Please remember the emoji sequence</small>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-blue">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @if ($data->action === 'image-password')
        <div class="mx-auto w-50 my-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center">Reset Image password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.reset.image-password.submit') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" class="form-control" value="{{ $data->id }}">
                        <input type="hidden" name="uuid" class="form-control" value="{{ $data->uuid }}">
                        <input type="hidden" name="data" value="" id="image-data" class="form-control" required>
                        <div class="form-group">
                            <label>Input your OTP</label>
                            <input type="number" name="otp" class="form-control" placeholder="" aria-describedby="helpId"
                                required>
                            <small id="helpId" class="text-muted">Check your reset email to get OTP code</small>
                        </div>
                        <div class="form-group">
                            <label for="chooseFile">Choose Security Image</label>
                            <input type="file" name="image" id="chooseFile" accept="image/*" class="form-control"
                                placeholder="" required>
                            <small id="helpId" class="text-muted">Please choose your security image and remeber your
                                puzzle sequence.</small>
                        </div>
                        <input type="hidden" name="image_sequence" id="imageSequence" class="form-control" required>
                        <div id="img-block" class="sortable mb-3"></div>

                        <div class="text-center mt-2">
                            <button type="submit" class="btn btn-blue rounded-0">Save</button>
                        </div>
                    </form>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    @endif


    @if ($data->action === 'security-questions')
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-lg my-3">
                    <div class="card-header bg-blue">
                        <h3 class="text-center font-weight-light text-white my-2">Reset Your Security Question Answer</h3>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('user.reset.security-questions.submit') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" class="form-control" value="{{ $data->id }}">
                            <input type="hidden" name="uuid" class="form-control" value="{{ $data->uuid }}">
                            <div class="form-group">
                                <label>Input your OTP</label>
                                <input type="number" name="otp" class="form-control" placeholder="eg: 234567"
                                    aria-describedby="helpId" required>
                                <small id="helpId" class="text-muted">Check your reset email to get OTP code</small>
                            </div>
                            @foreach ($questions as $q)
                                <div class="form-floating mb-3">
                                    <input type="hidden" name="answer_uuid_{{ $loop->index + 1 }}" class="form-control"
                                        value="{{ $q->uuid }}">
                                    <label
                                        for="inputAnswer{{ $loop->index + 1 }}">{{ $q->question->question }}</label>
                                    <input type="text" class="form-control" name="answer_{{ $loop->index + 1 }}"
                                        id="inputAnswer{{ $loop->index + 1 }}" placeholder="input your answer"
                                        required />
                                    <div class="form-text text-muted small">The answer is case sensitive. </div>

                                </div>
                            @endforeach
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="small text-blue" href="{{ route('home') }}">Return to login</a>
                                <button type="submit" class="btn btn-blue">Reset Questions</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small">
                            <a href="{{ url('registration') }}" class="text-blue">Need an account? Sign up!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

@endsection
@section('customScript')
    <script>
        $(function() {
            //initialize emoji
            $('#emojiPassword').emojiPicker({
                width: '100%',
                position: 'left'
            });
        });
    </script>
    <script src="{{ asset('js/puzzle.js') }}"></script>
@endsection
