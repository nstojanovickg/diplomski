<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\ApplicationRequestQuery;
use App\Models\ApplicationRequest;
use App\Http\Requests\ApplicationRequestRequest;
use App\Lists\ApplicationRequestList;

class ApplicationRequestController extends Controller {
    private $main_page = 'additional_info/application_request';
        
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$applicationRequestList = new ApplicationRequestList($request,$this->main_page,$page);
		
		$keys = $applicationRequestList->getKeys();
		$data_arr = $applicationRequestList->getDataArr();
		$paginationForm = $applicationRequestList->getPaginationForm();
		
		//session(['attribute' => \Lang::get('general.APPLICATION_REQUESTS')]);
		//session(['attribute' => \Lang::get('general.APPLICATION_REQUEST')]);
		/*
		$form_filter = $formBuilder->create('App\Filters\ApplicationRequestFilter', [
			'method' => 'PATCH',
			'action' => ['ApplicationRequestController@index'],
			'model'  => $filter,
			'class'  => 'form-inline'
		]);
        */
		return view('list', [
								'controller' => 'ApplicationRequestController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'APPLICATION_REQUEST',
								'filter' => false,
								'pagination' => $paginationForm,
								'add' => false,
								'additional_info' => false,
                                'back' => false,
                                'parent_table_id' => false,
								'edit' => false,
								'delete' => false
							]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(FormBuilder $formBuilder)
	{
		$form = $formBuilder->create('App\Forms\ApplicationRequestForm', [
			'method' => 'POST',
			'action' => ['ApplicationRequestController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'APPLICATION_REQUEST';
		$action = 'ADD';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.APPLICATION_REQUEST')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ApplicationRequestRequest $request)
	{
		$data = $request->all();
		$applicationRequest = new ApplicationRequest();
        $applicationRequest->fromArray($data);
        $applicationRequest->save();
		
        flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.APPLICATION_REQUEST')]);
		return redirect($this->main_page);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FormBuilder $formBuilder)
	{
        $applicationRequest_arr = [];
		$applicationRequest = ApplicationRequestQuery::create()->findPK($id);
		$applicationRequest_arr = $applicationRequest->toArray();
		
		$form = $formBuilder->create('App\Forms\ApplicationRequestForm', [
			'method' => 'PATCH',
			'action' => ['ApplicationRequestController@update', $id],
			'model' => $applicationRequest_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'APPLICATION_REQUEST';
		$action = 'EDIT';
		$path = $this->main_page;
		session(['attribute' => \Lang::get('general.APPLICATION_REQUEST')]);
        
		return view('manage', compact('form', 'form_name', 'action', 'path'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, ApplicationRequestRequest $request)
	{
        $data = $request->all();
		$applicationRequest = ApplicationRequestQuery::create()->findPK($id);
        $applicationRequest->fromArray($data);
        $applicationRequest->save();
		
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.APPLICATION_REQUEST')]);
		return redirect($this->main_page);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$applicationRequest = ApplicationRequestQuery::create()->findPK($id);
		$applicationRequest->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.APPLICATION_REQUEST')]);
		return redirect($this->main_page);
	}

}
