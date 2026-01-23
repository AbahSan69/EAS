<header id="page-header">
  <div class="content-header">
   <div class="d-flex align-items-center">
    <span class="fs-sm fw-medium"">Enterprise Architecture</span>  
   </div>
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

    {{-- 🔔 NOTIFICATION COMMENT --}}
    @php
    $totalUnread = $commentNotifications->sum('unread_comments_count');
@endphp

<div class="dropdown d-inline-block ms-2">
    <button type="button"
        class="btn btn-sm btn-alt-secondary position-relative"
        data-bs-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false">
        <i class="fa fa-bell"></i>

        @if($totalUnread > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $totalUnread }}
            </span>
        @endif
    </button>

    <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0"
         style="width:340px">

        <div class="p-3 fw-bold border-bottom bg-body-light">
            Komentar Baru
        </div>

        <div class="list-group list-group-flush">
            @forelse($commentNotifications as $content)
                @if($content->unread_comments_count > 0)
                    <a href="{{ route(
                        'sp.ea.component_show',
                        $content->detail?->component?->id
                    ) }}"
                       class="list-group-item list-group-item-action">

                        <div class="fs-sm fw-bold">
                            {{ $content->detail?->component?->name ?? 'Komponen' }}
                        </div>

                        <div class="fs-xs text-muted">
                          {{ $content->detail?->component?->subdomain?->domain?->name ?? '-' }}
                          →
                          {{ $content->detail?->component?->subdomain?->name ?? '-' }}
                      </div>

                        <div class="fs-xs text-muted">
                            {{ $content->unread_comments_count }} komentar baru
                        </div>
                    </a>
                @endif
            @empty
                <div class="p-3 text-center text-muted fs-sm">
                    Tidak ada komentar baru
                </div>
            @endforelse
        </div>
    </div>
</div>


    {{-- 👤 USER DROPDOWN (ASLI PUNYAMU, TIDAK DIUBAH) --}}
    <div class="dropdown d-inline-block ms-2">
        <button type="button"
            class="btn btn-sm btn-alt-secondary d-flex align-items-center"
            id="page-header-user-dropdown"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false">
            <img class="rounded-circle"
                 src="{{ asset('oneui/media/avatars/avatar10.jpg') }}"
                 alt="Header Avatar"
                 style="width: 21px;">
            <span class="fs-sm fw-medium">
                {{ Auth::user()->detail_role->name }}
            </span>
            <i class="fa fa-fw fa-angle-down d-none d-sm-inline-block opacity-50 ms-1 mt-1"></i>
        </button>

        <div class="dropdown-menu dropdown-menu-md dropdown-menu-end p-0 border-0">
            <div class="p-3 text-center bg-body-light border-bottom rounded-top">
                <img class="img-avatar img-avatar48 img-avatar-thumb"
                     src="{{ asset('oneui/media/avatars/avatar10.jpg') }}"
                     alt="">
                <p class="mt-2 mb-0 fw-medium">{{ Auth::user()->name }}</p>
                <small class="mb-0 text-muted fs-sm fw-medium">
                    ({{ Auth::user()->detail_role->university->name }})
                </small>
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

</div>
@endauth

  </div>
</header>