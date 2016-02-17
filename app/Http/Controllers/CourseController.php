<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\CourseQuery;
use App\Models\Course;
use App\Http\Requests\CourseRequest;
use App\Lists\CourseList;

class CourseController extends Controller {
    private $main_page = 'basic/course';
        
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$courseList = new CourseList($request,$this->main_page,$page);
		
		$keys = $courseList->getKeys();
		$data_arr = $courseList->getDataArr();
		$paginationForm = $courseList->getPaginationForm();
		$filter = session('course_filter');
		
		session(['attribute' => \Lang::get('general.COURSES')]);
		session(['attribute' => \Lang::get('general.COURSE')]);
		$form_filter = $formBuilder->create('App\Filters\CourseFilter', [
			'method' => 'PATCH',
			'action' => ['CourseController@index'],
			'model'  => $filter
		]);
        
		return view('list', [
								'controller' => 'CourseController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'COURSE',
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
		$form = $formBuilder->create('App\Forms\CourseForm', [
			'method' => 'POST',
			'action' => ['CourseController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'COURSE';
		$action = 'ADD';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.COURSE')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CourseRequest $request)
	{
		$data = $request->all();
		$course = new Course();
        $course->fromArray($data);
        $course->save();
		
        flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.COURSE')]);
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
        $course_arr = [];
		$course = CourseQuery::create()->findPK($id);
		$course_arr = $course->toArray();
		
		$form = $formBuilder->create('App\Forms\CourseForm', [
			'method' => 'PATCH',
			'action' => ['CourseController@update', $id],
			'model' => $course_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'COURSE';
		$action = 'EDIT';
		$path = $this->main_page;
		session(['attribute' => \Lang::get('general.COURSE')]);
        
		return view('manage', compact('form', 'form_name', 'action', 'path'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, CourseRequest $request)
	{
        $data = $request->all();
		$course = CourseQuery::create()->findPK($id);
        $course->fromArray($data);
        $course->save();
		
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.COURSE')]);
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
		$course = CourseQuery::create()->findPK($id);
		$course->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.COURSE')]);
		return redirect($this->main_page);
	}

}
