<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableMunicipality extends Model
{
    use HasFactory;

    public function province()
    {
        return $this->belongsTo(TableProvince::class, 'table_province_id');
    }
}
