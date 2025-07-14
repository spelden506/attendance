<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = []; // Allow mass assignment for all fields

    // An employee can have many attendance records
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}