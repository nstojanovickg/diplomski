<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\StudentQuery;
use App\Models\Student;
use App\Http\Requests\StudentRequest;
use App\Lists\StudentList;

class StudentController extends Controller {
    private $main_page = 'basic/student';
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$studentList = new StudentList($request,$this->main_page,$page);
		
		$keys = $studentList->getKeys();
		$data_arr = $studentList->getDataArr();
		$paginationForm = $studentList->getPaginationForm();
		$filter = session('student_filter');
		session(['attribute' => \Lang::get('general.STUDENT_OBJ')]);
		
		$form_filter = $formBuilder->create('App\Filters\StudentFilter', [
			'method' => 'PATCH',
			'action' => ['StudentController@index'],
			'model'  => $filter,
			'class'  => 'form-inline'
		]);
        
		return view('list', [
								'controller' => 'StudentController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'STUDENTS',
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
		$form = $formBuilder->create('App\Forms\StudentForm', [
			'method' => 'POST',
			'action' => ['StudentController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'STUDENT';
		$action = 'ADD_OBJ';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.STUDENT_OBJ')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StudentRequest $request)
	{
		$data = $request->all();
		$student = new Student();
		$student->fromArray($data);
        $student->save();
		
		flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.STUDENT')]);
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
        $student_arr = [];
		$student = StudentQuery::create()->findPK($id);
		$student_arr = $student->toArray();
		$student_arr['IdentificationNumberOrig'] = $student->getIdentificationNumber();
		$student_arr['SchoolYearIdOrig'] = $student->getSchoolYearId();
		
		$form = $formBuilder->create('App\Forms\StudentForm', [
			'method' => 'PATCH',
			'action' => ['StudentController@update', $id],
			'model' => $student_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'STUDENT';
		$action = 'EDIT_OBJ';
		$path = $this->main_page;
		session(['attribute' => \Lang::get('general.STUDENT_OBJ')]);
        
		return view('manage', compact('form', 'form_name', 'action', 'path'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, StudentRequest $request)
	{
        $data = $request->all();
		$student = StudentQuery::create()->findPK($id);
		$student->fromArray($data);
        $student->save();
		
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.STUDENT')]);
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
		$student = StudentQuery::create()->findPK($id);
		$student->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.STUDENT')]);
		return redirect($this->main_page);
	}

}
