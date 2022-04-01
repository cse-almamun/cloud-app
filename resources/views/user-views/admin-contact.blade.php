@extends('template.user-template')

@section('title', 'Get support from admin')


@section('content')
    <div class="row my-5">

        <div class="col-md-6">
            <div class="mx-auto w-70">
                <form action="{{ url('send-queries') }}" method="post" id="contactForm">
                    @csrf

                    <div class="card-body">
                        <h5 class="card-header text-center bg-blue text-white rounded-0 mb-3">
                            @if (request()->is('support'))
                                Get support from Administrator
                            @else
                                Send your queries
                            @endif

                        </h5>
                        @if (request()->is('support'))
                            <div class="form-group">
                                <select class="form-control rounded-0" name="question" required>
                                    <option selected disabled>Choose Question</option>
                                    <option>Reset Emoji Password</option>
                                    <option>Reset Image Password</option>
                                    <option>Reset Security Questions</option>
                                </select>
                                @error('question')
                                    <small class="form-text text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                            <input type="hidden" name="option" value="support" required>
                        @endif
                        <div class="form-group">
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" name="first_name" class="form-control rounded-0"
                                        placeholder="First name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                        <small class="form-text text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="col">
                                    <input type="text" name="last_name" class="form-control rounded-0"
                                        placeholder="Last name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                        <small class="form-text text-danger">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" id="loginEmail" class="form-control rounded-0"
                                value="{{ old('email') }}" placeholder="Enter your email" required>
                            @error('email')
                                <small class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <textarea name="message" class="form-control rounded-0" id="exampleFormControlTextarea1" rows="4"
                                placeholder="write your message" required>{{ old('message') }}</textarea>
                            @error('message')
                                <small class="form-text text-danger">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="p-2 overflow-auto">
                            <div class="text-center mt-1">
                                <button type="submit" class="submit btn btn-blue rounded-0">Send</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
        <div class="col-md-6">
            <div class="lef-image-container">
                <img src="{{ asset('images/primary-image.jpg') }}" class="img-fluid" alt="" srcset="">
            </div>
        </div>
    </div>

@endsection
