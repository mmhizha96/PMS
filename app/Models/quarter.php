<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class quarter extends Model
{
    use HasFactory;

    protected $table = 'quarters';
    protected $primaryKey = 'quarter_id';
    protected $casts = [
        'start_date' => 'datetime', 'end_date' => 'datetime',
    ];
    protected $fillable = ['quarter_name', 'year_id', 'start_date', 'end_date', 'status'];
}
