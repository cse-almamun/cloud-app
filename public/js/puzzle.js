$(document).ready(function () {
    $("#img-block").hide();
    var puzzleContainer = $("#img-block");
    var size = 3;
    var puzzle = [];
    var updated = [];

    /**
     * base croppie function
     * its defining the cropping size and boundary
     */
    $baseCroppie = $("#cropped-image").croppie({
        viewport: {
            width: 450,
            height: 450,
        },
        boundary: {
            width: 470,
            height: 470,
        },
        enableExif: true,
        showZoomer: true,
    });

    /**
     * read the file when a file choose
     * and the bind the file data into a url
     */

    function readableFile(file) {
        let reader = new FileReader();
        reader.onload = function (event) {
            $baseCroppie
                .croppie("bind", {
                    url: event.target.result,
                })
                .then(function () {
                    //set the zoom rules
                    $(".cr-slider").attr({
                        min: 0.5,
                        max: 1.5,
                    });
                    console.log("jQuery bind complete");
                });
        };
        reader.readAsDataURL(file);
    }

    /**
     * show image into the puzzle container
     * @param {src} src
     */

    function showImage(src) {
        puzzleContainer.css("background-image", 'url("' + src + '")');
        // $(".puzzle-item").css("background-image", 'url("' + src + '")');
        // var fr = new FileReader();
        // fr.onload = function () {
        //     console.log(fr.result);
        //     puzzleContainer.css("background-image", 'url("' + fr.result + '")');
        //     $(".puzzle-item").css("background-image", 'url("' + fr.result + '")');
        // };
        // fr.readAsDataURL(src.files[0]);
    }

    function putImage(resp) {
        var src = document.getElementById("chooseFile");
        //var target = document.getElementById("target");
        showImage(resp);
    }

    /**
     * inpute filed choose file on change action
     */
    $("#chooseFile").change(function (e) {
        e.preventDefault();

        if (this.files && this.files[0]) {
            readableFile(this.files[0]);
            $("#croppieModal").modal("show");
        }
    });

    /**
     * on image crop set the image to puzzle container
     */

    $("#cropButton").click(function (e) {
        e.preventDefault();
        $baseCroppie
            .croppie("result", {
                type: "canvas",
                size: "viewport",
            })
            .then(function (resp) {
                // $("#avatarPreview").attr("src", resp);
                // $("#image-data").attr("value", resp);
                $("#croppieModal").modal("hide");
                $("#image-data").attr("value", resp);
                puzzleContainer.show();
                puzzleContainer.css("background-image", 'url("' + resp + '")');
                // putImage(resp);

                generatePuzzle();
                renderPuzzle();

                $(".puzzle-item").css(
                    "background-image",
                    'url("' + resp + '")'
                );

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
    });

    /**
     * Generate the puzzle sequence
     * size by default deifned 3
     */

    function generatePuzzle() {
        puzzle = [];
        for (let i = 1; i <= size * size; i++) {
            puzzle.push({
                value: i,
                position: i,
            });
        }
    }

    /**
     * render the puzzle image with the data
     */
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
