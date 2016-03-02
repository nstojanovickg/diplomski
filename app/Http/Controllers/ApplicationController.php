<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\Application;
use App\Models\ApplicationQuery;
use App\Http\Requests\ApplicationRequest;
use App\Lists\ApplicationList;

class ApplicationController extends Controller {
    private $main_page = 'application/application';
        
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$applicationList = new ApplicationList($request,$this->main_page,$page);
		
		$keys = $applicationList->getKeys();
		$data_arr = $applicationList->getDataArr();
		$paginationForm = $applicationList->getPaginationForm();
		$filter = session('application_filter');
		session(['attribute' => \Lang::get('general.APPLICATION_OBJ')]);
		
		$form_filter = $formBuilder->create('App\Filters\ApplicationFilter', [
			'method' => 'PATCH',
			'action' => ['ApplicationController@index'],
			'model'  => $filter,
			'class'  => 'form-inline'
		]);
		
		$edit = true;
		$delete = (\Auth::user()->getStatus() == 'professor') ? false : true;
		return view('list', [
								'controller' => 'ApplicationController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'APPLICATIONS',
								'filter' => $form_filter,
								'pagination' => $paginationForm,
								'add' => true,
								'additional_info' => false,
                                'back' => false,
                                'parent_table_id' => false,
								'edit' => $edit,
								'delete' => $delete
							]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(FormBuilder $formBuilder)
	{
		$form = $formBuilder->create('App\Forms\ApplicationForm', [
			'method' => 'POST',
			'action' => ['ApplicationController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'APPLICATION';
		$action = 'ADD_OBJ';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.APPLICATION_OBJ')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ApplicationRequest $request)
	{
        $data = $request->all();
		if(isset($data['OralExamInvitationId']) && $data['OralExamInvitationId'] == '') unset($data['OralExamInvitationId']);
		$application = new Application();
        $application->fromArray($data);
        $application->save();
		
        flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.APPLICATION')]);
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
        
        $application_arr = [];
		$application = ApplicationQuery::create()->findPK($id);
		$application_arr = $application->toArray();
		//echo "<pre>";print_r($application_arr);die;
		
		$form = $formBuilder->create('App\Forms\ApplicationForm', [
			'method' => 'PATCH',
			'action' => ['ApplicationController@update', $id],
			'model' => $application_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'APPLICATION';
		$action = 'EDIT_OBJ';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.APPLICATION_OBJ')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, ApplicationRequest $request)
	{
        $data = $request->all();
		if(isset($data['OralExamInvitationId']) && $data['OralExamInvitationId'] == '') unset($data['OralExamInvitationId']);
		$application = ApplicationQuery::create()->findPK($id);
        $application->fromArray($data);
        $application->save();
		
		flash()->success("UPDATED");
		session(['attribute' => \Lang::get('general.APPLICATION')]);
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
		$application = ApplicationQuery::create()->findPK($id);
		$application->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.APPLICATION')]);
		return redirect($this->main_page);
	}

}
