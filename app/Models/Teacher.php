<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
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
        'contact_no',
        'address',
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
}
