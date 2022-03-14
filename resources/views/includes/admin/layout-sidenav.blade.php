<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            @if (Auth::guard('admin')->user()->role === 1)
                <div class="mt-3 px-3">
                    <button class="btn btn-blue w-100 " data-bs-toggle="modal" data-bs-target="#createUserModal"
                        id="createAdminUser"><span class="float-start "><i class="fas fa-user-plus"></i></span>Add
                        User</button>
                </div>
            @endif

            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                @if (Auth::guard('admin')->user()->role === 1)
                    <a class="nav-link" href="{{ route('admin.employee') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                        Admin Employee
                    </a>
                @endif

                <a class="nav-link" href="{{ route('admin.users') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                    Debug User
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as: Almamun</div>

        </div>
    </nav>
</div>
