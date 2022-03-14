@extends('template.user-template')

@section('title', 'Login to Cloud Storage')


@section('content')

    <div class="row my-2">
        <div class="col-md-12">
            <div class="mx-auto" style="width: 50%">


                <form action="{{ url('verify-security-image') }}" method="post">

                    @csrf

                    {{-- image password tab --}}
                    <div class="card">
                        <h5 class="card-header bg-blue text-white">Solve your Puzzle</h5>
                        <div class="card-body">
                            {{-- <img class="img-fluid sortable" src="{{ url('security-image/' . $img->security_image) }}"
                                alt="image" srcset=""> --}}
                            <input type="hidden" name="image_sequence" id="imageSequence" class="form-control">

                            <div id="img-block" style="width: 450px; height: 450px;" class="sortable"
                                data-src="{{ url('security-image/' . $img->security_image) }}">
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
    <a href="{{ url('support') }}" class="nav-link btn-blue float-right mb-5">Contact Administrator</a>


@endsection

@section('customScript')
    {{-- <script src="{{ asset('js/puzzle.js') }}"></script> --}}
    <script>
        $(document).ready(function() {
            var puzzleContainer = $("#img-block");

            var size = 3;
            var puzzle = [];
            var updated = [];
            puzzleContainer.show();
            var imageURL = puzzleContainer.attr('data-src');
            puzzleContainer.css("background-image", 'url("' + imageURL + '")');

            generatePuzzle();
            renderPuzzle();

            $(".puzzle-item").css("background-image", 'url("' + imageURL + '")');

            function generatePuzzle() {
                puzzle = [];
                for (let i = 1; i <= size * size; i++) {
                    puzzle.push({
                        value: i,
                        position: i,
                    });
                }
            }

            function renderPuzzle() {
                puzzleContainer.html("");
                for (let puzzleItem of puzzle) {
                    let content = `
                    <div class="puzzle-item" id="tile${puzzleItem.value}"></div>
                    `;
                    puzzleContainer.append(content);
                }
            }

            $(".sortable").sortable({
                connectWith: ".sortable",
            }, {
                update: function(event, ui) {
                    updated = [];
                    let div = puzzleContainer.find("div");
                    $.each(div, function(i, elem) {
                        updated.push(elem.id);
                    });

                    $("#imageSequence").val(updated.toString());
                },
            });

        });
    </script>

@endsection
