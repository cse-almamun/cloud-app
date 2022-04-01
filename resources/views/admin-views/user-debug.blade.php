@extends('template.admin-template')

@section('title', 'User Debug')

@section('content')

    <div class="my-3">
        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pills-files-tab" data-bs-toggle="pill" data-bs-target="#pills-files"
                    type="button" role="tab" aria-controls="pills-files" aria-selected="true">Files</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-folder-tab" data-bs-toggle="pill" data-bs-target="#pills-folder"
                    type="button" role="tab" aria-controls="pills-folder" aria-selected="false">Folder</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                    type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-action-tab" data-bs-toggle="pill" data-bs-target="#pills-action"
                    type="button" role="tab" aria-controls="pills-action" aria-selected="false">Action</button>
            </li>
        </ul>
    </div>


    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-files" role="tabpanel" aria-labelledby="pills-files-tab">
            <div class="card my-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Recent Files
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Size</th>
                                <th>Folder</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->files as $file)
                                @if ($file->index < 10)
                                    <tr>
                                        <td>{{ $file->file_name }}</td>
                                        <td>{{ $file->file_size }}</td>
                                        <td>{{ $file->folder->name }}</td>
                                        <td>{{ $file->created_at }}</td>
                                        <td>{{ $file->updated_at }}</td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-folder" role="tabpanel" aria-labelledby="pills-folder-tab">
            <div class="card my-3">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Recent Folders
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->folders as $folder)
                                @if ($folder->index < 10)
                                    <tr>
                                        <td>{{ $folder->name }}</td>
                                        <td>{{ $file->created_at }}</td>
                                        <td>{{ $file->updated_at }}</td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

            <div class="row d-flex justify-content-center">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Total Storage: {{ $user->storage }} GB</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-secondary text-white mb-4">
                        <div class="card-body">Used Space: {{ $size }}</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Total Directory: {{ $total_folder }}</div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Total Files: {{ $total_files }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="float-start pt-2">Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
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
                                    @foreach ($user->securityQuestions as $value)
                                        <div class="info-item d-flex w-100">
                                            <div class="info-title me-5">
                                                {{ $value->question->question }}
                                            </div>
                                            <div class="question-info ms-5">
                                                {{ $value->answer }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <h6 class="float-start pt-2">Avatar</h6>
                                        </div>
                                        <div class="card-body">
                                            <img src="{{ route('admin.debug.user.image', ['uuid' => $user->uuid, 'item' => 'avatar']) }}"
                                                class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                                                alt="">
                                        </div>
                                    </div>

                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header text-center">
                                            <h6 class="float-start pt-2">Security Image</h6>
                                        </div>
                                        <div class="card-body">
                                            <img src="{{ route('admin.debug.user.image', ['uuid' => $user->uuid, 'item' => 'security-image']) }}"
                                                class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="pills-action" role="tabpanel" aria-labelledby="pills-action-tab">
            <div class="card">
                <div class="card-header">
                    <h5 class="float-start pt-2">Perform User Request Action</h5>
                </div>
                <div class="card-body">
                    <div class="my-2">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-center">Send User Secruirty Password Request</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('admin.debug.user.reset-security-password.submit') }}"
                                    method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <input type="hidden" name="user_uuid" id="" value="{{ $user->uuid }}"
                                            class="form-control" required readonly>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <select class="form-control" name="reset_option" required>
                                                    <option disabled selected>Choose Option</option>
                                                    <option value="reset_emoji">Reset Emoji Password</option>
                                                    <option value="reset_image">Reset Image Password</option>
                                                    <option value="reset_questions">Reset Questions</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="col-4">
                                            <button type="submit" class="btn btn-blue">Send</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="my-2">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="text-center">Update User Storage Limit</h5>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('amdin.update.user-storage.submit') }}" class="row g-3"
                                    method="POST">
                                    @csrf

                                    <input type="hidden" name="email" readonly class="form-control" id="staticEmail"
                                        value="{{ $user->email }}" required>

                                    <input type="hidden" name="uuid" readonly class="form-control" id="statiUUID"
                                        value="{{ $user->uuid }}" required>

                                    <div class="col-3">
                                        <label for="storageLimit" class="visually-hidden">Storage Limit</label>
                                        <input type="number" name="storage" class="form-control" id="storageLimit"
                                            placeholder="Storage limit" required>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-blue">Submit</button>
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
