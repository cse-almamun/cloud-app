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
                        <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"
                            aria-selected="false">Contact</button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="nav-container">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                    aria-labelledby="pills-profile-tab">

                    <div class="profile-container my-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="float-start pt-2">Profile Information</h5>
                                <button class="btn btn-blue float-end">Update</button>
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
                                        <form action="">
                                            <div class="form-group">
                                                <label for="chooseFile">Upload Profile Picture</label>
                                                <input type="file" name="image" id="chooseFile" accept="image/*"
                                                    class="form-control" placeholder="">
                                            </div>
                                            <div class="text-center mt-2">
                                                <button type="submit" class="btn btn-blue rounded-0">Save</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">

                    <div class="my-1">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="pt-2">Update Profile Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="basic_info">
                                    <h5>Update Basic Info</h5>
                                    <form action="">
                                        <div class="row">
                                            <div class="col">
                                                <label for="firstName">First Name</label>
                                                <input type="text" name="first_name" id="firstName" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col">
                                                <label for="lastName">Last Name</label>
                                                <input type="text" name="last_name" id="lastName" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col">
                                                <div class=" mt-4">
                                                    <button type="submit" class="btn btn-blue rounded-0">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="security_question">
                                    <h5>Update Secuirity Question</h5>
                                    <form action="">
                                        <div class="row">
                                            <div class="col">
                                                <label for="seq">Choose Security Question</label>
                                                <select class="form-control" name="seq" id="seq">
                                                    @foreach ($questions as $q)
                                                        <option value="{{ $q->uuid }}">{{ $q->question }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col">
                                                <label for="seqAnswer">Answer</label>
                                                <input type="text" name="answer" id="seqAnswer" class="form-control"
                                                    required>
                                            </div>
                                            <div class="col">
                                                <div class=" mt-4">
                                                    <button type="submit" class="btn btn-blue rounded-0">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>



                                <div class="update_avatar mt-2">
                                    <h5>Update Profile Avatar</h5>
                                    <form action="">
                                        <div class="row">
                                            <div class="col">
                                                <label for="chooseFile">Upload Profile Picture</label>
                                                <input type="file" name="image" id="chooseFile" accept="image/*"
                                                    class="form-control" placeholder="">
                                            </div>
                                            <div class="col">
                                                <div class="mt-4">
                                                    <button type="submit" class="btn btn-blue rounded-0">Save</button>
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
            });
        </script>

    @endsection
