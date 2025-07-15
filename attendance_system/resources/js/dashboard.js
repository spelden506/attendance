// resources/js/dashboard.js

document.addEventListener('DOMContentLoaded', function() {
    
    // START: THIS IS THE NEW, CORRECT LOGOUT CODE
    const logoutLink = document.getElementById('logout-link');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(event) {
            // Prevent the link from sending a GET request
            event.preventDefault();

            // Find the hidden logout form and submit it
            const logoutForm = document.getElementById('logout-form');
            if (logoutForm) {
                logoutForm.submit();
            }
        });
    }
    // END: NEW LOGOUT CODE

    // --- Global Elements (exist on all pages) ---
    const dashboardContainer = document.getElementById('dashboard-container');
    const hamburgerMenu = document.querySelector('.hamburger-menu');
    const themeToggle = document.getElementById('theme-toggle');
    const userProfileToggle = document.getElementById('user-profile-toggle');
    const userProfileMenu = document.getElementById('user-profile-menu');
    
    // --- Global Logic (runs on all pages) ---
    if (hamburgerMenu) {
        hamburgerMenu.addEventListener('click', () => dashboardContainer.classList.toggle('sidebar-collapsed'));
    }
    const currentTheme = localStorage.getItem('theme');
    if (currentTheme === 'dark') document.body.classList.add('dark-mode');
    
    if(themeToggle) {
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            localStorage.setItem('theme', document.body.classList.contains('dark-mode') ? 'dark' : 'light');
        });
    }

    if(userProfileToggle) {
        userProfileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            userProfileMenu.classList.toggle('show');
        });
    }
    window.addEventListener('click', () => {
        if (userProfileMenu) userProfileMenu.classList.remove('show');
    });

    // --- MOCK DATA (In a real app, this comes from the Controller) ---
    const employeeList = [
        { id: 'YK001', name: 'Pema Choden', position: 'HR Manager', department: 'Human Resources', email: 'p.choden@yangkhor.com' },
        { id: 'YK002', name: 'Tenzin Nidup', position: 'Software Engineer', department: 'Technology', email: 't.nidup@yangkhor.com' },
        { id: 'YK003', name: 'Karma Wangdi', position: 'Accountant', department: 'Finance', email: 'k.wangdi@yangkhor.com' },
        { id: 'YK004', name: 'Sonam Dorji', position: 'IT Support', department: 'Technology', email: 's.dorji@yangkhor.com' },
        { id: 'YK005', name: 'Jigme Singye', position: 'Marketing Lead', department: 'Sales & Marketing', email: 'j.singye@yangkhor.com' },
        { id: 'YK006', name: 'Lhaki Dolma', position: 'Jr. Developer', department: 'Technology', email: 'l.dolma@yangkhor.com' },
        { id: 'YK007', name: 'Sangay Dema', position: 'Data Analyst', department: 'Technology', email: 's.dema@yangkhor.com' },
    ];

    function generateDailyAttendance() {
        const statuses = ['present', 'late', 'absent', 'leave'];
        const times = ['08:55 AM', '09:15 AM', '08:45 AM'];
        return employeeList.map(emp => {
            const status = statuses[Math.floor(Math.random() * statuses.length)];
            let checkIn = '--:--'; let checkOut = '--:--';
            if (status === 'present' || status === 'late') {
                checkIn = times[Math.floor(Math.random() * times.length)];
                if (Math.random() > 0.5) checkOut = '05:05 PM';
            }
            return { ...emp, status, checkIn, checkOut };
        });
    }
    const dailyAttendanceData = generateDailyAttendance();

    // --- PAGE-SPECIFIC INITIALIZATION ---
    if (document.getElementById('dashboard-page')) { renderDashboard(); }
    if (document.getElementById('attendance-page')) { renderAttendancePage(); setupTableFilters('attendance-search-input', 'attendance-status-filter', 'attendance-table-body'); }
    if (document.getElementById('employees-page')) { renderEmployeesPage(); setupTableFilters('employee-search-input', null, 'employee-table-body'); }
    if (document.getElementById('reports-page')) { initializeReportsPage(); }
    
    // --- FUNCTION DEFINITIONS ---
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
        const total = present + absent + onLeave;
        const presentPercent = total > 0 ? (present / total) * 100 : 0;
        const absentPercent = total > 0 ? (absent / total) * 100 : 0;
        document.getElementById('dashboard-pie-chart').style.background = `conic-gradient(var(--color-present) 0% ${presentPercent}%, var(--color-absent) ${presentPercent}% ${presentPercent + absentPercent}%, var(--color-leave) ${presentPercent + absentPercent}% 100%)`;
        document.getElementById('dashboard-chart-legend').innerHTML = `<li><span class="legend-color" style="background-color: var(--color-present);"></span>Present (${present})</li><li><span class="legend-color" style="background-color: var(--color-absent);"></span>Absent (${absent})</li><li><span class="legend-color" style="background-color: var(--color-leave);"></span>On Leave (${onLeave})</li>`;
        const recentActivityBody = document.getElementById('recent-activity-body');
        recentActivityBody.innerHTML = dailyAttendanceData.slice(0, 5).map(e => `<tr><td>${e.checkIn}</td><td>${e.name}</td><td>Check-in</td><td><span class="status-badge status-${e.status === 'on-time' ? 'present' : e.status}">${e.status}</span></td></tr>`).join('');
    }
    function renderEmployeesPage() {
        const tableBody = document.getElementById('employee-table-body');
        tableBody.innerHTML = employeeList.map(emp => `<tr><td>${emp.id}</td><td>${emp.name}</td><td>${emp.position}</td><td>${emp.department}</td><td>${emp.email}</td><td><div class="action-buttons"><a href="#" class="action-btn view">View</a><a href="#" class="action-btn edit">Edit</a></div></td></tr>`).join('') + `<tr class="no-records"><td colspan="6">No employees found.</td></tr>`;
    }
    function renderAttendancePage() {
        const tableBody = document.getElementById('attendance-table-body');
        document.getElementById('current-date-display').textContent = new Date().toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        tableBody.innerHTML = dailyAttendanceData.map(emp => { let badgeClass = 'status-on-time'; if (emp.status === 'late') badgeClass = 'status-late'; else if (emp.status === 'absent') badgeClass = 'status-absent'; else if (emp.status === 'leave') badgeClass = 'status-on-leave'; return `<tr data-status="${emp.status}"><td>${emp.name}</td><td>${emp.checkIn}</td><td>${emp.checkOut}</td><td><span class="status-badge ${badgeClass}">${emp.status.charAt(0).toUpperCase() + emp.status.slice(1)}</span></td></tr>`; }).join('') + `<tr class="no-records"><td colspan="4">No records found.</td></tr>`;
    }
    function setupTableFilters(searchInputId, statusFilterId, tableBodyId) {
        const searchInput = document.getElementById(searchInputId);
        const statusFilter = statusFilterId ? document.getElementById(statusFilterId) : null;
        const tableBody = document.getElementById(tableBodyId);
        if (!tableBody) return;
        const applyFilters = () => { const tableRows = tableBody.querySelectorAll('tr:not(.no-records)'); const noRecordsRow = tableBody.querySelector('.no-records'); const searchTerm = searchInput ? searchInput.value.toLowerCase() : ''; const statusValue = statusFilter ? statusFilter.value : 'all'; let visibleCount = 0; if(noRecordsRow) noRecordsRow.style.display = 'none'; tableRows.forEach(row => { const statusMatch = !statusFilter || (statusValue === 'all' || row.dataset.status === statusValue); const searchMatch = !searchInput || row.textContent.toLowerCase().includes(searchTerm); if (statusMatch && searchMatch) { row.style.display = 'table-row'; visibleCount++; } else { row.style.display = 'none'; } }); if (visibleCount === 0 && noRecordsRow) noRecordsRow.style.display = 'table-row'; };
        if (searchInput) searchInput.addEventListener('keyup', applyFilters);
        if (statusFilter) statusFilter.addEventListener('change', applyFilters);
    }
    function initializeReportsPage() { /* ... function content from before ... */ }
});