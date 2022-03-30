@extends('template.user-template')

@section('title', 'Login to Cloud Storage')


@section('content')
    <div class="row my-5">
        <div class="col-md-6">
            <div class="lef-image-container">
                <img src="{{ asset('images/primary-image.jpg') }}" class="img-fluid" alt="" srcset="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mx-auto w-70">
                <form action="{{ url('verify-security-emoji') }}" method="post">

                    @csrf
                    {{-- emoji password tab --}}
                    <div class=" card">
                        <h5 class="card-header bg-blue text-white">Choose Emoji Password</h5>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="emojiPassword">Select your Emoji Password</label>
                                <input type="password" name="emoji_password" id="emojiPassword"
                                    value="{{ old('emoji_password') }}" class="form-control"
                                    placeholder="Choose your emoji">
                                @error('emoji_password')
                                    <small class="form-text text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="p-2 overflow-auto mb-5">
                        <div class="float-left">
                            <a class="nav-link text-blue" href="{{ url('forgot-password') }}">Forgot Password?</a>
                        </div>
                        <div class="float-right mt-1">
                            <button type="submit" class="submit btn btn-blue">Check</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <a href="{{ url('support') }}" class="nav-link btn-blue float-right">Contact Administrator</a>



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

@endsection
