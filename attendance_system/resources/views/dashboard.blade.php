{{-- resources/views/dashboard.blade.php --}}

@extends('layouts.dashboard')

@section('content')
    <div class="content-page" id="dashboard-page">
        <h2>Dashboard</h2>
        <div class="stats-grid">
            <div class="stat-card present"><div class="stat-number" id="stat-present">0</div><div class="stat-label">Present Today</div><i class="fa-solid fa-user-check bg-icon"></i><a href="{{ route('attendance') }}" class="stat-link">View All →</a></div>
            <div class="stat-card absent"><div class="stat-number" id="stat-absent">0</div><div class="stat-label">Absent Today</div><i class="fa-solid fa-user-xmark bg-icon"></i><a href="{{ route('attendance') }}" class="stat-link">View All →</a></div>
            <div class="stat-card on-leave"><div class="stat-number" id="stat-leave">0</div><div class="stat-label">On Leave</div><i class="fa-solid fa-plane bg-icon"></i><a href="{{ route('attendance') }}" class="stat-link">View All →</a></div>
            <div class="stat-card late"><div class="stat-number" id="stat-late">0</div><div class="stat-label">Late Comers</div><i class="fa-solid fa-user-clock bg-icon"></i><a href="{{ route('attendance') }}" class="stat-link">View All →</a></div>
            <div class="stat-card employees"><div class="stat-number" id="stat-employees">0</div><div class="stat-label">Total Employees</div><i class="fa-solid fa-users bg-icon"></i><a href="{{ route('employees') }}" class="stat-link">View All →</a></div>
        </div>
        <div class="content-row">
            <div class="panel">
                    <div class="panel-header"><h3>Recent Activity</h3></div>
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
@endsection