<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $table = 'advertisements';
    protected $guarded = ['id'];
    
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
