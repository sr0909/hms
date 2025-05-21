<!-- Navigation Bar -->
<nav class="navbar custom-navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <div class="d-flex justify-content-between w-100">
            <div class="d-flex align-items-center">
                <!-- Back Button -->
                <button class="btn btn-user p-0" id="btn-back" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Back">
                    <i class="bi bi-arrow-left"></i>
                </button>
            </div>
            <div class="d-flex align-items-center">
                <!-- Username -->
                <label>@if(Auth::check()) {{ Auth::user()->name }} @endif</label>
                <!-- Button of user icon -->
                <button class="btn btn-user p-0 ps-2" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="user-icon"><i class="bi bi-person-fill h3"></i></span>
                </button>
                <!-- Dropdown menu -->
                <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><a class="dropdown-item" href="{{ route('myaccount') }}">My Account</a></li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}">Log Out</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Side Bar -->
<div class="custom-sidebar px-2 py-1">
    <!-- Logo and Title -->
    <div class="d-flex align-items-center ps-0 mb-2">
        <!-- Logo Image -->
        <img src="{{ asset('images/logo-dark-blue-1.png') }}" style="width: 50px;" alt="HMS Logo">
        <!-- Sidebar Title -->
        <h5 class="sidebar-title ms-2 mb-0">HMS</h5>
    </div>
    <!-- Navigation Links -->
    <ul class="navbar-nav flex-column">
        <!-- Dashboard Link -->
        <x-navbar-link
            :href="
                auth()->user()->hasRole('doctor') ? route('doctor.dashboard') :
                (auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') ? route('admin.dashboard') :
                (auth()->user()->hasRole('pharmacist') ? route('pharmacist.dashboard') : route('dashboard')))
            "
            icon="bi bi-house-door-fill"
            :isActive="
                request()->routeIs('dashboard') || 
                request()->routeIs('admin.dashboard') || 
                request()->routeIs('doctor.dashboard') || 
                request()->routeIs('pharmacist.dashboard')
            "
        >
            Dashboard
        </x-navbar-link>

        @if (auth()->user()->hasRole('super admin') || auth()->user()->hasRole('pharmacist'))
        <x-navbar-link href="{{ route('prescriptionapproval') }}" icon="bi bi-prescription2" :isActive="request()->routeIs('prescriptionapproval') OR request()->routeIs('prescriptionapproval.*')">Prescription</x-navbar-link>

        <x-navbar-link href="{{ route('medicine') }}" icon="bi bi-capsule-pill" :isActive="request()->routeIs('medicine.*') OR request()->routeIs('medicine')">Medicine</x-navbar-link>
        @endif

        @if (auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('pharmacist'))
        <x-navbar-link href="{{ route('inventory') }}" icon="bi bi-house-gear-fill" :isActive="request()->routeIs('inventory.*') OR request()->routeIs('inventory')">Inventory</x-navbar-link>
        @endif

        @if (auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') || auth()->user()->hasRole('doctor'))
        <x-navbar-link href="{{ route('patient') }}" icon="bi bi-people-fill" :isActive="request()->routeIs('patient.*') OR request()->routeIs('patient')">Patient</x-navbar-link>
        @endif

        @if (auth()->user()->hasRole('normal user') || auth()->user()->hasRole('doctor'))
        <x-navbar-link href="{{ route('appointment') }}" icon="bi bi-journal-check" :isActive="request()->routeIs('appointment.*') OR request()->routeIs('appointment') OR request()->routeIs('admin.appointment.*')">Appointment</x-navbar-link>

        <x-navbar-link href="{{ route('medicalrecord') }}" icon="bi bi-clipboard2-pulse-fill" :isActive="request()->routeIs('medicalrecord.*') OR request()->routeIs('medicalrecord') OR request()->routeIs('diagnosis.*') OR request()->routeIs('treatment.*') OR request()->routeIs('prescription.*')">Medical Record</x-navbar-link>
        @endif

        @if (auth()->user()->hasRole('pharmacist'))
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle @if(request()->routeIs('masterdata.*')) active @endif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-database-fill"></i>
                Master Data
            </a>
            <ul class="dropdown-menu dropdown-menu-dark custom-dropdown-menu @if(request()->routeIs('masterdata.*')) show @endif">
                <li>
                    <a class="dropdown-item @if(request()->routeIs('masterdata.medicinecategory')) active @endif" href="{{ route('masterdata.medicinecategory') }}">Medicine Category</a>
                </li>
            </ul>
        </li>
        @endif

        @if (auth()->user()->hasRole('super admin'))
        <x-navbar-link href="{{ route('staffmanagement') }}" icon="bi bi-people-fill" :isActive="request()->routeIs('staffmanagement.*') OR request()->routeIs('staffmanagement')">Staff</x-navbar-link>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle @if(request()->routeIs('masterdata.*')) active @endif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-database-fill"></i>
                Master Data
            </a>
            <ul class="dropdown-menu dropdown-menu-dark custom-dropdown-menu @if(request()->routeIs('masterdata.*')) show @endif">
                <li>
                    <a class="dropdown-item @if(request()->routeIs('masterdata.appointmenttime')) active @endif" href="{{ route('masterdata.appointmenttime') }}">Appointment Time</a>
                </li>
                <li>
                    <a class="dropdown-item @if(request()->routeIs('masterdata.country')) active @endif" href="{{ route('masterdata.country') }}">Country</a>
                </li>
                <li>
                    <a class="dropdown-item @if(request()->routeIs('masterdata.department')) active @endif" href="{{ route('masterdata.department') }}">Department</a>
                </li>
                <li>
                    <a class="dropdown-item @if(request()->routeIs('masterdata.medicinecategory')) active @endif" href="{{ route('masterdata.medicinecategory') }}">Medicine Category</a>
                </li>
                <li>
                    <a class="dropdown-item @if(request()->routeIs('masterdata.runningno')) active @endif" href="{{ route('masterdata.runningno') }}">Running Number</a>
                </li>
                <li>
                    <a class="dropdown-item @if(request()->routeIs('masterdata.treatmenttype')) active @endif" href="{{ route('masterdata.treatmenttype') }}">Treatment Type</a>
                </li>
                
                <!-- <li>
                    <hr class="dropdown-divider">
                </li> -->
            </ul>
        </li>
        @endif
    </ul>
</div>