<nav id="sidebar" aria-label="Main Navigation">
  <div class="content-header">
    <a class="fw-semibold text-dual" href="index.html">
      <span class="smini-visible">
        <i class="fa fa-circle-notch text-primary"></i>
      </span>
      <span class="smini-hide fs-5 tracking-wider">EAS</span>
    </a>
    <div class="d-flex align-items-center gap-1">
      <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
        <i class="fa fa-fw fa-times"></i>
      </a>
    </div>
  </div>
  <div class="js-sidebar-scroll simplebar-scrollable-y" data-simplebar="init"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%; overflow: hidden scroll;"><div class="simplebar-content" style="padding: 0px;">
    <div class="content-side">
      <ul class="nav-main">
        <li class="nav-main-item">
          <a class="nav-main-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard_admin') }}">
            <span class="nav-main-link-name">Dashboard</span>
          </a>
        </li>
        <li class="nav-main-heading">EAS</li>
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{ route('admin.ea.domain.show') }}">
            <span class="nav-main-link-name">Komponen</span>
          </a>
        </li>
        <li class="nav-main-item">
          <a class="nav-main-link" href="{{ route('admin.ea.university.show') }}">
            <span class="nav-main-link-name">Universitas</span>
          </a>
        </li>
        <li class="nav-main-heading">Akun</li>
        <li class="nav-main-item">
          <a class="nav-main-link {{ Request::is('admin/account') ? 'active' : '' }}" href="{{ route('admin.account') }}">
            <span class="nav-main-link-name">Akun</span>
          </a>
        </li>
      </ul>
    </div>
  </div></div></div></div><div class="simplebar-placeholder" style="width: 375px; height: 735px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 494px; transform: translate3d(0px, 0px, 0px); display: block;"></div></div></div>
</nav>