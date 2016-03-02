<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\StudyProgramQuery;
use App\Models\StudyProgram;
use App\Http\Requests\StudyProgramRequest;
use App\Lists\StudyProgramList;
use Propel\Runtime\Propel;

class StudyProgramController extends Controller {
    private $main_page = 'basic/study_program';
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$study_programList = new StudyProgramList($request,$this->main_page,$page);
		
		$keys = $study_programList->getKeys();
		$data_arr = $study_programList->getDataArr();
		$paginationForm = $study_programList->getPaginationForm();
		$filter = session('study_program_filter');
		
		$form_filter = $formBuilder->create('App\Filters\StudyProgramFilter', [
			'method' => 'PATCH',
			'action' => ['StudyProgramController@index'],
			'model'  => $filter,
			'class'  => 'form-inline'
		]);
		
		session(['attribute' => \Lang::get('general.STUDY_PROGRAM')]);
        
		return view('list', [
								'controller' => 'StudyProgramController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'STUDY_PROGRAM',
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
		$form = $formBuilder->create('App\Forms\StudyProgramForm', [
			'method' => 'POST',
			'action' => ['StudyProgramController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'STUDY_PROGRAM';
		$action = 'ADD_OBJ';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.STUDY_PROGRAM')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(StudyProgramRequest $request)
	{
		$data = $request->all();
		$study_program = new StudyProgram();
        $study_program->fromArray($data);
        $study_program->save();
		
		flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.STUDY_PROGRAM')]);
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
	public function edit($subject_id, $course_id, FormBuilder $formBuilder)
	{
        $study_program_arr = [];
		$study_program = StudyProgramQuery::create()->findPK([$subject_id, $course_id]);
		$study_program_arr = $study_program->toArray();
        $study_program_arr['SubjectIdOrig'] = $study_program->getSubjectId();
		$study_program_arr['CourseIdOrig'] = $study_program->getCourseId();
		
		$form = $formBuilder->create('App\Forms\StudyProgramForm', [
			'method' => 'PATCH',
			'action' => ['StudyProgramController@update', $subject_id, $course_id],
			'model' => $study_program_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'STUDY_PROGRAM';
		$action = 'EDIT_OBJ';
		$path = $this->main_page;
		session(['attribute' => \Lang::get('general.STUDY_PROGRAM')]);
        
		return view('manage', compact('form', 'form_name', 'action', 'path'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($subject_id, $course_id, StudyProgramRequest $request)
	{
        $data = $request->all();
		$con = Propel::getConnection();
		$sql = "update study_program set
			subject_id = ".$data['SubjectId'].",
			course_id = ".$data['CourseId'].",
			year = '".$data['Year']."',
			semester = '".$data['Semester']."'
		where subject_id = $subject_id and course_id = $course_id;";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.STUDY_PROGRAM')]);
		return redirect($this->main_page);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($subject_id, $course_id)
	{
		$study_program = StudyProgramQuery::create()->findPK([$subject_id, $course_id]);
		$study_program->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.STUDY_PROGRAM')]);
		return redirect($this->main_page);
	}

}
