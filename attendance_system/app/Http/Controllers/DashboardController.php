<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Fetch all employees
        $employees = Employee::orderBy('name')->get();

        // 2. Fetch today's attendance records with employee details (Eager Loading)
        $todaysAttendance = Attendance::with('employee')
            ->where('date', Carbon::today())
            ->get();
            
        // 3. Calculate stats for the dashboard
        $stats = [
            'present' => $todaysAttendance->whereIn('status', ['present', 'late'])->count(),
            'late' => $todaysAttendance->where('status', 'late')->count(),
            'absent' => $todaysAttendance->where('status', 'absent')->count(),
            'on_leave' => $todaysAttendance->where('status', 'on_leave')->count(),
            'total_employees' => $employees->count(),
        ];
        
        // 4. Get recent check-in activity
        $recentActivity = $todaysAttendance
            ->whereIn('status', ['present', 'late'])
            ->sortBy('check_in_time')
            ->take(5);

        // 5. Pass all data to the view
        return view('dashboard', [
            'employees' => $employees,
            'todaysAttendance' => $todaysAttendance,
            'stats' => $stats,
            'recentActivity' => $recentActivity
        ]);
    }
}