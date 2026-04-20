<!DOCTYPE html>
<html lang="en">
@include('admin.layouts.head')
<body>
  @include('sweetalert::alert')
  <div id="page-container" class="sidebar-o sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow side-trans-enabled"><div id="page-overlay"></div>
    @include('admin.layouts.sidebar')
    @include('admin.layouts.navbar')
    @yield('content')
  </div>
    <script src="{{ asset('oneui/js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('oneui/js/oneui.app.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    One.helpersOnLoad(['core-bootstrap']);
</script>
</body>
</html>