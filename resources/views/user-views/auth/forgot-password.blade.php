@extends('template.user-template')
@section('title', 'Cloud Storage')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded-lg mt-5">
                <div class="card-header bg-blue">
                    <h3 class="text-center font-weight-light text-white my-2">Password Recovery</h3>
                </div>
                <div class="card-body">

                    <form action="{{ url('check-secuirty-questions') }}" method="get">
                        <div class="form-floating mb-3">
                            <label for="inputEmail">Email address</label>
                            <input type="email" class="form-control" name="email" id="inputEmail"
                                placeholder="name@example.com" required />
                        </div>
                        <div class="small mb-3 text-muted">Enter your email address and we will send you a link
                            to reset your password.</div>
                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                            <a class="small text-blue" href="{{ url('/') }}">Return to login</a>
                            <button type="submit" class="btn btn-blue">Next</button>
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
@endsection
