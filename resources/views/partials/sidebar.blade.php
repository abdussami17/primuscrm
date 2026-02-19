<!-- Sidenav Menu Start -->
<div class="two-col-sidebar" id="two-col-sidebar">
  <div class="twocol-mini">

      <!-- Add -->
      <div class="dropdown">
          <a class="btn btn-primary bg-gradient btn-sm btn-icon rounded-circle d-flex align-items-center justify-content-center"
             data-bs-toggle="dropdown" href="javascript:void(0);" role="button" data-bs-display="static"
             data-bs-reference="parent">
              <i class="isax isax-add"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-start">
              <li>
                  <a href="add-invoice.html" class="dropdown-item d-flex align-items-center">
                      <i class="isax isax-document-text-1 me-2"></i>Invoice
                  </a>
              </li>
              <li>
                  <a href="expenses.html" class="dropdown-item d-flex align-items-center">
                      <i class="isax isax-money-send me-2"></i>Expense
                  </a>
              </li>
              <li>
                  <a href="add-credit-notes.html" class="dropdown-item d-flex align-items-center">
                      <i class="isax isax-money-add me-2"></i>Credit Notes
                  </a>
              </li>
              <li>
                  <a href="add-debit-notes.html" class="dropdown-item d-flex align-items-center">
                      <i class="isax isax-money-recive me-2"></i>Debit Notes
                  </a>
              </li>
              <li>
                  <a href="add-purchases-orders.html" class="dropdown-item d-flex align-items-center">
                      <i class="isax isax-document me-2"></i>Purchase Order
                  </a>
              </li>
              <li>
                  <a href="add-quotation.html" class="dropdown-item d-flex align-items-center">
                      <i class="isax isax-document-download me-2"></i>Quotation
                  </a>
              </li>
              <li>
                  <a href="add-delivery-challan.html" class="dropdown-item d-flex align-items-center">
                      <i class="isax isax-document-forward me-2"></i>Delivery Challan
                  </a>
              </li>
          </ul>
      </div>
      <!-- /Add -->

      <ul class="menu-list">
          <li>
              <a href="account-settings.html" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Settings">
                  <i class="isax isax-setting-25"></i>
              </a>
          </li>
          <li>
              <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Documentation">
                  <i class="isax isax-document-normal4"></i>
              </a>
          </li>
          <li>
              <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Changelog">
                  <i class="isax isax-cloud-change5"></i>
              </a>
          </li>
      </ul>
  </div>

  <div class="sidebar" id="sidebar-two">

      <!-- Search -->
      <div class="sidebar-search">
          <div class="input-icon-end position-relative">
              <input type="text" class="form-control" placeholder="Search">
              <span class="input-icon-addon">
                  <i class="isax isax-search-normal"></i>
              </span>
          </div>
      </div>
      <!-- /Search -->

      <!-- Sidebar Menu -->
      <div class="sidebar-inner" data-simplebar>
          <div class="user-card">
              <div class="avatar" style="cursor: pointer;" onclick="window.location='{{route('users.edit',auth()->user()->id)}}'">
                  <img src="{{auth()->user()->profile_photo ? asset(auth()->user()->profile_photo) : 'https://img.freepik.com/premium-vector/user-profile-icon-circle_1256048-12499.jpg?semt=ais_hybrid&w=740&q=80'}}" alt="User Avatar" />
                  <span class="status-dot"></span>
              </div>
              <div class="user-info">
                  <div class="user-name">{{ auth()->user()->name }}</div>
                  <div class="user-status">{{auth()->user()->roles->first()->name ?? 'User'}}</div>
              </div>
              <div class="notification_item">
                  <a href="#" class="btn btn-menubar position-relative" data-bs-toggle="offcanvas" data-bs-target="#notificationCanvas">
                      <i class="isax isax-notification-bing5"></i>
                      <span class="position-absolute badge bg-success border border-white"></span>
                  </a>
              </div>
          </div>

          <div class="search-area">
           <form action="{{ route('customers.index') }}" method="GET" class="search-box d-flex">
    <i class="ti ti-search"></i>
            <input
        type="text"
        name="search"
        class="form-control form-control-sm bg-white"
        placeholder="Search"
        value="{{ request('search') }}"
    >
</form>

        
            <button data-size="lg"
                    data-url="{{ route('customers.create') }}"
                    data-ajax-popup="true"
                    data-title="New Customers">
                <i class="ti ti-plus"></i><i class="ti ti-user"></i>
            </button>
        </div>
        

          <div id="sidebar-menu" class="sidebar-menu">
              <ul>
                  <li>
                      <ul>
                          @php
                              $sidebarMenus = \App\Helpers\PermissionHelper::getSidebarMenus();
                          @endphp

                          @foreach($sidebarMenus as $menu)
                              @if(\App\Helpers\PermissionHelper::canViewMenu($menu['permission']))
                                  <li class="{{ request()->routeIs($menu['route']) ? 'active' : '' }}">
                                      <a href="{{ route($menu['route']) }}">
                                          <i class="{{ $menu['icon'] }}"></i>
                                          <span>{{ $menu['label'] }}</span>
                                      </a>
                                  </li>
                              @endif
                          @endforeach

                          @php
    $helpMenus = \App\Helpers\PermissionHelper::getHelpSubmenu();

    $helpRoutes = collect($helpMenus)->pluck('route')->map(function ($r) {
        return $r . '*'; // wildcard fix
    })->toArray();

    $isHelpActive = request()->routeIs(...$helpRoutes);

    $canSeeHelpMenu = collect($helpMenus)->contains(function($item) {
        return \App\Helpers\PermissionHelper::canViewMenu($item['permission']);
    });
@endphp

@if($canSeeHelpMenu)
<li class="submenu {{ $isHelpActive ? ' open' : '' }}">
    <a href="#" class="submenu-toggle {{ $isHelpActive ? 'subdrop' : '' }}">

        <i class="ti ti-help-hexagon"></i>
        <span>Help</span>
        <span class="menu-arrow"></span>
    </a>

    <ul class="submenu-list">
        @foreach($helpMenus as $helpMenu)
            @if(\App\Helpers\PermissionHelper::canViewMenu($helpMenu['permission']))
                <li>
                    <a href="{{ route($helpMenu['route']) }}"
                       class="{{ request()->routeIs($helpMenu['route'].'*') ? 'active' : '' }}">
                        {{ $helpMenu['label'] }}
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</li>
@endif

                          <!-- Dark Mode -->
                          <li class="mt-4 mb-0">
                              <a href="javascript:void(0);" class="d-flex justify-content-between align-items-center">
                                  <div>
                                      <i class="ti ti-moon"></i><span>Dark Mode</span>
                                  </div>
                                  <div class="form-check form-switch mb-0">
                                      <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                                  </div>
                              </a>
                          </li>

<li class="mt-2">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="ti ti-logout"></i><span>Logout</span>
    </a>

    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
        @csrf
    </form>
</li>



                      </ul>
                  </li>
              </ul>
          </div>

          <div class="sidebar-logo-footer" style="position: relative !important; display: flex !important; justify-content: center !important; width: 100% !important; margin-top: 20px !important;">
              <img src="{{ asset('assets/light_logo.png') }}" alt="Logo" style="width: auto !important; height: 160px !important; display: block !important; opacity: 1 !important; visibility: visible !important;">
          </div>
      </div>
  </div>
</div>
<!-- Sidenav Menu End -->



