<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'dtr_date',
        'student_id',
        'time_in',
        'time_out',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
