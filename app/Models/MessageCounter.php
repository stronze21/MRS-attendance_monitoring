<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'contact_no',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
