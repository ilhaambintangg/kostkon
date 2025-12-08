<!-- Desktop Sidebar -->
<div class="sidebar d-lg-block" style="width: 250px; position: fixed; top: 0; left: 0; height: 100vh; z-index: 1030; background: linear-gradient(180deg, #1f2937 0%, #111827 100%);">
    <div class="p-4 d-flex flex-column h-100">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center gap-2">
                <div style="width: 40px; height: 40px; background: #4361ee; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-building fs-5 text-white"></i>
                </div>
                <h4 class="mb-0 fw-bold text-white">KostKon</h4>
            </div>
            <button class="btn btn-link text-white d-lg-none p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                <i class="bi bi-x-lg fs-4"></i>
            </button>
        </div>
        
        <hr class="bg-light mb-4">
        
        <!-- User Info -->
        <div class="text-center mb-4">
            @if(auth()->user()->profile_photo)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                     class="rounded-circle border border-3 border-primary" 
                     style="width: 80px; height: 80px; object-fit: cover;" 
                     alt="Profile">
            @else
                <div class="rounded-circle border border-3 border-primary d-inline-flex align-items-center justify-content-center" 
                     style="width: 80px; height: 80px; background: linear-gradient(135deg, #4361ee, #3f37c9);">
                    <i class="bi bi-person-circle fs-1 text-white"></i>
                </div>
            @endif
            <p class="mt-3 mb-0 fw-bold text-white">{{ auth()->user()->name }}</p>
            <span class="badge bg-primary px-3 py-1 mt-1" style="font-size: 0.8rem; border-radius: 20px;">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>

        <hr class="bg-light mb-4">

        <!-- Navigation Menu -->
        <nav class="flex-grow-1">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-3"></i> Kelola User
                </a>
                <a href="{{ route('properties.index') }}" class="nav-item {{ request()->routeIs('properties.*') ? 'active' : '' }}">
                    <i class="bi bi-building me-3"></i> Kelola Properti
                </a>
                <a href="{{ route('rooms.index') }}" class="nav-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                    <i class="bi bi-door-open me-3"></i> Kelola Kamar
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check me-3"></i> Kelola Booking
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <i class="bi bi-graph-up me-3"></i> Laporan
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle me-3"></i> Profil Admin
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-3"></i> Dashboard
                </a>
                <a href="{{ route('penyewa.rooms.index') }}" class="nav-item {{ request()->routeIs('penyewa.rooms.*') ? 'active' : '' }}">
                    <i class="bi bi-search me-3"></i> Cari Kamar
                </a>
                <a href="{{ route('penyewa.profile.edit') }}" class="nav-item {{ request()->routeIs('penyewa.profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle me-3"></i> Profil Saya
                </a>
            @endif
        </nav>

        <!-- Logout Button -->
        <div class="mt-auto pt-3 border-top border-dark">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100" style="border-radius: 10px; padding: 12px;">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Mobile Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarOffcanvas" style="width: 250px; background: linear-gradient(180deg, #1f2937 0%, #111827 100%); color: white; z-index: 1045;">
    <div class="offcanvas-header border-bottom border-dark">
        <div class="d-flex align-items-center gap-2">
            <div style="width: 40px; height: 40px; background: #4361ee; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i class="bi bi-building fs-5 text-white"></i>
            </div>
            <h5 class="offcanvas-title fw-bold text-white mb-0">KostKon</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0 d-flex flex-column h-100">
        <div class="p-4">
            <!-- User Info -->
            <div class="text-center mb-4">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                         class="rounded-circle border border-3 border-primary" 
                         style="width: 70px; height: 70px; object-fit: cover;" 
                         alt="Profile">
                @else
                    <div class="rounded-circle border border-3 border-primary d-inline-flex align-items-center justify-content-center mx-auto" 
                         style="width: 70px; height: 70px; background: linear-gradient(135deg, #4361ee, #3f37c9);">
                        <i class="bi bi-person-circle fs-1 text-white"></i>
                    </div>
                @endif
                <p class="mt-3 mb-0 fw-bold text-white">{{ auth()->user()->name }}</p>
                <span class="badge bg-primary px-3 py-1 mt-1" style="font-size: 0.75rem; border-radius: 20px;">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>

            <hr class="bg-light mb-4">

            <!-- Mobile Menu -->
            <nav>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                        <i class="bi bi-speedometer2 me-3"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="mobile-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                        <i class="bi bi-people me-3"></i> Kelola User
                    </a>
                    <a href="{{ route('properties.index') }}" class="mobile-nav-item {{ request()->routeIs('properties.*') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                        <i class="bi bi-building me-3"></i> Kelola Properti
                    </a>
                    <a href="{{ route('rooms.index') }}" class="mobile-nav-item {{ request()->routeIs('rooms.*') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                        <i class="bi bi-door-open me-3"></i> Kelola Kamar
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="mobile-nav-item {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                        <i class="bi bi-calendar-check me-3"></i> Kelola Booking
                    </a>
                    <a href="{{ route('admin.reports') }}" class="mobile-nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                        <i class="bi bi-graph-up me-3"></i> Laporan
                    </a>
                    <a href="{{ route('admin.profile.edit') }}" class="mobile-nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                        <i class="bi bi-person-circle me-3"></i> Profil Admin
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                        <i class="bi bi-speedometer2 me-3"></i> Dashboard
                    </a>
                    <a href="{{ route('penyewa.rooms.index') }}" class="mobile-nav-item {{ request()->routeIs('penyewa.rooms.*') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                        <i class="bi bi-search me-3"></i> Cari Kamar
                    </a>
                    <a href="{{ route('penyewa.profile.edit') }}" class="mobile-nav-item {{ request()->routeIs('penyewa.profile.*') ? 'active' : '' }}" data-bs-dismiss="offcanvas">
                        <i class="bi bi-person-circle me-3"></i> Profil Saya
                    </a>
                @endif
                
                <!-- Logout Mobile -->
                <div class="mt-4 pt-3 border-top border-dark">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100" style="border-radius: 10px; padding: 12px;">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </nav>
        </div>
    </div>
</div>

<!-- Mobile Toggle Button -->
<button class="btn btn-primary d-lg-none position-fixed" 
        type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#sidebarOffcanvas"
        style="top: 15px; left: 15px; z-index: 1040; border-radius: 10px; background: #4361ee; border: none; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);">
    <i class="bi bi-list fs-5 text-white"></i>
</button>

<style>
    /* Style untuk item navigasi */
    .nav-item {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: #e2e8f0;
        text-decoration: none;
        border-radius: 10px;
        margin: 4px 0;
        transition: all 0.3s ease;
    }

    .nav-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .nav-item.active {
        background: rgba(67, 97, 238, 0.2);
        color: white;
        font-weight: 500;
    }

    /* Style untuk mobile nav items */
    .mobile-nav-item {
        display: flex;
        align-items: center;
        padding: 14px 20px;
        color: #e2e8f0;
        text-decoration: none;
        border-radius: 10px;
        margin: 4px 0;
        transition: all 0.3s ease;
    }

    .mobile-nav-item:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .mobile-nav-item.active {
        background: rgba(67, 97, 238, 0.2);
        color: white;
        font-weight: 500;
    }

    /* Responsive sidebar untuk mobile */
    @media (max-width: 991.98px) {
        .sidebar {
            left: -260px !important;
            transition: left 0.3s ease;
        }
        
        .sidebar.show {
            left: 0 !important;
        }
    }

    /* Fix z-index untuk Bootstrap components */
    .modal {
        z-index: 1060 !important;
    }
    
    .modal-backdrop {
        z-index: 1055 !important;
    }
    
    .dropdown-menu {
        z-index: 1060 !important;
    }
    
    .offcanvas {
        z-index: 1045 !important;
    }
    
    .offcanvas-backdrop {
        z-index: 1040 !important;
    }
</style>

<script>
    // Toggle sidebar untuk mobile
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        sidebar.classList.toggle('show');
        
        if (sidebar.classList.contains('show')) {
            overlay.style.display = 'block';
            setTimeout(() => {
                overlay.style.opacity = '1';
            }, 10);
        } else {
            overlay.style.opacity = '0';
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 300);
        }
    }

    // Close sidebar when window is resized to desktop size
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                overlay.style.display = 'none';
            }
        }
    });
</script>