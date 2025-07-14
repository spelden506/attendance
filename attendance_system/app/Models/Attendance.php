<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = []; // Allow mass assignment for all fields

    // An attendance record belongs to one employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}