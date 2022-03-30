@extends('template.user-dash-template')

@section('title', 'Welcome')

@section('content')

    <div class="profile-container my-3">
        <div class="profile-header bg-blue">
            <div class="image-box">
                <img src="{{ $user->avatar === null ? asset('images/profile/Profile-Photo.png') : url('/user/avatar/' . $user->avatar) }}"
                    alt="" srcset="">
            </div>
            <div class="profile-nav-item d-flex justify-content-center mt-2">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-update-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-update" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false">Update</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="nav-container">
            <div class="tab-content" id="pills-tabContent">
                {{-- profile tab area --}}
                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                    aria-labelledby="pills-profile-tab">

                    <div class="profile-container my-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-start pt-2">Profile Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <div class="info-title">
                                                        First Name
                                                    </div>
                                                    <div class="user-info">
                                                        {{ $user->first_name }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <div class="info-title">
                                                        Last Name
                                                    </div>
                                                    <div class="user-info">
                                                        {{ $user->last_name }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <div class="info-title">
                                                        User Email
                                                    </div>
                                                    <div class="user-info">
                                                        {{ $user->email }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <div class="info-title">
                                                        User Phone
                                                    </div>
                                                    <div class="user-info">
                                                        {{ $user->phone_number }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="info-item">
                                                    <div class="info-title">
                                                        Secuirity Questions
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="question-list">
                                                @foreach ($questions as $value)
                                                    <div class="info-item d-flex w-100">
                                                        <div class="info-title me-5">
                                                            {{ $value->question }}
                                                        </div>
                                                        <div class="question-info ms-5">
                                                            <div class="answer-group">
                                                                <input type="password" value="{{ $value->answer }}"
                                                                    class="q-answer" readonly>
                                                                {{-- <i class="fas fa-eye" class="view"></i> --}}
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{-- Update user profile avatar --}}
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="small">
                                                    Update Profile Avatar
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="update_avatar">
                                                    <form action="{{ route('user.update.avatar.submit') }}" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="uuid" id="" value="{{ $user->uuid }}"
                                                            class="form-control" required>
                                                        <input type="hidden" name="data" value="" id="image-data"
                                                            class="form-control" required>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label for="chooseAvatar">Upload Profile Picture</label>
                                                                <input type="file" name="image" id="chooseAvatar"
                                                                    accept="image/*" class="form-control" placeholder="">
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="mt-4">
                                                                    <button type="submit"
                                                                        class="btn btn-blue rounded-0">Save</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="my-2">
                                                    <img src="" alt="" class="img-fluid" id="avatarPreview">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- profile update tab area --}}
                <div class="tab-pane fade" id="pills-update" role="tabpanel" aria-labelledby="pills-update-tab">

                    <div class="my-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="pt-2">Update Profile Information</h5>
                            </div>
                            <div class="card-body">
                                {{-- update personal information like first name , last name --}}
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="small">Update Basic Info</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="basic_info">
                                            <form action="{{ route('user.update.information.submit') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uuid" value="{{ $user->uuid }}"
                                                    class="form-control" required>
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="firstName">First Name</label>
                                                        <input type="text" name="first_name" id="firstName"
                                                            class="form-control" value="{{ old('first_name') }}"
                                                            required>

                                                        @error('first_name')
                                                            <div class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror

                                                    </div>
                                                    <div class="col">
                                                        <label for="lastName">Last Name</label>
                                                        <input type="text" name="last_name" id="lastName"
                                                            class="form-control" value="{{ old('last_name') }}"
                                                            required>


                                                        @error('last_name')
                                                            <div class="invalid-feedback d-block" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror

                                                    </div>
                                                    <div class="col">
                                                        <div class=" mt-4">
                                                            <button type="submit"
                                                                class="btn btn-blue rounded-0">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                {{-- Update user security questions --}}
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="small">Update Secuirity Question</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="security_question">
                                            <form action="{{ route('user.update.question.submit') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="user_uuid" id="" value="{{ $user->uuid }}"
                                                    class="form-control" required>
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="seq">Choose Security Question</label>
                                                        <select class="form-control" name="seq_answer_uuid" id="seq">
                                                            @foreach ($questions as $q)
                                                                <option value="{{ $q->uuid }}">{{ $q->question }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col">
                                                        <label for="seqAnswer">Answer</label>
                                                        <input type="text" name="answer" id="seqAnswer"
                                                            class="form-control" required>
                                                    </div>
                                                    <div class="col">
                                                        <div class=" mt-4">
                                                            <button type="submit"
                                                                class="btn btn-blue rounded-0">Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="cropped-avatar"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelCropping"
                            data-bs-dismiss="modal">Close</button>
                        <button type="button" id="cropButton" class="btn btn-primary">Crop</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(function() {
            $('.q-answer').click(function(e) {
                e.preventDefault();
                $(this).addClass('rm-border');
                let type = ($(this).attr('type') === 'password') ? 'text' : 'password';
                $(this).attr('type', type);
            });
            $('.question-info').click(function(e) {
                e.preventDefault();
                $(this).addClass('rm-border');
            });


            $baseCroppie = $('#cropped-avatar').croppie({
                viewport: {
                    width: 200,
                    height: 200
                },
                boundary: {
                    width: 300,
                    height: 300
                },
                enableExif: true,
                showZoomer: true
            });


            function readableFile(file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    $baseCroppie.croppie('bind', {
                        url: event.target.result
                    }).then(function() {
                        $('.cr-slider').attr({
                            'min': 0.2000,
                            'max': 1.5000
                        });
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(file);
            }

            $("#chooseAvatar").change(function(e) {
                e.preventDefault();
                if (this.files && this.files[0]) {
                    readableFile(this.files[0]);
                    $("#croppieModal").modal('show');
                }
            });

            $("#cancelCropping").click(function(e) {
                e.preventDefault();
                $("#croppieModal").modal('hide');
                // setTimeout(() => {
                //     baseCroppie.croppie('destroy');
                // }, 1500);
            });

            $("#cropButton").click(function(e) {
                e.preventDefault();
                $baseCroppie.croppie('result', {
                    type: "canvas",
                    size: "viewport"
                }).then(function(resp) {
                    console.log(resp);
                    $('#avatarPreview').attr('src', resp);
                    $('#image-data').attr('value', resp);
                    $("#croppieModal").modal('hide');
                });
                // $('#avatar-preview').src =
                //     alert("image croped");
            });

        });
    </script>

@endsection
