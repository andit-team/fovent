<?php

namespace App\Http\Controllers\Admin;
use Larapen\Admin\app\Http\Controllers\PanelController;
// use App\Http\Requests\Admin\Request as StoreRequest;
use Illuminate\Http\Request;
use Session;
use Hash;
use DB;
class AgentCommisionController extends PanelController
{
    // use Larapen\Admin\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    public function setup()
    {
        // dd($_GET);
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->xPanel->setModel('App\Models\AgentCommision');
        $this->xPanel->setRoute(admin_uri('agent-commission'));
        $this->xPanel->setEntityNameStrings(trans('Agent Commision'), trans('Agent Commision'));
        // $this->xPanel->setEntityNameStrings(trans('admin.ad type'), trans('admin.ad types'));
        // $this->xPanel->enableDetailsRow();
        $this->xPanel->removeButton('create');
        // $this->crud->allowAccess('list');

        $this->xPanel->removeAllButtonsFromStack('line');

        if(isset($_GET['type'])){
            $this->xPanel->addClause('where', 'agent_type', $_GET['type']);
        }
        if(auth()->user()->hasRole('agent') || auth()->user()->hasRole('sub-agent')){
            $this->xPanel->addClause('where', 'agent_user_id', auth()->user()->id);
        }

        // $this->xPanel->addClause('where', 'agent_user_id', auth()->user()->id);

        $this->xPanel->addFilter([
			'name'  => 'from_to',
			'type'  => 'date_range',
			'label' => trans('admin.Date range'),
		],
			false,
			function ($value) {
				$dates = json_decode($value);
				$this->xPanel->addClause('where', 'created_at', '>=', $dates->from);
				$this->xPanel->addClause('where', 'created_at', '<=', $dates->to);
			});

        $this->xPanel->addColumn([
			'name'  => 'created_at',
			'label' => trans('admin.Date'),
			'type'  => 'datetime',
		]);

        $this->xPanel->addColumn([
            'label'         => 'Agent Name',
            'name'          => 'agent_user_id',
            'type'          => 'model_function',
            'function_name' => 'AgentName',
        ]);

        $this->xPanel->addColumn([
            'name'  => 'cost_of_post',
            'label' => "Actual Price of Cost",
        ]);
        $this->xPanel->addColumn([
            'name'  => 'commision',
            'label' => "Commission Earned",
        ]);
        $this->xPanel->addColumn([
            'name'  => 'currency',
            'label' => "Currency",
        ]);

        $this->xPanel->addColumn([
            'name'  => 'status',
            'label' => "Status",
        ]);
        $this->xPanel->addColumn([
            'name'  => 'description',
            'label' => "Description",
        ]);

        
    }


    // public function showDetailsRow($id){
    //     return 'adsfasdf';
    // }

    // protected function setupListOperation()
    // {
    //     $this->xPanel->addColumn([
    //         'name'  => 'id',
    //         'label' => "ID",
    //     ]);
    //     $this->xPanel->addColumn([
    //         'name'  => 'agent_user_id',
    //         'label' => "agent_user_id",
    //     ]);
    //    // $this->crud->addColumn();
    // }
}
