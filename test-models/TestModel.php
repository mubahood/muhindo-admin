<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    protected $table = 'test_models';
    
    protected $fillable = [
        'name',
        'email', 
        'description',
        'status',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
