<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'lastname',
        'firstname',
        'middlename',
        'gender',
        'guardian_name',
        'contact_no',
        'notify_sms',
        'level_id',
        'tag',
        'nickname',
        'contact_no_2',
        'address',
        'barangay',
        'city',
        'province',
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

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
