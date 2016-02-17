<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\ProfessorQuery;
use App\Models\Professor;
use App\Http\Requests\ProfessorRequest;
use App\Lists\ProfessorList;

class ProfessorController extends Controller {
    private $main_page = 'basic/professor';
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$professorList = new ProfessorList($request,$this->main_page,$page);
		
		$keys = $professorList->getKeys();
		$data_arr = $professorList->getDataArr();
		$paginationForm = $professorList->getPaginationForm();
		$filter = session('professor_filter');
		
		$form_filter = $formBuilder->create('App\Filters\ProfessorFilter', [
			'method' => 'PATCH',
			'action' => ['ProfessorController@index'],
			'model'  => $filter
		]);
		
		session(['attribute' => \Lang::get('general.PROFESSORS')]);
		session(['attribute' => \Lang::get('general.PROFESSOR')]);
        
		return view('list', [
								'controller' => 'ProfessorController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'PROFESSOR',
								'filter' => $form_filter,
								'pagination' => $paginationForm,
								'add' => true,
								'additional_info' => false,
                                'back' => false,
                                'parent_table_id' => false
							]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(FormBuilder $formBuilder)
	{
		$form = $formBuilder->create('App\Forms\ProfessorForm', [
			'method' => 'POST',
			'action' => ['ProfessorController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'PROFESSOR';
		$action = 'ADD';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.PROFESSOR')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ProfessorRequest $request)
	{
		$data = $request->all();
		$professor = new Professor();
        $professor->fromArray($data);
        $professor->save();
		
		flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.PROFESSOR')]);
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
        $professor_arr = [];
		$professor = ProfessorQuery::create()->findPK($id);
		$professor_arr = $professor->toArray();
		
		$form = $formBuilder->create('App\Forms\ProfessorForm', [
			'method' => 'PATCH',
			'action' => ['ProfessorController@update', $id],
			'model' => $professor_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'PROFESSOR';
		$action = 'EDIT';
		$path = $this->main_page;
		session(['attribute' => \Lang::get('general.PROFESSOR')]);
        
		return view('manage', compact('form', 'form_name', 'action', 'path'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, ProfessorRequest $request)
	{
        $data = $request->all();
		$professor = ProfessorQuery::create()->findPK($id);
        $professor->fromArray($data);
        $professor->save();
		
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.PROFESSOR')]);
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
		$professor = ProfessorQuery::create()->findPK($id);
		$professor->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.PROFESSOR')]);
		return redirect($this->main_page);
	}

}
