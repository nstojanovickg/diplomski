<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\SchoolYearQuery;
use App\Models\SchoolYear;
use App\Http\Requests\SchoolYearRequest;
use App\Lists\SchoolYearList;

class SchoolYearController extends Controller {
    private $main_page = 'basic/school_year';
        
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$schoolYearList = new SchoolYearList($request,$this->main_page,$page);
		
		$keys = $schoolYearList->getKeys();
		$data_arr = $schoolYearList->getDataArr();
		$paginationForm = $schoolYearList->getPaginationForm();
		$filter = session('course_filter');
		session(['attribute' => \Lang::get('general.SCHOOL_YEAR_OBJ')]);
		
		$form_filter = $formBuilder->create('App\Filters\SchoolYearFilter', [
			'method' => 'PATCH',
			'action' => ['SchoolYearController@index'],
			'model'  => $filter,
			'class'  => 'form-inline'
		]);
        
		return view('list', [
								'controller' => 'SchoolYearController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'SCHOOL_YEARS',
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
		$form = $formBuilder->create('App\Forms\SchoolYearForm', [
			'method' => 'POST',
			'action' => ['SchoolYearController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'SCHOOL_YEAR';
		$action = 'ADD_OBJ';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.SCHOOL_YEAR_OBJ')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SchoolYearRequest $request)
	{
		$data = $request->all();
		$schoolYear = new SchoolYear();
        $schoolYear->fromArray($data);
        $schoolYear->save();
		
        flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.SCHOOL_YEAR')]);
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
        $schoolYear_arr = [];
		$schoolYear = SchoolYearQuery::create()->findPK($id);
		$schoolYear_arr = $schoolYear->toArray();
		
		$form = $formBuilder->create('App\Forms\SchoolYearForm', [
			'method' => 'PATCH',
			'action' => ['SchoolYearController@update', $id],
			'model' => $schoolYear_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'SCHOOL_YEAR';
		$action = 'EDIT_OBJ';
		$path = $this->main_page;
		session(['attribute' => \Lang::get('general.SCHOOL_YEAR_OBJ')]);
        
		return view('manage', compact('form', 'form_name', 'action', 'path'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, SchoolYearRequest $request)
	{
        $data = $request->all();
		$schoolYear = SchoolYearQuery::create()->findPK($id);
        $schoolYear->fromArray($data);
        $schoolYear->save();
		
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.SCHOOL_YEAR')]);
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
		$schoolYear = SchoolYearQuery::create()->findPK($id);
		$schoolYear->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.SCHOOL_YEAR')]);
		return redirect($this->main_page);
	}

}
