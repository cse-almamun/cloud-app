@extends('template.user-template')

@section('title', 'Verify your email')

@section('content')
    <div class="d-flex align-items-center justify-content-center my-5">
        <div class="card w-50">
            <div class="card-body">
                <div class="email-image text-center">
                    <img src="{{ asset('images/email.png') }}" class="img-fluid" style="width: 30%;" alt="" srcset="">
                </div>
                <div class="text-center">
                    <h5 class="py-3">Verify your email address!</h5>
                    <span>We just sent a verification link to your email. Please verify your email address to complete your
                        registration.</span>
                    <div class="my-3">
                        <div class="d-flex justify-content-center">
                            <form action="{{ route('verification.send') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-blue btn-sm rounded-0">Resend Email</button>
                            </form>
                            <a href="{{ url('/logout') }}" class="btn btn-blue btn-sm rounded-0 mx-3">Logout</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
