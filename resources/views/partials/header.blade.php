    <!-- Topbar Start -->
    <div class="header">
        <div class="main-header">
  
  
          <!-- Sidebar Menu Toggle Button -->
          <a id="mobile_btn" class="mobile_btn" href="#sidebar">
            <span class="bar-icon">
              <span></span>
              <span></span>
              <span></span>
            </span>
          </a>
  
          <div class="header-user">
            <div class="nav user-menu nav-list">
  
              <div class="d-flex align-items-center">

                <!-- User Info & Logout -->
                @auth
                <div class="dropdown">
                  <a href="#" class="dropdown-toggle nav-link d-flex align-items-center" data-bs-toggle="dropdown" style="text-decoration: none;">
                    <span class="user-img me-2">
                      @if(auth()->user()->profile_photo)
                        <img src="{{ asset(auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}" class="rounded-circle" width="35" height="35" style="object-fit: cover;">
                      @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-weight: 600;">
                          {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                      @endif
                    </span>
                    <span class="d-none d-md-inline-flex flex-column align-items-start">
                      <span class="user-name fw-semibold text-dark" style="line-height: 1.2;">{{ auth()->user()->name }}</span>
                      <span class="user-role text-muted" style="font-size: 11px; line-height: 1.2;">
                        @if(auth()->user()->roles->count() > 0)
                          {{ auth()->user()->roles->first()->name }}
                        @else
                          User
                        @endif
                      </span>
                    </span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end">
                    <div class="px-3 py-2 border-bottom">
                      <p class="mb-0 fw-semibold">{{ auth()->user()->name }}</p>
                      <p class="mb-0 text-muted small">{{ auth()->user()->email }}</p>
                    </div>
                    <a class="dropdown-item" href="{{ route('settings') }}">
                      <i class="isax isax-setting me-2"></i>Settings
                    </a>
                    @can('manage_users')
                    <a class="dropdown-item" href="{{ route('users') }}">
                      <i class="isax isax-user me-2"></i>Manage Users
                    </a>
                    @endcan
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                      @csrf
                      <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; width: 100%; text-align: left; cursor: pointer;">
                        <i class="isax isax-logout me-2"></i>Logout
                      </button>
                    </form>
                  </div>
                </div>
                @endauth
  
  
  
  
  
  
  
              </div>
            </div>
          </div>
  
          <!-- /Mobile Menu -->
  
        </div>
      </div>
      <!-- Topbar End -->