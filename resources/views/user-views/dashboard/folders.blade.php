@extends('template.user-dash-template')

@section('title', 'All Folder')

@section('content')
    <div class="my-3 d-flex">
        <form action="{{ url('/create-folder') }}" method="POST">
            <div class="input-group">
                @csrf
                <input type="text" name="folder" class="form-control" placeholder="input your folder name" required>
                <button type="sumbit" class="btn btn-blue">Create Folder</button>
            </div>
        </form>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            DataTable Example
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Folder Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>


                    @foreach ($folders as $folder)
                        <tr>
                            <td><a href="folders/{{ $folder->uuid }}">{{ $folder->name }}</a> </td>
                            <td>{{ $folder->created_at }}</td>
                            <td class="d-flex">
                                <button type="button" class="tb-btn text-warning edit-btn" folder-id="{{ $folder->uuid }}"
                                    data-bs-toggle="modal" data-bs-target="#folderUpdateModal"><i
                                        class="fas fa-edit"></i></button>
                                {{-- <form action="{{ url('folders/update') }}" method="POST">

                                    @csrf
                                    <input type="hidden" name="folder_id" value="{{ $folder->uuid }}">
                                    <button type="submit" class="tb-btn text-warning"><i
                                            class="fas fa-edit"></i></button>
                                </form> --}}
                                <form action="{{ url('folders/delete') }}" id="deleteFolder" method="POST">
                                    @method('delete')
                                    @csrf
                                    <input type="hidden" name="folder_id" value="{{ $folder->uuid }}">
                                    <button type="submit" class="tb-btn text-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <!-- Foldeer Update Modal -->
    <div class="modal fade" id="folderUpdateModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update folder name</h5>
                    <button type="button" class="btn-close close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/folders/update') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="folder_uuid" id="folderInputUUID" readonly>
                        <div class="mb-2">
                            <label>New Folder Name</label>
                            <input type="text" name="new_name" class="form-control" value="{{ old('new_name') }}"
                                required>
                            @error('new_name')
                                <div class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
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
            $('.edit-btn').click(function(e) {
                e.preventDefault();
                let uuid = $(this).attr('folder-id');
                $('#folderInputUUID').val(uuid);
            });

            /**
             * Delete a file
             */

            $("#deleteFolder").submit(function(e) {
                e.preventDefault();
                swal({
                    title: "Want to delete this folder?",
                    icon: "warning",
                    text: "The action is permanent and no option to undo.",
                    buttons: true,
                    dangerMode: true,
                }).then((confirm) => {
                    if (confirm) {
                        e.currentTarget.submit();
                    }
                });
            });
        });
    </script>
@endsection
