<?php

namespace App\Models;

use App\Models\Scopes\ActiveScope;
use Illuminate\Support\Str;
use Larapen\Admin\app\Models\Crud;
use App\Models\User;
use App\Models\Post;

class AgentCommision extends BaseModel
{
    use Crud;
    protected $table = 'agent_commisions';
    // protected $gaurded = [];
    protected $fillable = [
        'agent_user_id',
        'post_id',
        'commision_percent',
        'cost_of_post',
        'commision',
        'agent_type',
        'description',
        'user_name',
        'currency',
        'subagent_name',
        'commission_desc',
        'payout_id',
        'status',
        'active',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope());
    }

    public function AgentName(){
        $agent = User::find($this->agent_user_id);
        if($agent){
            return $agent->name;
        }
        return 'Agent not found';
    }

    public function user(){
        return $this->belongsTo(User::class, 'agent_user_id');
    }
    public function post(){
        return $this->belongsTo(Post::class, 'post_id');
    }
}
