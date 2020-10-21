<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Larapen\Admin\app\Models\Crud;
class Payout extends BaseModel
{
    use Crud;
    protected $table = 'payouts';

    protected $fillable = [
        'date',
        'agent_user_id',
        'type',
        'amount',
        'description',
        'payment_json',
    ];
}
