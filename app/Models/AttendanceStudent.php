<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'dtr_date',
        'student_id',
        'time_in_am',
        'time_out_am',
        'time_in_pm',
        'time_out_pm',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function time_in_am()
    {
        return Carbon::parse($this->time_in_am)->format('H:i');
    }

    public function time_out_am()
    {
        return Carbon::parse($this->time_out_am)->format('H:i');
    }

    public function time_in_pm()
    {
        return Carbon::parse($this->time_in_pm)->format('H:i');
    }

    public function time_out_pm()
    {
        return Carbon::parse($this->time_out_pm)->format('H:i');
    }

    public function time_in_am_2()
    {
        return Carbon::parse($this->time_in_am)->format('h:i A');
    }

    public function time_out_am_2()
    {
        return Carbon::parse($this->time_out_am)->format('h:i A');
    }

    public function time_in_pm_2()
    {
        return Carbon::parse($this->time_in_pm)->format('h:i A');
    }

    public function time_out_pm_2()
    {
        return Carbon::parse($this->time_out_pm)->format('h:i A');
    }
}
