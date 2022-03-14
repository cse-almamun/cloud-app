<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="mt-3 px-3">
                <button class="btn btn-blue w-100 " data-bs-toggle="modal" data-bs-target="#fileUploadModal"
                    id="globalFileUpBtn"><span class="float-start "><i
                            class="fas fa-arrow-circle-up"></i></span>Upload</button>
            </div>
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="{{ url('/folders') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-folder"></i></div>
                    Folders
                </a>
                <a class="nav-link" href="{{ url('shared-files') }}">
                    <div class="sb-nav-link-icon"><i class="fas fa-share-alt"></i></div>
                    Shared Files
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}
        </div>
    </nav>
</div>
