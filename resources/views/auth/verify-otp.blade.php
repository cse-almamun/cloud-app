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
                    <h5 class="py-3">Verify your One-Time-Password</h5>
                    <span>We just sent a verification code to your email. Please check your email.</span>
                    <div class="mt-3">
                        <form action="{{ route('admin.verify.otp.submit') }}" method="post">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <div class="row text-center">
                                    <div class="col-auto">
                                        <input type="number" class="form-control" name="otp_code" id="" placeholder="OTP"
                                            required>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-blue mb-3">Verify</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="my-3">
                        <div class="d-flex justify-content-center">
                            <form action="{{ route('admin.resend.otp') }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-blue btn-sm rounded-0">Resend OTP</button>
                            </form>
                            <a href="{{ route('admin.logout') }}" class="btn btn-blue btn-sm rounded-0 mx-3">Logout</a>

                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
