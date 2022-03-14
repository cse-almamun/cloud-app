@extends('template.user-template')

@section('title', 'Choose Secuirity Question');

@section('content')
    <div class="mx-auto">
        <div class="card">
            <h5 class="card-header text-center bg-primary text-white">Choose your secuirty questions to reset password</h5>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-row">
                        <div class="col-md-6 col">
                            <div class="form-group">
                                <label for="">Secuirty Question-1</label>
                                <select class="form-control" name="" id="">
                                    @foreach ($questions as $ques)
                                        <option value="{{ $ques->uuid }}">{{ $ques->question }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col">
                            <div class="form-group">
                                <label for="">Answer Question 1</label>
                                <input type="text" name="" id="" class="form-control" placeholder=""
                                    aria-describedby="helpId">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 col">
                            <div class="form-group">
                                <label for="">Secuirty Question-2</label>
                                <select class="form-control" name="" id="">
                                    @foreach ($questions as $ques)
                                        <option value="{{ $ques->uuid }}">{{ $ques->question }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col">
                            <div class="form-group">
                                <label for="">Answer Question 2</label>
                                <input type="text" name="" id="" class="form-control" placeholder=""
                                    aria-describedby="helpId">
                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-6 col">
                            <div class="form-group">
                                <label for="">Secuirty Question-3</label>
                                <select class="form-control" name="" id="">
                                    @foreach ($questions as $ques)
                                        <option value="{{ $ques->uuid }}">{{ $ques->question }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col">
                            <div class="form-group">
                                <label for="">Answer Question 3</label>
                                <input type="text" name="" id="" class="form-control" placeholder=""
                                    aria-describedby="helpId">
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customScript')

@endsection
