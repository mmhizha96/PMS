<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rejected_actual extends Model
{
    use HasFactory;

    protected $primaryKey = 'rejected_actual_id';
    protected $table = 'rejected_actuals';
    protected $fillable = ['rejected_by', 'created_at', 'updated_at', 'reason','actual_id'];
}
