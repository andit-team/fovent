<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Support\Str;
use Larapen\Admin\app\Models\Crud;
class Agent extends BaseModel{
    use Crud;
    protected $table = 'agent';
    protected $gaurded = [];

    protected static function boot()
    {
        parent::boot();
        
        static::addGlobalScope(new ActiveScope());
    }
}
