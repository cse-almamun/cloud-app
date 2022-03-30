@extends('template.user-template')
@section('title', 'Cloud Storage')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-lg mt-5">
                <div class="card-header bg-blue">
                    <h3 class="text-center font-weight-light text-white my-2">Answer Your Security Question</h3>
                </div>
                <div class="card-body">

                    <form action="{{ url('forgot-password') }}" method="post">
                        @csrf

                        <input type="hidden" name="user_uuid" class="form-control" value="{{ $user->uuid }}">
                        <input type="hidden" name="email" class="form-control" value="{{ request('email') }}">
                        @foreach ($questions as $q)
                            <div class="form-floating mb-3">
                                <input type="hidden" name="answer_uuid_{{ $loop->index + 1 }}" class="form-control"
                                    value="{{ $q->uuid }}">
                                <label for="inputAnswer{{ $loop->index + 1 }}">{{ $q->question }}</label>
                                <input type="text" class="form-control" name="answer_{{ $loop->index + 1 }}"
                                    id="inputAnswer{{ $loop->index + 1 }}" placeholder="input your answer" required />
                                <div class="form-text text-muted small">The answer is case sensitive. </div>

                            </div>
                        @endforeach

                        <div class="small mb-3 text-muted">Enter your email address and we will send you a link
                            to reset your password.</div>
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <a class="small text-blue" href="{{ url('/') }}">Return to login</a>
                            <button type="submit" class="btn btn-blue">Get Reset Link</button>
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

    <a href="{{ url('support') }}" class="nav-link btn-blue float-right">Contact Administrator</a>
@endsection
