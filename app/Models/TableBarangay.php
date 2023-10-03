<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableBarangay extends Model
{
    use HasFactory;

    public function municipality()
    {
        return $this->belongsTo(TableMunicipality::class, 'table_municipality_id');
    }
}
