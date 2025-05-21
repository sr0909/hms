<nav class="navbar custom-navbar bg-body-tertiary fixed-top">
    <div class="container-fluid d-flex justify-content-end">
        <!-- <a class="navbar-brand" href="#">@yield("navbar-title")</a> -->
        <label>@if(Auth::check()) {{ Auth::user()->name }} @endif</label>
        <button class="btn btn-user p-0 ps-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="user-icon"><i class="bi bi-person-fill h3"></i></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#">My Account</a></li>
            <li><a class="dropdown-item" href="#">Log Out</a></li>
        </ul>
    </div>
</nav>

<div class="custom-sidebar px-2 py-1">    
    <div class="d-flex align-items-center ps-0">
        <img src="{{ asset('images/logo-dark-blue-1.png') }}" style="width: 50px;" alt="HMS Logo">
        <h5 class="sidebar-title ms-2 mb-0">HMS</h5>
    </div>
    <ul class="navbar-nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Appointment</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Prescription</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Medical Record</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Master Data</a>
            <ul class="dropdown-menu dropdown-menu-dark custom-dropdown-menu">
                <li>
                    <a class="dropdown-item" href="#">Department</a>
                </li>
                <li>
                    <a class="dropdown-item" href="#">Another action</a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a class="dropdown-item" href="#">Something else here</a>
                </li>
            </ul>
        </li>
    </ul>
</div>