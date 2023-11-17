<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nortification extends Model
{
    use HasFactory;

    protected $primaryKey = 'nortification_id';
    protected $table = 'nortifications';
    protected $fillable = ['message', 'recipients', 'sender', 'status', 'created_at', 'updated_at'];
}
