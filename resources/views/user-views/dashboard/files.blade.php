@extends('template.user-dash-template')

@section('title', 'All Files')

@section('content')

    <div class="my-3 d-flex">
        <form action="{{ url('files/uplaod-file') }}" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                @csrf
                <input type="hidden" name="folder_uuid" class="form-control me-5" value="{{ request()->route('uuid') }}"
                    required>
                <input type="file" name="file" class="form-control" accept="*" required>
                <button type="sumbit" class="btn btn-blue">Upload File</button>
            </div>
        </form>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            All Files
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th>File Size</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>File Name</th>
                        <th>File Size</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>

                    @foreach ($files as $file)
                        <tr>
                            <td>{{ $file->file_name }}</td>
                            <td>{{ HelperUtil::readableFileSize($file->file_size) }}</td>
                            <td>{{ $file->created_at }}</td>
                            <td>{{ $file->updated_at }}</td>
                            <td class="d-flex">
                                <button type="button" class="tb-btn text-warning edit-btn" file-id="{{ $file->uuid }}"
                                    data-bs-toggle="modal" data-bs-target="#fileUpdateModal"><i
                                        class="fas fa-edit"></i></button>

                                <form action="{{ url('files/delete-file') }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="file_uuid" value="{{ $file->uuid }}">
                                    <button type="submit" class="tb-btn text-danger"><i class="fas fa-trash"></i></button>
                                </form>
                                <a href="{{ url('/file/download/' . $file->uuid) }}" class="ms-2 tb-btn"><i
                                        class="fas fa-download"></i></a>
                                <button type="button" class="tb-btn text-warning share-btn" file-id="{{ $file->uuid }}"
                                    data-bs-toggle="modal" data-bs-target="#fileUpdateModal"><i
                                        class="fas fa-share-alt"></i></button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="fileUpdateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="edit-share" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="file_uuid" id="fileInputUUID" readonly>

                        <div class="mb-2" id="dynamicFiled">
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary submit-btn">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('custom-script')
    <script>
        $(document).ready(function() {
            var dynamicContainer = $('#dynamicFiled');
            var updateButton = $(".submit-btn").html("");

            $('.close').click(function(e) {
                e.preventDefault();
                $('.user-list').remove();
                $('input[name="user_id"]').remove();
            });

            $('.edit-btn').click(function(e) {
                e.preventDefault();
                $(".modal-title").text("Update File Name");
                dynamicContainer.empty();
                let url = '{{ url('file/update-file') }}';
                $('#edit-share').attr('action', url);
                let uuid = $(this).attr('file-id');
                $('#fileInputUUID').val(uuid);
                let label = '<label for="">New File Name</label>';
                dynamicContainer.append(label);
                dynamicContainer.append(createInputField("text", "new_fileName", "", "New File Name"));
                updateButton.html("Update");
            });

            $(".share-btn").click(function(e) {
                e.preventDefault();
                $(".modal-title").text("Share File");
                dynamicContainer.empty();
                let url = '{{ url('file/share') }}';
                $('#edit-share').attr('action', url);
                let uuid = $(this).attr('file-id');
                $('#fileInputUUID').val(uuid);
                let input = createInputField("text", "search_input", "", "search user email or name",
                    "user_search", true, "");
                dynamicContainer.append(input);
                updateButton.html("Share");
                let element = `<div class="user-list mb-2">
                            <ul class="list-group"></ul>
                        </div>`;

                dynamicContainer.after(element);
                inputKeyUp("user_search");

            });

            function createInputField(type, name, value = "", placeholder, id = "", required = true, read) {
                return `<input type="${type}" class="form-control" name="${name}" value="${value}" placeholder="${placeholder}" id="${id}" required="${required}" ${read}>`;
            }


            function inputKeyUp(id) {
                $('#' + id).keyup(function(e) {
                    e.preventDefault();
                    let value = $(this).val();
                    if (value.length > 0) {
                        getUserList(value);
                    } else {
                        $('.user-list>ul').empty();
                    }
                });
            }

            function getUserList(data) {
                $.ajax({
                    type: "post",
                    url: '{{ url('search/users') }}',
                    data: {
                        search_value: data
                    },
                    dataType: "json",
                    success: function(response) {
                        let data = JSON.stringify(response);
                        let obj = JSON.parse(data);

                        if (obj.length > 0) {
                            implementUserList(obj);
                        } else {
                            $('.user-list>ul').empty();
                        }
                    }
                });
            }


            function implementUserList(data) {
                $('.user-list>ul').empty();

                $.each(data, function(key, value) {
                    $('.user-list>ul').append(
                        `<li class="list-group-item user" userUUID="${value.uuid}">${value.first_name} ${value.last_name}</li>`
                    );
                });

                userItemClicked();

            }

            function userItemClicked() {
                $(".user").click(function(e) {
                    e.preventDefault();
                    let name = $(this).text();
                    let uuid = $(this).attr('userUUID');
                    $('input[name="search_input"]').val(name);
                    dynamicContainer.after(createInputField('hidden', 'user_id', uuid, "", "", true,
                        "readonly"));
                    $('.user-list>ul').empty();
                });
            }

        });
    </script>
@endsection
