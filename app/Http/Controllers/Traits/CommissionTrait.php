<?php
/**
 * Laravel Classified
 *  All Rights Reserved
 *
 * 
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice
 * 
 */

namespace App\Http\Controllers\Traits;
use App\Models\User;
use App\Models\AgentCommision;
use App\Helpers\ArrayHelper;
use App\Helpers\Files\Storage\StorageDisk;
use Illuminate\Support\Facades\Artisan;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

trait CommissionTrait
{
	public function commissionAdd($user, $post){

		if( $user->ref_type == 'agent' ){
			$commission = [
				'agent_user_id' 		=> $user->ref_id,
				'post_id'				=> $post->id,
				'commision_percent'		=> User::find($user->ref_id)->agent->commission,
				'cost_of_post'			=> 0,
				'commision'				=> 0,
				'agent_type'			=> $user->ref_type,
				'user_name'				=> $user->name,
				'description'			=> $user->name.'| posted with 0 amount',
				'currency'				=> 'EUR',
			];
			AgentCommision::create($commission);

		}else if( $user->ref_type == 'sub-agent' ){

			$subAgent = User::where('id',$user->ref_id)->with('agent')->first();
			$parent_id = $subAgent->agent->parent_id;
			$parentAgent = User::where('id',$parent_id)->with('agent')->first();
			$subAgentCom = $parentAgent->agent->commission * $subAgent->agent->commission / 100;
			
			$AgentCommission = [
				'agent_user_id' 		=> $parentAgent->id,
				'post_id'				=> $post->id,
				'commision_percent'		=> $parentAgent->agent->commission - $subAgentCom,
				'cost_of_post'			=> 0,
				'commision'				=> 0,
				'agent_type'			=> 'agent',
				'user_name'				=> $user->name,
				'subagent_name'			=> $subAgent->name,
				'description'			=> 'From Subagent | '.$subAgent->name.' & User | '.$user->name.'| posted with 0 amount',
				'currency'				=> 'EUR',
			];
			// dd($AgentCommission);
			AgentCommision::create($AgentCommission);


			$SUbAgentCommission = [
				'agent_user_id' 		=> $user->ref_id,
				'post_id'				=> $post->id,
				'commision_percent'		=> $subAgentCom,
				'cost_of_post'			=> 0,
				'commision'				=> 0,
				'agent_type'			=> $user->ref_type,
				'commission_desc'		=> $subAgent->agent->commission.'% of '.$parentAgent->agent->commission.'%',
				'user_name'				=> $user->name,
				'description'			=> $user->name.'| posted with 0 amount',
				'currency'				=> 'EUR',
			];
			AgentCommision::create($SUbAgentCommission);

		}else{

		}
	}

	public function commissionUpdate($com,$package){
		foreach($com as $c){
			$commission = AgentCommision::find($c->id);
			$commission->cost_of_post = $package ? $package->price : 'Package Not Found';
			$commission->currency = $package ? $package->currency_code : 'Package Not Found';

			$netEarn = $package->price;

			if(!empty(config('settings.tax'))){
				$taxtPercent = config('settings.tax.tax_percent');
				$netEarn =  $package->price - ( $package->price * $taxtPercent /100);
			}
			// die($netEarn);

			$commission->commision = $package ? $netEarn * $commission->commision_percent /100 : 0.00;
			$commission->description = $package ? 
				$commission->user_name.' | has posted as '.$package->name.' price as '.$package->price.' '.$package->currency_code
				: 'Package Not Found';
			$commission->save();
		}
	}
}
