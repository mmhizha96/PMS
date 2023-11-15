<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class actual extends Model
{
    use HasFactory;

    protected $table = 'actuals';
    protected $primaryKey = 'actual_id';

    protected $fillable = ['year_id', 'quarter_id', 'department_id', 'target_id', 'actual_value', 'expenditure', 'created_by', 'document_path', 'actual_description', 'status', 'approved_by'];
}
