<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.admin.header-script')
</head>

<body class="sb-nav-fixed">
    @include('includes.admin.top-nav')
    <div id="layoutSidenav">
        @include('includes.admin.layout-sidenav')
        @include('includes.admin.layout-side-content')
    </div>


    <!-- File Upload Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Add New Adiministrator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.add-user') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <select class="form-select" name="role" id="adminRoles" required>
                                <option selected disabled>Choose Role</option>
                                <option value="1">Super Admin</option>
                                <option value="2">Regular Admin</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control" name="name" placeholder="admin name" required>
                        </div>
                        <div class="mb-2">
                            <input type="email" class="form-control" name="email" placeholder="yourname@example.com"
                                required>
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-blue">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('includes.admin.footer-script')
    @yield('custom-script');

    @error('email')
        <script>
            toastr.error("{{ $message }}");
        </script>
        {{-- <div class="alert alert-danger">{{ $message }}</div> --}}
    @enderror

</body>

</html>
