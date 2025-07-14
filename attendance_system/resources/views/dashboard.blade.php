<x-app-layout>
    <!-- Head Content: External Libraries and Custom Styles -->
    <!-- Note: In a production app, you might move these to your main layout file or asset bundling process (Vite). -->

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- JS Libraries for PDF & Excel/CSV Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <style>
        /* CSS Variables for easy themeing */
        :root {
            --primary-color: #1abc9c;
            --sidebar-bg: #2d3e50;
            --sidebar-active-bg: #253241;
            --body-bg: #f4f6f9;
            --card-bg: #ffffff;
            --text-light: #ecf0f1;
            --text-dark: #34495e;
            --border-color: #e3e3e3;
            --shadow-color: rgba(0, 0, 0, 0.1);

            /* Stat Card Colors */
            --color-present: #2ecc71;
            --color-absent: #e74c3c;
            --color-leave: #f39c12;
            --color-late: #9b59b6;
            --color-employees: #3498db;
        }

        body.dark-mode {
            --sidebar-bg: #1f2937;
            --sidebar-active-bg: #111827;
            --body-bg: #111827;
            --card-bg: #1f2937;
            --text-light: #1f2937;
            --text-dark: #d1d5db;
            --border-color: #374151;
            --shadow-color: rgba(0, 0, 0, 0.4);
        }

        /* General Reset & Body Styles */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; }
        /* The body styles below are part of the component and will work within the Laravel app's body */
        body { background-color: var(--body-bg) !important; color: var(--text-dark); overflow-x: hidden; transition: background-color 0.3s ease, color 0.3s ease; }
        .dashboard-container { display: flex; min-height: 100vh; transition: margin-left 0.3s ease; }

        /* --- Sidebar --- */
        .sidebar { width: 250px; background-color: var(--sidebar-bg); color: var(--text-light); display: flex; flex-direction: column; position: fixed; height: 100%; transition: width 0.3s ease, background-color 0.3s ease; z-index: 1001; }
        .sidebar-header { padding: 20px; text-align: right; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        body.dark-mode .sidebar-header { border-bottom: 1px solid var(--border-color); }
        .sidebar-header .hamburger-menu { font-size: 1.5rem; cursor: pointer; width: 100%; text-align: right; color: var(--text-light); }
        body.dark-mode .sidebar-header .hamburger-menu { color: var(--text-dark); }
        .sidebar-nav ul { list-style: none; }
        .sidebar-nav ul li a { display: flex; align-items: center; padding: 15px 20px; color: var(--text-light); text-decoration: none; transition: background-color 0.2s ease, padding-left 0.2s ease; font-size: 0.95rem; white-space: nowrap; }
        body.dark-mode .sidebar-nav ul li a { color: var(--text-dark); }
        .sidebar-nav ul li a .fa-solid { margin-right: 15px; width: 20px; text-align: center; }
        .sidebar-nav ul li a:hover { background-color: var(--sidebar-active-bg); padding-left: 25px; }
        .sidebar-nav ul li a.active { background-color: var(--primary-color); font-weight: bold; color: white; }
        .sidebar-collapsed .sidebar { width: 80px; }
        .sidebar-collapsed .sidebar .sidebar-nav ul li a span { display: none; }
        .sidebar-collapsed .sidebar .sidebar-nav ul li a { justify-content: center; padding: 15px 10px;}
        .sidebar-collapsed .sidebar .sidebar-nav ul li a:hover { padding-left: 10px; }
        .sidebar-collapsed .main-content { margin-left: 80px; }

        /* --- Main Content --- */
        .main-content { flex-grow: 1; display: flex; flex-direction: column; margin-left: 250px; width: calc(100% - 250px); transition: margin-left 0.3s ease, width 0.3s ease; }
        .main-header { display: flex; justify-content: space-between; align-items: center; padding: 12px 25px; background-color: var(--primary-color); color: white; box-shadow: 0 2px 4px var(--shadow-color); position: sticky; top: 0; z-index: 1000; }
        
        #logo-link { text-decoration: none; color: white; }
        .company-info { display: flex; align-items: center; gap: 12px; }
        .company-logo { height: 40px; width: 40px; border-radius: 50%; object-fit: cover; background-color: white; }
        .company-name { font-size: 1.4rem; font-weight: 500; margin: 0; }
        .header-actions { display: flex; align-items: center; gap: 20px; position: relative; }
        .theme-toggle { cursor: pointer; font-size: 1.2rem; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; color: rgba(255, 255, 255, 0.8); }
        .theme-toggle .fa-sun { display: none; }
        body.dark-mode .theme-toggle .fa-moon { display: none; }
        body.dark-mode .theme-toggle .fa-sun { display: block; }
        .dropdown { position: relative; display: flex; align-items: center; }
        .dropdown-toggle { cursor: pointer; display: flex; align-items: center; gap: 8px; }
        .dropdown-menu { display: none; position: absolute; top: 150%; right: 0; background-color: var(--card-bg); color: var(--text-dark); border-radius: 5px; box-shadow: 0 5px 15px var(--shadow-color); z-index: 1001; min-width: 160px; list-style: none; overflow: hidden; border: 1px solid var(--border-color); }
        .dropdown-menu a { padding: 12px 18px; display: block; text-decoration: none; color: var(--text-dark); }
        .dropdown-menu a:hover { background-color: var(--body-bg); }
        .dropdown-menu.show { display: block; }
        .user-profile .fa-face-smile { font-size: 1.5rem; color: rgba(255, 255, 255, 0.8); }

        /* --- Dashboard Body & Pages --- */
        .dashboard-body { padding: 25px; flex-grow: 1; }
        .content-page { display: none; }
        .content-page.active { display: block; animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .dashboard-body h2 { font-size: 1.8rem; margin-bottom: 5px; font-weight: 500; }
        .dashboard-body h3.page-subtitle { font-size: 1rem; margin-bottom: 20px; font-weight: 400; color: #777; }
        body.dark-mode .dashboard-body h3.page-subtitle { color: #9ca3af; }

        /* --- Stats Grid --- */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { color: white; padding: 20px; border-radius: 8px; position: relative; overflow: hidden; box-shadow: 0 4px 8px var(--shadow-color); }
        .stat-card .stat-number { font-size: 3rem; font-weight: bold; }
        .stat-card .stat-label { font-size: 1rem; margin-bottom: 15px; }
        .stat-card .stat-link { display: block; text-align: center; padding: 8px; background-color: rgba(0,0,0,0.15); color: white; text-decoration: none; border-radius: 4px; transition: background-color 0.2s; font-size: 0.9rem; cursor: pointer; }
        .stat-card .stat-link:hover { background-color: rgba(0,0,0,0.3); }
        .stat-card .bg-icon { position: absolute; right: 15px; top: 15px; font-size: 4rem; opacity: 0.2; transform: rotate(-15deg); }
        .stat-card.present { background-color: var(--color-present); }
        .stat-card.absent { background-color: var(--color-absent); }
        .stat-card.on-leave { background-color: var(--color-leave); }
        .stat-card.late { background-color: var(--color-late); }
        .stat-card.employees { background-color: var(--color-employees); }

        /* --- General Panels & Tables --- */
        .content-row { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }
        .panel { background-color: var(--card-bg); border-radius: 8px; padding: 20px; box-shadow: 0 2px 5px var(--shadow-color); transition: background-color 0.3s ease; }
        .activity-table { width: 100%; border-collapse: collapse; }
        .activity-table th, .activity-table td { padding: 12px 10px; text-align: left; border-bottom: 1px solid var(--border-color); font-size: 0.9rem; }
        .activity-table th { font-weight: 600; color: #777; }
        body.dark-mode .activity-table th { color: #9ca3af; }
        .status-badge { padding: 4px 10px; border-radius: 12px; font-size: 0.8rem; color: white; font-weight: 500; }
        .status-on-time { background-color: var(--color-present); }
        .status-late { background-color: var(--color-late); }
        .status-checkout { background-color: #7f8c8d; }
        .status-absent { background-color: var(--color-absent); }
        .status-on-leave { background-color: var(--color-leave); }
        .filter-container { display: flex; gap: 15px; margin-bottom: 20px; flex-wrap: wrap; }
        .filter-container input, .filter-container select { padding: 8px 12px; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--body-bg); color: var(--text-dark); font-size: 0.9rem; }
        .filter-container input { flex-grow: 1; min-width: 200px; }
        .no-records { display: none; text-align: center; color: #777; }
        .no-records td { padding: 30px; font-style: italic; }
        body.dark-mode .no-records { color: #9ca3af; }
        .action-buttons { display: flex; gap: 10px; }
        .action-btn { border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.8rem; color: white; text-decoration: none; display: inline-block; text-align: center; }
        .action-btn.view { background-color: var(--color-employees); }
        .action-btn.edit { background-color: #7f8c8d; }
        .action-btn.view:hover { background-color: #2980b9; }
        .action-btn.edit:hover { background-color: #6c7a7b; }

        /* --- Report Page Specific Styles --- */
        .report-controls { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px; }
        .report-actions button { background-color: var(--primary-color); color: white; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px; transition: background-color 0.2s; }
        .report-actions button:hover { background-color: #16a085; }
        .report-actions button:disabled { background-color: #95a5a6; cursor: not-allowed; }
        #report-placeholder { padding: 40px; text-align: center; color: #95a5a6; font-size: 1.1rem; border: 2px dashed var(--border-color); border-radius: 8px; }
        #report-content { display: none; } /* Hidden by default */
        .report-summary-row { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; margin-bottom: 20px; }
        .pie-chart-container { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px; }
        .pie-chart { width: 150px; height: 150px; border-radius: 50%; } /* Gradient will be set by JS */
        .chart-legend { list-style: none; width: 100%; padding-left: 20px;}
        .chart-legend li { display: flex; align-items: center; margin-bottom: 8px; font-size: 0.9rem; }
        .legend-color { width: 12px; height: 12px; border-radius: 2px; margin-right: 10px; }
        .progress-bar { width: 100px; background-color: var(--border-color); border-radius: 5px; overflow: hidden; height: 12px; }
        .progress-bar-fill { height: 100%; background-color: var(--color-absent); border-radius: 5px; text-align: center; color: white; font-size: 0.7rem; line-height: 12px; transition: width 0.5s ease-out; }

        @media (max-width: 992px) { .content-row, .report-summary-row { grid-template-columns: 1fr; } }
        @media (max-width: 768px) { .company-name { display: none; } .report-controls { flex-direction: column; align-items: stretch; } }
    </style>

    <!-- Main Dashboard HTML Structure -->
    <div class="dashboard-container" id="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header"><i class="fa-solid fa-bars hamburger-menu"></i></div>
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="#" class="nav-link active" data-page="dashboard"><i class="fa-solid fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li><a href="#" class="nav-link" data-page="attendance"><i class="fa-solid fa-calendar-day"></i><span>Today's Attendance</span></a></li>
                    <li><a href="#" class="nav-link" data-page="employees"><i class="fa-solid fa-users"></i><span>Employees</span></a></li>
                    <li><a href="#" class="nav-link" data-page="reports"><i class="fa-solid fa-file-invoice"></i><span>Reports</span></a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Header Bar -->
            <header class="main-header">
                <a href="#" id="logo-link">
                    <div class="company-info">
                        <!-- Note: You may want to make this image path dynamic using Laravel's asset() helper -->
                        <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="company-logo">
                        <h1 class="company-name">YangKhor Private Limited</h1>
                    </div>
                </a>
                <div class="header-actions">
                    <div class="theme-toggle" id="theme-toggle" title="Toggle dark/light mode"><i class="fa-solid fa-moon"></i><i class="fa-solid fa-sun"></i></div>
                    <div class="dropdown">
                        <!-- Display authenticated user's name -->
                        <div class="dropdown-toggle" id="user-profile-toggle"><i class="fa-regular fa-face-smile"></i><span>{{ Auth::user()->name ?? 'Guest User' }}</span><i class="fa-solid fa-caret-down"></i></div>
                        <ul class="dropdown-menu" id="user-profile-menu">
                            <li><a href="#" id="profile-link">My Profile</a></li>
                            <!-- Logout Form for CSRF Protection -->
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();"
                                       id="logout-link">
                                        Logout
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Dashboard Body -->
            <div class="dashboard-body">
                
                <!-- Page: Dashboard -->
                <div id="dashboard-page" class="content-page active">
                    <h2>Dashboard</h2>
                     <div class="stats-grid">
                        <div class="stat-card present"><div class="stat-number" id="stat-present">0</div><div class="stat-label">Present Today</div><i class="fa-solid fa-user-check bg-icon"></i><a class="stat-link" data-page="attendance" data-filter="present">View All →</a></div>
                        <div class="stat-card absent"><div class="stat-number" id="stat-absent">0</div><div class="stat-label">Absent Today</div><i class="fa-solid fa-user-xmark bg-icon"></i><a class="stat-link" data-page="attendance" data-filter="absent">View All →</a></div>
                        <div class="stat-card on-leave"><div class="stat-number" id="stat-leave">0</div><div class="stat-label">On Leave</div><i class="fa-solid fa-plane bg-icon"></i><a class="stat-link" data-page="attendance" data-filter="leave">View All →</a></div>
                        <div class="stat-card late"><div class="stat-number" id="stat-late">0</div><div class="stat-label">Late Comers</div><i class="fa-solid fa-user-clock bg-icon"></i><a class="stat-link" data-page="attendance" data-filter="late">View All →</a></div>
                        <div class="stat-card employees"><div class="stat-number" id="stat-employees">0</div><div class="stat-label">Total Employees</div><i class="fa-solid fa-users bg-icon"></i><a class="stat-link" data-page="employees">View All →</a></div>
                    </div>
                    <div class="content-row">
                        <div class="panel">
                             <div class="panel-header"><h3>Recent Activity</h3><i id="refresh-activity" class="fa-solid fa-arrows-rotate"></i></div>
                             <table class="activity-table"><tbody id="recent-activity-body"></tbody></table>
                        </div>
                        <div class="panel">
                             <div class="panel-header"><h3>Today's Status</h3></div>
                             <div class="pie-chart-container">
                                <div id="dashboard-pie-chart" class="pie-chart"></div>
                                <ul id="dashboard-chart-legend" class="chart-legend"></ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page: Today's Attendance -->
                <div id="attendance-page" class="content-page">
                    <h2>Today's Attendance</h2>
                    <h3 id="current-date-display" class="page-subtitle"></h3>
                    <div class="panel">
                         <div class="filter-container">
                            <input type="search" id="attendance-search-input" placeholder="Search by employee name...">
                            <select id="attendance-status-filter">
                                <option value="all">All Statuses</option><option value="present">Present</option><option value="late">Late</option><option value="absent">Absent</option><option value="leave">On Leave</option>
                            </select>
                        </div>
                        <table class="activity-table">
                            <thead><tr><th>Employee</th><th>Check-in</th><th>Check-out</th><th>Status</th></tr></thead>
                            <tbody id="attendance-table-body"></tbody>
                             <tr class="no-records"><td colspan="4">No records found.</td></tr>
                        </table>
                    </div>
                </div>
                
                <!-- Page: Employees -->
                <div id="employees-page" class="content-page">
                    <h2>Employee Directory</h2>
                    <h3 class="page-subtitle">View and manage employee details.</h3>
                    <div class="panel">
                        <div class="filter-container"><input type="search" id="employee-search-input" placeholder="Search by name, ID, position, or department..."></div>
                        <table class="activity-table">
                            <thead><tr><th>Employee ID</th><th>Name</th><th>Position</th><th>Department</th><th>Email</th><th>Actions</th></tr></thead>
                            <tbody id="employee-table-body"></tbody>
                            <tr class="no-records"><td colspan="6">No employees found.</td></tr>
                        </table>
                    </div>
                </div>

                <!-- Page: Reports -->
                <div id="reports-page" class="content-page">
                    <h2>Attendance Reports</h2>
                    <h3 class="page-subtitle">Generate and download monthly attendance summaries.</h3>
                    <div class="panel">
                        <div class="report-controls">
                            <div class="filter-container" style="margin-bottom: 0;">
                                <label for="month-select" style="align-self: center;">Select Month:</label>
                                <select id="month-select">
                                    <option value="">-- Please choose a month --</option>
                                </select>
                            </div>
                            <div class="report-actions">
                                <button id="export-pdf" disabled><i class="fa-solid fa-file-pdf"></i> PDF</button>
                                <button id="export-excel" disabled><i class="fa-solid fa-file-excel"></i> Excel</button>
                                <button id="export-csv" disabled><i class="fa-solid fa-file-csv"></i> CSV</button>
                            </div>
                        </div>
                        <hr style="border: none; border-top: 1px solid var(--border-color); margin: 20px 0;">
                        <div id="report-placeholder">
                            <i class="fa-solid fa-calendar-week fa-2x" style="margin-bottom: 10px;"></i>
                            <p>Select a month to generate a report.</p>
                        </div>
                        <div id="report-content">
                            <div class="report-summary-row">
                                <div class="panel"><h3 style="margin-bottom:15px; text-align:center;">Monthly Summary Chart</h3><div class="pie-chart-container"><div id="report-pie-chart" class="pie-chart"></div><ul id="report-chart-legend" class="chart-legend"></ul></div></div>
                                <div class="panel"><h3 style="margin-bottom:15px;">Key Statistics</h3><ul id="report-key-stats" class="chart-legend" style="padding-left:0;"></ul></div>
                            </div>
                            <h3 style="margin-top: 20px; margin-bottom: 15px;">Employee Breakdown</h3>
                            <table class="activity-table" id="report-table">
                                <thead><tr><th>Employee</th><th>Present</th><th>Absent</th><th>On Leave</th><th>Absenteeism %</th></tr></thead><tbody id="report-table-body"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- PROFILE PAGE -->
                <div id="profile-page" class="content-page">
                    <h2>My Profile</h2>
                    <h3 class="page-subtitle">View your account details.</h3>
                    <div class="panel">
                        <p><strong>Name:</strong> {{ Auth::user()->name ?? 'Guest User' }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email ?? 'guest@example.com' }}</p>
                        <p><strong>Role:</strong> Administrator</p>
                        <hr style="border: none; border-top: 1px solid var(--border-color); margin: 20px 0;">
                        <p><em>(This is a demonstration page. In a real application, this could contain editable fields and more details.)</em></p>
                    </div>
                </div>

            </div>
        </main>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- Element Selection ---
    const dashboardContainer = document.getElementById('dashboard-container');
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const navLinks = document.querySelectorAll('.nav-link');
    const contentPages = document.querySelectorAll('.content-page');
    const statLinks = document.querySelectorAll('.stat-link');
    const themeToggle = document.getElementById('theme-toggle');
    const logoLink = document.getElementById('logo-link');
    const profileLink = document.getElementById('profile-link');
    // Note: The logout link is now a form submission, so its specific JS logic is removed.

    // --- Sidebar & Theme Toggles ---
    hamburgerMenu.addEventListener('click', () => dashboardContainer.classList.toggle('sidebar-collapsed'));
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') document.body.classList.add('dark-mode');
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
    });

    // --- Page Navigation Logic ---
    function showPage(pageId) {
        contentPages.forEach(page => page.classList.remove('active'));
        const targetPage = document.getElementById(`${pageId}-page`);
        if (targetPage) targetPage.classList.add('active');
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.dataset.page === pageId) link.classList.add('active');
        });
        document.getElementById('user-profile-menu').classList.remove('show');
    }

    navLinks.forEach(link => {
        link.addEventListener('click', (e) => { e.preventDefault(); showPage(link.dataset.page); });
    });
    
    logoLink.addEventListener('click', (e) => { e.preventDefault(); showPage('dashboard'); });

    statLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const pageId = link.dataset.page;
            const filter = link.dataset.filter;
            showPage(pageId);
            if (pageId === 'attendance' && filter) {
                const attendanceFilter = document.getElementById('attendance-status-filter');
                const searchInput = document.getElementById('attendance-search-input');
                if (attendanceFilter) {
                    searchInput.value = '';
                    attendanceFilter.value = filter;
                    attendanceFilter.dispatchEvent(new Event('change'));
                }
            }
        });
    });

    profileLink.addEventListener('click', (e) => { 
        e.preventDefault(); 
        showPage('profile'); 
    });

    // --- DYNAMIC DATA FROM LARAVEL CONTROLLER ---
    const allEmployees = @json($employees);
    const dailyAttendanceData = @json($todaysAttendance);
     const recentActivityData = @json($recentActivity);

    // --- RENDER DYNAMIC PAGES ---
    function renderEmployeesPage() {
        const tableBody = document.getElementById('employee-table-body');
        tableBody.innerHTML = employeeList.map(emp => `
            <tr><td>${emp.id}</td><td>${emp.name}</td><td>${emp.position}</td><td>${emp.department}</td><td>${emp.email}</td>
                <td><div class="action-buttons"><a href="#" class="action-btn view">View</a><a href="#" class="action-btn edit">Edit</a></div></td></tr>`
        ).join('');
    }

    function renderAttendancePage() {
        const tableBody = document.getElementById('attendance-table-body');
        document.getElementById('current-date-display').textContent = new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        tableBody.innerHTML = dailyAttendanceData.map(emp => {
            let badgeClass = 'status-on-time';
            if (emp.status === 'late') badgeClass = 'status-late';
            else if (emp.status === 'absent') badgeClass = 'status-absent';
            else if (emp.status === 'leave') badgeClass = 'status-on-leave';
            return `<tr data-status="${emp.status}"><td>${emp.name}</td><td>${emp.checkIn}</td><td>${emp.checkOut}</td>
            <td><span class="status-badge ${badgeClass}">${emp.status.charAt(0).toUpperCase() + emp.status.slice(1)}</span></td></tr>`;
        }).join('');
    }
    
    function renderDashboard() {
        const present = dailyAttendanceData.filter(e => e.status === 'present' || e.status === 'late').length;
        const absent = dailyAttendanceData.filter(e => e.status === 'absent').length;
        const onLeave = dailyAttendanceData.filter(e => e.status === 'leave').length;
        const late = dailyAttendanceData.filter(e => e.status === 'late').length;
        document.getElementById('stat-present').textContent = present;
        document.getElementById('stat-absent').textContent = absent;
        document.getElementById('stat-leave').textContent = onLeave;
        document.getElementById('stat-late').textContent = late;
        document.getElementById('stat-employees').textContent = employeeList.length;
        
        const totalForChart = present + absent + onLeave;
        const presentPercent = totalForChart > 0 ? ((present - late) / totalForChart) * 100 : 0;
        const latePercent = totalForChart > 0 ? (late / totalForChart) * 100 : 0;
        const absentPercent = totalForChart > 0 ? (absent / totalForChart) * 100 : 0;
        document.getElementById('dashboard-pie-chart').style.background = `conic-gradient(var(--color-present) 0% ${presentPercent}%, var(--color-late) ${presentPercent}% ${presentPercent + latePercent}%, var(--color-absent) ${presentPercent + latePercent}% ${presentPercent + latePercent + absentPercent}%, var(--color-leave) ${presentPercent + latePercent + absentPercent}% 100%)`;
        document.getElementById('dashboard-chart-legend').innerHTML = `<li><span class="legend-color" style="background-color: var(--color-present);"></span>Present (${present-late})</li><li><span class="legend-color" style="background-color: var(--color-late);"></span>Late (${late})</li><li><span class="legend-color" style="background-color: var(--color-absent);"></span>Absent (${absent})</li><li><span class="legend-color" style="background-color: var(--color-leave);"></span>On Leave (${onLeave})</li>`;
        
        const recentActivityBody = document.getElementById('recent-activity-body');
        recentActivityBody.innerHTML = dailyAttendanceData
            .filter(e => e.status === 'present' || e.status === 'late')
            .slice(0, 5)
            .map(e => `<tr><td>${e.checkIn}</td><td>${e.name}</td><td>Check-in</td><td><span class="status-badge status-${e.status === 'present' ? 'on-time' : e.status}">${e.status}</span></td></tr>`)
            .join('');
    }

    // --- NAME SEARCH & TABLE FILTERING LOGIC ---
    function setupTableFilters(pageId) {
        const searchInput = document.getElementById(`${pageId}-search-input`);
        const statusFilter = document.getElementById(`${pageId}-status-filter`);
        const tableBody = document.getElementById(`${pageId}-table-body`);
        if (!tableBody) return;
        const noRecordsRow = tableBody.nextElementSibling; // Get the .no-records row

        const applyFilters = () => {
            const tableRows = tableBody.querySelectorAll('tr');
            const searchTerm = searchInput ? searchInput.value.toLowerCase() : '';
            const statusValue = statusFilter ? statusFilter.value : 'all';
            let visibleCount = 0;
            if(noRecordsRow) noRecordsRow.style.display = 'none';

            tableRows.forEach(row => {
                const statusMatch = !statusFilter || (statusValue === 'all' || row.dataset.status === statusValue);
                const searchMatch = !searchInput || row.textContent.toLowerCase().includes(searchTerm);
                
                if (statusMatch && searchMatch) {
                    row.style.display = 'table-row'; visibleCount++;
                } else { row.style.display = 'none'; }
            });
            if (visibleCount === 0 && noRecordsRow) noRecordsRow.style.display = 'table-row';
        };
        if (searchInput) searchInput.addEventListener('keyup', applyFilters);
        if (statusFilter) statusFilter.addEventListener('change', applyFilters);
    }

    // --- REPORTS PAGE LOGIC ---
    const monthSelect = document.getElementById('month-select');
    const reportPlaceholder = document.getElementById('report-placeholder');
    const reportContent = document.getElementById('report-content');
    const exportButtons = [document.getElementById('export-pdf'), document.getElementById('export-excel'), document.getElementById('export-csv')];

    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const currentYear = new Date().getFullYear();
    for (let i = 0; i < 6; i++) {
        const date = new Date(currentYear, new Date().getMonth() - i, 1);
        const monthVal = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
        monthSelect.innerHTML += `<option value="${monthVal}">${months[date.getMonth()]} ${date.getFullYear()}</option>`;
    }
    
    monthSelect.addEventListener('change', function() {
        if (this.value) {
            const data = generateRandomReportData(this.value);
            renderReport(data);
            reportPlaceholder.style.display = 'none';
            reportContent.style.display = 'block';
            exportButtons.forEach(btn => btn.disabled = false);
        } else {
            reportPlaceholder.style.display = 'block';
            reportContent.style.display = 'none';
            exportButtons.forEach(btn => btn.disabled = true);
        }
    });
    
    function generateRandomReportData(monthYear) {
        const [year, month] = monthYear.split('-');
        const workingDays = new Date(year, month, 0).getDate();
        const report = { workingDays, employees: [] };
        employeeList.forEach(emp => {
            const leave = Math.floor(Math.random() * 3);
            const absent = Math.floor(Math.random() * 4);
            report.employees.push({ name: emp.name, present: workingDays - leave - absent, absent, leave });
        });
        return report;
    }

    function renderReport(data) {
        const reportTableBody = document.getElementById('report-table-body');
        const reportPieChart = document.getElementById('report-pie-chart');
        const reportChartLegend = document.getElementById('report-chart-legend');
        const reportKeyStats = document.getElementById('report-key-stats');
        
        reportTableBody.innerHTML = ''; reportChartLegend.innerHTML = ''; reportKeyStats.innerHTML = '';
        let totalPresent = 0, totalAbsent = 0, totalLeave = 0;
        data.employees.forEach(emp => {
            totalPresent += emp.present; totalAbsent += emp.absent; totalLeave += emp.leave;
            const absenteeism = emp.present + emp.absent > 0 ? ((emp.absent / (emp.present + emp.absent)) * 100).toFixed(1) : 0;
            reportTableBody.innerHTML += `<tr><td>${emp.name}</td><td>${emp.present}</td><td>${emp.absent}</td><td>${emp.leave}</td><td><div class="progress-bar"><div class="progress-bar-fill" style="width: ${absenteeism}%;">${absenteeism > 0 ? absenteeism+'%' : ''}</div></div></td></tr>`;
        });

        const grandTotal = totalPresent + totalAbsent + totalLeave;
        const presentPercent = grandTotal > 0 ? (totalPresent / grandTotal) * 100 : 0;
        const absentPercent = grandTotal > 0 ? (totalAbsent / grandTotal) * 100 : 0;
        const overallAbsenteeism = (totalPresent + totalAbsent > 0) ? ((totalAbsent / (totalPresent + totalAbsent)) * 100).toFixed(1) : 0;
        reportPieChart.style.background = `conic-gradient(var(--color-present) 0% ${presentPercent}%, var(--color-absent) ${presentPercent}% ${presentPercent + absentPercent}%, var(--color-leave) ${presentPercent + absentPercent}% 100%)`;
        reportChartLegend.innerHTML = `<li><span class="legend-color" style="background-color: var(--color-present);"></span>Present (${totalPresent})</li><li><span class="legend-color" style="background-color: var(--color-absent);"></span>Absent (${totalAbsent})</li><li><span class="legend-color" style="background-color: var(--color-leave);"></span>On Leave (${totalLeave})</li>`;
        reportKeyStats.innerHTML = `<li><strong>Working Days:</strong> ${data.workingDays}</li><li><strong>Total Employees:</strong> ${data.employees.length}</li><li><strong>Overall Absenteeism:</strong> ${overallAbsenteeism}%</li>`;
    }

    // --- EXPORT FUNCTIONS ---
    exportButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const table = document.getElementById('report-table');
            const selectedMonthText = monthSelect.options[monthSelect.selectedIndex].text;
            const filename = `report-${selectedMonthText.replace(/\s/g, '-')}`;
            if (this.id === 'export-pdf') {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                doc.text(`Attendance Report - ${selectedMonthText}`, 14, 16);
                doc.autoTable({ html: '#report-table', startY: 20, theme: 'grid', headStyles: { fillColor: [26, 188, 156] } });
                doc.save(`${filename}.pdf`);
            } else if (this.id === 'export-excel') {
                const wb = XLSX.utils.table_to_book(table, { sheet: "Attendance Report" });
                XLSX.writeFile(wb, `${filename}.xlsx`);
            } else if (this.id === 'export-csv') {
                const csv = XLSX.utils.sheet_to_csv(XLSX.utils.table_to_sheet(table));
                const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
                const link = document.createElement("a");
                link.href = URL.createObjectURL(blob);
                link.setAttribute("download", `${filename}.csv`);
                document.body.appendChild(link); link.click(); document.body.removeChild(link);
            }
        });
    });

    // --- INITIALIZE APP ---
    renderDashboard();
    renderEmployeesPage();
    renderAttendancePage();
    setupTableFilters('attendance');
    setupTableFilters('employee');
    showPage('dashboard'); // Start on the dashboard
    
    // Initial user dropdown setup
    document.getElementById('user-profile-toggle').addEventListener('click', (e) => {
        e.stopPropagation();
        document.getElementById('user-profile-menu').classList.toggle('show');
    });
    window.addEventListener('click', () => {
        document.getElementById('user-profile-menu').classList.remove('show');
    });
});
</script>

</x-app-layout>