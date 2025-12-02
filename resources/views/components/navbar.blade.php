<div class="sidebar d-lg-block" style="width: 250px; position: fixed; top: 0; left: 0; height: 100vh; z-index: 1000;">
    <div class="p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">
                <i class="bi bi-building"></i> KostKon
            </h4>
            <!-- Hamburger button untuk mobile -->
            <button class="btn btn-link text-white d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                <i class="bi bi-x-lg fs-4"></i>
            </button>
        </div>
        <hr class="bg-light">
        
        <div class="text-center mb-4">
            @if(auth()->user()->profile_photo)
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                     class="rounded-circle" 
                     style="width: 60px; height: 60px; object-fit: cover;" 
                     alt="Profile">
            @else
                <div class="bg-light text-dark rounded-circle d-inline-flex align-items-center justify-content-center" 
                     style="width: 60px; height: 60px;">
                    <i class="bi bi-person-circle fs-1"></i>
                </div>
            @endif
            <p class="mt-2 mb-0"><strong>{{ auth()->user()->name }}</strong></p>
            <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
        </div>

        <hr class="bg-light">

        <nav class="mt-4">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Kelola User
                </a>
                <a href="{{ route('properties.index') }}" class="{{ request()->routeIs('properties.*') ? 'active' : '' }}">
                    <i class="bi bi-building me-2"></i> Kelola Properti
                </a>
                <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                    <i class="bi bi-door-open me-2"></i> Kelola Kamar
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check me-2"></i> Kelola Booking
                </a>
                <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                    <i class="bi bi-graph-up me-2"></i> Laporan
                </a>
                <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle me-2"></i> Profil Admin
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="{{ route('penyewa.rooms.index') }}" class="{{ request()->routeIs('penyewa.rooms.*') ? 'active' : '' }}">
                    <i class="bi bi-search me-2"></i> Cari Kamar
                </a>
                <a href="{{ route('penyewa.profile.edit') }}" class="{{ request()->routeIs('penyewa.profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-circle me-2"></i> Profil Saya
                </a>
            @endif
        </nav>

        <hr class="bg-light mt-4">

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Logout
            </button>
        </form>
    </div>
</div>

<!-- Mobile Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarOffcanvas" style="width: 250px; background: #2c3e50; color: white;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-white">
            <i class="bi bi-building"></i> KostKon
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="p-4">
            <div class="text-center mb-4">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                         class="rounded-circle" 
                         style="width: 60px; height: 60px; object-fit: cover;" 
                         alt="Profile">
                @else
                    <div class="bg-light text-dark rounded-circle d-inline-flex align-items-center justify-content-center mx-auto" 
                         style="width: 60px; height: 60px;">
                        <i class="bi bi-person-circle fs-1"></i>
                    </div>
                @endif
                <p class="mt-2 mb-0 text-white"><strong>{{ auth()->user()->name }}</strong></p>
                <small class="text-white-50">{{ ucfirst(auth()->user()->role) }}</small>
            </div>

            <hr class="bg-light">

            <nav class="mt-4">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" style="color: #ecf0f1; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}" style="color: #ecf0f1; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="bi bi-people me-2"></i> Kelola User
                    </a>
                    <a href="{{ route('properties.index') }}" class="{{ request()->routeIs('properties.*') ? 'active' : '' }}" style="color: #ecf0f1; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="bi bi-building me-2"></i> Kelola Properti
                    </a>
                    <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}" style="color: #ecf0f1; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="bi bi-door-open me-2"></i> Kelola Kamar
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="{{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}" style="color: #ecf0f1; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="bi bi-calendar-check me-2"></i> Kelola Booking
                    </a>
                    <a href="{{ route('admin.reports') }}" class="{{ request()->routeIs('admin.reports') ? 'active' : '' }}" style="color: #ecf0f1; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="bi bi-graph-up me-2"></i> Laporan
                    </a>
                    <a href="{{ route('admin.profile.edit') }}" class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}" style="color: #ecf0f1; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="bi bi-person-circle me-2"></i> Profil Admin
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" style="color: #ecf0f1; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('penyewa.rooms.index') }}" class="{{ request()->routeIs('penyewa.rooms.*') ? 'active' : '' }}" style="color: #ecf0f1; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="bi bi-search me-2"></i> Cari Kamar
                    </a>
                    <a href="{{ route('penyewa.profile.edit') }}" class="{{ request()->routeIs('penyewa.profile.*') ? 'active' : '' }}" style="color: #ecf0f1; text-decoration: none; padding: 12px 20px; display: block;">
                        <i class="bi bi-person-circle me-2"></i> Profil Saya
                    </a>
                @endif
            </nav>

            <hr class="bg-light mt-4">

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Mobile Toggle Button (sticky top) -->
<button class="btn btn-primary d-lg-none position-fixed" 
        type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#sidebarOffcanvas"
        style="top: 15px; left: 15px; z-index: 999; border-radius: 10px;">
    <i class="bi bi-list fs-4"></i>
</button>