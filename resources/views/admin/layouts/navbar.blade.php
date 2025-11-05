<header id="page-header">
  <div class="content-header">
      @guest
    <div class="d-flex align-items-center">
    </div>
    <div class="d-flex align-items-center">
      <a class="nav-main-link" href="{{ route('register') }}"> <i class="nav-main-link-icon si si-user-follow"></i> <span class="nav-main-link-name">Daftar</span> </a>  
      <a class="nav-main-link" href="{{ route('login') }}"> <i class="nav-main-link-icon si si-login"></i> <span class="nav-main-link-name">Login</span> </a> 
    </div>
    @endguest
    @auth
    <div class="d-flex align-items-center">
    </div>
    <div class="d-flex align-items-center">
      <div class="dropdown d-inline-block ms-2">
        <button type="button" class="btn btn-sm btn-alt-secondary d-flex align-items-center" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img class="rounded-circle" src="{{ asset('oneui/media/avatars/avatar10.jpg') }}" alt="Header Avatar" style="width: 21px;">
          <span class="fs-sm fw-medium">{{ Auth::user()->name }}</span>
          <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0" aria-labelledby="page-header-user-dropdown" style="">
          <div class="p-3 text-center bg-body-light border-bottom rounded-top">
            <img class="img-avatar img-avatar48 img-avatar-thumb" src="{{ asset('oneui/media/avatars/avatar10.jpg') }}" alt="">
            <p class="mt-2 mb-0 fw-medium">{{ Auth::user()->name }}</p>
            <p class="mb-0 text-muted fs-sm fw-medium">{{ Auth::user()->detail_role->role->name }}</p>
          </div>
          <div class="p-2">
            <form action="{{ route('logout') }}" method="POST">
            @csrf
              <button class="dropdown-item d-flex align-items-center justify-content-between" type="submit">
                <span class="fs-sm fw-medium">Log Out</span>
              </button>
            </form>
          </div>
        </div>
      </div>
   @endauth
  </div>
</header>