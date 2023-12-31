<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class year extends Model
{
    use HasFactory;

    protected $table = 'years';
    protected $primaryKey = 'year_id';
    protected $fillable = ['year', 'status'];
}
