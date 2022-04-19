$(document).ready(function () {
    var sharebutton = $(".shareList");
    let table = document.querySelector("#shareListModal table#userListTable");
    let tbody = $("#shareListModal table#userListTable tbody");
    sharebutton.click(function (e) {
        e.preventDefault();
        let uuid = $(this).attr("file-id");

        if (table) {
            new simpleDatatables.DataTable(table);
        }
        tbody.html(" ");
        $.ajax({
            type: "get",
            url: `/file/${uuid}/shared-users`,
            success: function (response) {
                sucessResponse(response);
            },
        });
    });

    /**
     * Implement datatable row on ajax success call
     * @param {response} response
     */
    function sucessResponse(response) {
        if (response.length) {
            let dataString = JSON.stringify(response);
            let dataJSON = JSON.parse(dataString);
            let data = [];
            dataJSON.forEach((element) => {
                let tr = `<tr class="text-center">
                        <td>${element.first_name} ${element.last_name}</td>
                        <td>${element.email}</td>
                        <td><button class="tb-btn text-danger remove-user" share-id="${element.uuid}"><i class="fas fa-ban"></i></button></td>
                        </tr>`;
                data.push(tr);
            });

            tbody.append(data);
            removeSharedUser();
        } else {
            tbody.append(
                `<tr><td class="dataTables-empty" colspan="3">This file haven't shared with anyone!!</td></tr>`
            );
        }
    }

    /**
     * remove a user from file shared list
     * @param {*} uuid
     */

    function removeSharedUser() {
        $(".remove-user").click(function (e) {
            e.preventDefault();
            let uuid = $(this).attr("share-id");
            let parentTr = $(this).closest("tr");

            swal({
                title: "Want to remove this user?",
                icon: "warning",
                text: "This user will longer to see this files",
                buttons: true,
                dangerMode: true,
            }).then((confirm) => {
                if (confirm) {
                    $.ajax({
                        type: "delete",
                        url: `/shared-file/${uuid}/remove-user`,
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                            if (response) {
                                parentTr.remove();
                                toastr.success("User Removed Successfully!!!");

                                //refresh or reload the page to get update data
                                setTimeout(function () {
                                    location.reload();
                                }, 5000);
                            } else {
                                toastr.error("Unable Removed User!!!");
                            }
                        },
                    });
                }
            });
        });
    }

    /**
     * Delete a file
     */

    $(".fileDelete").submit(function (e) {
        e.preventDefault();
        swal({
            title: "Want to delete this file?",
            icon: "warning",
            text: "The action is permanent. No option to undo.",
            buttons: true,
            dangerMode: true,
        }).then((confirm) => {
            if (confirm) {
                e.currentTarget.submit();
            }
        });
    });
});
