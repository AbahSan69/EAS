<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body id="page-container" class="d-flex flex-column min-vh-100">
    @include('sweetalert::alert')
    @yield('content')
    @include('layouts.footer')
    @include('layouts.scripts')
</body>
</html>