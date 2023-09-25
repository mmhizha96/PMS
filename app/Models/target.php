<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class target extends Model
{
    use HasFactory;
    protected $table = 'targets';
    protected $primaryKey = 'target_id';
    protected $fillablle = ['year_id', 'budget_value', 'department_id', 'indicator_id', 'target_value', 'target_description', 'baseline', 'project_vote_number'];
}
