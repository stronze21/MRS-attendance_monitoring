<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AttendanceTeacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'dtr_date',
        'teacher_id',
        'time_in_am',
        'time_out_am',
        'time_in_pm',
        'time_out_pm',
    ];


    public function teacher()
    {
        return $this->belongsTo(Student::class);
    }

    public function time_in()
    {
        return Carbon::parse($this->time_in)->format('h:i A');
    }

    public function time_out()
    {
        return Carbon::parse($this->time_out)->format('h:i A');
    }
}
