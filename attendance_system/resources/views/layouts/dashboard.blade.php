{{-- resources/views/layouts/dashboard.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- JS Libraries for Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    {{-- We load BOTH app.js (for core functions) and dashboard.js (for our custom code) --}}
    @vite(['resources/css/dashboard.css', 'resources/js/app.js', 'resources/js/dashboard.js'])

</head>
<body class="font-sans antialiased">

    <div class="dashboard-container" id="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header"><i class="fa-solid fa-bars hamburger-menu"></i></div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fa-solid fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li><a href="{{ route('attendance') }}" class="nav-link {{ request()->routeIs('attendance') ? 'active' : '' }}"><i class="fa-solid fa-calendar-day"></i><span>Today's Attendance</span></a></li>
                    <li><a href="{{ route('employees') }}" class="nav-link {{ request()->routeIs('employees') ? 'active' : '' }}"><i class="fa-solid fa-users"></i><span>Employees</span></a></li>
                    <li><a href="{{ route('reports') }}" class="nav-link {{ request()->routeIs('reports') ? 'active' : '' }}"><i class="fa-solid fa-file-invoice"></i><span>Reports</span></a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header Bar -->
            <header class="main-header">
                <a href="{{ route('dashboard') }}" id="logo-link">
                    <div class="company-info">
                        <img src="{{ asset('images/logo1.png') }}" alt="Company Logo" class="company-logo">
                        <h1 class="company-name">YangKhor Private Limited</h1>
                    </div>
                </a>
                <div class="header-actions">
                    <div class="theme-toggle" id="theme-toggle" title="Toggle dark/light mode"><i class="fa-solid fa-moon"></i><i class="fa-solid fa-sun"></i></div>
                    <div class="dropdown">
                        <div class="dropdown-toggle" id="user-profile-toggle">
                            <i class="fa-regular fa-face-smile"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-caret-down"></i>
                        </div>
                        <ul class="dropdown-menu" id="user-profile-menu">
                            <li><a href="{{ route('profile.show') }}">My Profile</a></li>
                            <li>
                                {{-- A hidden form that we will submit with JavaScript --}}
                                <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                                    @csrf
                                </form>
                                {{-- A simple link that our JavaScript will listen to --}}
                                <a href="{{ route('logout') }}" id="logout-link">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Page Content will be injected here -->
            <div class="dashboard-body">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>