<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class target_status extends Model
{
    use HasFactory;
    protected $table = 'target_statuses';
    protected $primaryKey = 'target_status_id';
    protected $fillable = ['reason_for_deviation', 'status_code', 'target_id', 'comment'];
}
