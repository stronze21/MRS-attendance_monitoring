<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'description',
        'school_year',
        'section',
        'time_in',
        'time_out',
        'am_pm',
    ];

    public function con_cat()
    {
        return $this->description . ' ' . $this->school_year . ' (' . $this->am_pm . ')';
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }


    public function male_students()
    {
        return $this->hasMany(Student::class)->withTrashed()->where('gender', 'm');
    }

    public function female_students()
    {
        return $this->hasMany(Student::class)->withTrashed()->where('gender', 'f');
    }
}
