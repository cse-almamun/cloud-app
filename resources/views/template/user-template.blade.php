<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.header-script')
</head>

<body>
    @include('includes.user-navabr')
    <div class="container">
        @yield('content')
    </div>

    @include('includes.footer-script')
    @yield('customScript')
    
</body>

</html>
