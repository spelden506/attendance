<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 20 employees
        $employees = Employee::factory(20)->create();

        // For each employee, create an attendance record for today
        $employees->each(function ($employee) {
            $status = ['present', 'late', 'absent', 'on_leave'][rand(0, 3)];
            $checkIn = null;
            $checkOut = null;

            if ($status === 'present') {
                $checkIn = '08:'.rand(45, 59).':00';
            } elseif ($status === 'late') {
                $checkIn = '09:'.rand(10, 30).':00';
            }

            if ($checkIn && rand(0, 1) === 1) {
                $checkOut = '17:'.rand(0, 15).':00';
            }

            Attendance::create([
                'employee_id' => $employee->id,
                'date' => Carbon::today(),
                'status' => $status,
                'check_in_time' => $checkIn,
                'check_out_time' => $checkOut,
            ]);
        });
    }
}