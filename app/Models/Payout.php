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
        'trans_id',
        'currency',
        'agent_user_id',
        'type',
        'amount',
        'description',
        'payment_json',
    ];

    public function AgentName(){
        $agent = User::find($this->agent_user_id);
        if($agent){
            return $agent->name;
        }
        return 'Self';
    }
}
