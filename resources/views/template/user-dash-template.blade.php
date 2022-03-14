<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.user-dashboard.header-script')
</head>

<body class="sb-nav-fixed">
    @include('includes.user-dashboard.top-nav')
    <div id="layoutSidenav">
        @include('includes.user-dashboard.layout-sidenav')
        @include('includes.user-dashboard.layout-side-content')
    </div>
    <!-- File Upload Modal -->
    <div class="modal fade" id="fileUploadModal" tabindex="-1" aria-labelledby="fileUploadModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileUploadModalLabel">Upload File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('files/uplaod-file') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-2">
                            <label for="folders" class="form-label">Choose Directory</label>
                            <select class="form-select" name="folder_uuid" id="folders" required></select>
                        </div>
                        <div class="mb-2">
                            <label for="formFileSm" class="form-label">Choose Your file</label>
                            <input type="file" class="form-control" name="file" id="formFileSm" required>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-blue">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('includes.user-dashboard.footer-script')
    @yield('custom-script');
</body>

</html>
