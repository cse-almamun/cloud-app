@extends('template.user-template')

@section('title', 'About Us')

@section('content')
    {{ request()->path() }}
    <div class="mx-auto w-50 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="chooseFile">Upload File</label>
                    <input type="file" name="image" id="chooseFile" accept="image/*" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label for="imageSequence">Image Sequence</label>
                    <input type="text" name="image_sequence" id="imageSequence" class="form-control" placeholder="">
                </div>
                <div id="img-block" class="sortable"></div>
            </div>
        </div>
    </div>
@endsection

@section('customScript')
    <script src="{{ asset('js/puzzle.js') }}"></script>
@endsection
