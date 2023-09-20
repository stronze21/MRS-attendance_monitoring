<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'apikey',
        'account_id',
        'account_name',
        'status',
        'credit_balance',
    ];
}
