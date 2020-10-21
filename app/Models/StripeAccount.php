<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class StripeAccount extends Model
{
    protected $fillable = [
        'user_id',
        'card_number',
        'card_cvc',
        'card_expiry',
        'currency',
        'card_type'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
