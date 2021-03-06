<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Support\Str;
use Larapen\Admin\app\Models\Crud;
use App\Models\User;
use App\Models\AgentCommision;
class Agent extends BaseModel{
    use Crud;
    protected $table = 'agent';
    // protected $gaurded = [];
    protected $fillable = ['name','gender','phone','email','voucher_code','commission','commission_validity','payment_method','payout_email','country_code','phone_verified','active','parent_id','own_user_id'];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope());
    }

    public function user(){
        return $this->belongsTo(User::class, 'own_user_id');
    }

    public function commissions(){
        return $this->hasMany(AgentCommision::class, 'agent_user_id','own_user_id');
    }
}
