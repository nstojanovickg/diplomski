<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\SubjectQuery;
use App\Models\Subject;
use App\Http\Requests\SubjectRequest;
use App\Lists\SubjectList;

class SubjectController extends Controller {
    private $main_page = 'basic/subject';
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$subjectList = new SubjectList($request,$this->main_page,$page);
		
		$keys = $subjectList->getKeys();
		$data_arr = $subjectList->getDataArr();
		$paginationForm = $subjectList->getPaginationForm();
		$filter = session('subject_filter');
		
		$form_filter = $formBuilder->create('App\Filters\SubjectFilter', [
			'method' => 'PATCH',
			'action' => ['SubjectController@index'],
			'model'  => $filter
		]);
		
		session(['attribute' => \Lang::get('general.SUBJECTS')]);
		session(['attribute' => \Lang::get('general.SUBJECT')]);
        
		return view('list', [
								'controller' => 'SubjectController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'SUBJECT',
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
		$form = $formBuilder->create('App\Forms\SubjectForm', [
			'method' => 'POST',
			'action' => ['SubjectController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'SUBJECT';
		$action = 'ADD';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.SUBJECT')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(SubjectRequest $request)
	{
		$data = $request->all();
		$subject = new Subject();
        $subject->fromArray($data);
        $subject->save();
		
		flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.SUBJECT')]);
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
        $subject_arr = [];
		$subject = SubjectQuery::create()->findPK($id);
		$subject_arr = $subject->toArray();
		
		$form = $formBuilder->create('App\Forms\SubjectForm', [
			'method' => 'PATCH',
			'action' => ['SubjectController@update', $id],
			'model' => $subject_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'SUBJECT';
		$action = 'EDIT';
		$path = $this->main_page;
		session(['attribute' => \Lang::get('general.SUBJECT')]);
        
		return view('manage', compact('form', 'form_name', 'action', 'path'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, SubjectRequest $request)
	{
        $data = $request->all();
		$subject = SubjectQuery::create()->findPK($id);
        $subject->fromArray($data);
        $subject->save();
		
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.SUBJECT')]);
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
		$subject = SubjectQuery::create()->findPK($id);
		$subject->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.SUBJECT')]);
		return redirect($this->main_page);
	}

}
