<div class="sidebar" style="width: 250px;">
    <div class="p-4">
        <h4 class="text-center mb-4">
            <i class="bi bi-building"></i> KostKon
        </h4>
        <hr class="bg-light">
        
        <div class="text-center mb-4">
            <div class="bg-light text-dark rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-person-circle fs-1"></i>
            </div>
            <p class="mt-2 mb-0"><strong>{{ auth()->user()->name }}</strong></p>
            <small class="text-muted">{{ ucfirst(auth()->user()->role) }}</small>
        </div>

        <hr class="bg-light">

        <nav class="mt-4">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
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
            @else
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="{{ route('penyewa.rooms.index') }}" class="{{ request()->routeIs('penyewa.rooms.*') ? 'active' : '' }}">
                    <i class="bi bi-search me-2"></i> Cari Kamar
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