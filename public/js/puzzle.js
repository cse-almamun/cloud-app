$(document).ready(function () {
    $("#img-block").hide();
    var puzzleContainer = $("#img-block");
    var size = 3;
    var puzzle = [];
    var updated = [];

    function showImage(src) {
        var fr = new FileReader();
        fr.onload = function () {
            puzzleContainer.css("background-image", 'url("' + fr.result + '")');
            $(".puzzle-item").css(
                "background-image",
                'url("' + fr.result + '")'
            );
        };
        fr.readAsDataURL(src.files[0]);
    }

    function putImage() {
        var src = document.getElementById("chooseFile");
        //var target = document.getElementById("target");
        showImage(src);
    }
    $("#chooseFile").change(function (e) {
        e.preventDefault();
        puzzleContainer.show();
        putImage();

        generatePuzzle();
        renderPuzzle();

        $(".sortable").sortable(
            {
                connectWith: ".sortable",
            },
            {
                update: function (event, ui) {
                    updated = [];
                    let div = puzzleContainer.find("div");
                    console.log("updating");
                    $.each(div, function (i, elem) {
                        updated.push(elem.id);
                    });

                    $("#imageSequence").val(updated.toString());
                    console.log(updated.toString());
                },
            }
        );
    });

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
});
