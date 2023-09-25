<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class indicator extends Model
{
    use HasFactory;

    protected $table = 'indicators';
    protected $primaryKey = 'indicator_id';
    protected $fillable = ['indicator', 'description', 'department_id', 'kpn_number', 'kpi_type'];
}
