<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'lastname',
        'firstname',
        'middlename',
        'birthdate',
        'gender',
        'guardian_name',
        'guardian_relationship',
        'contact_no',
        'notify_sms',
        'level_id',
        'tag',
    ];

    public function fullname()
    {
        return $this->lastname . ', ' . $this->firstname . ' ' . $this->middlename;
    }

    public function gender()
    {
        if ($this->gender == 'm')
            $gender = 'Male';
        else
            $gender = 'Female';

        return $gender;
    }

    public function age()
    {
        return Carbon::parse($this->birthdate)->age;
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
