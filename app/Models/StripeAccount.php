<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class StripeAccount extends Model
{
    protected $fillable = [
        'user_id',
        'account_id',
        'stripeJson',
        'currency'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
