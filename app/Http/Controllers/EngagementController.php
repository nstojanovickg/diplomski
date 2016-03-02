<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\EngagementQuery;
use App\Models\Engagement;
use App\Http\Requests\EngagementRequest;
use App\Lists\EngagementList;
use Propel\Runtime\Propel;

class EngagementController extends Controller {
    private $main_page = 'engagement/engagement';
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$engagementList = new EngagementList($request,$this->main_page,$page);
		
		$keys = $engagementList->getKeys();
		$data_arr = $engagementList->getDataArr();
		$paginationForm = $engagementList->getPaginationForm();
		$filter = session('engagement_filter');
		session(['attribute' => \Lang::get('general.ENGAGEMENT')]);
		
		$form_filter = $formBuilder->create('App\Filters\EngagementFilter', [
			'method' => 'PATCH',
			'action' => ['EngagementController@index'],
			'model'  => $filter,
			'class'  => 'form-inline'
		]);
        
		return view('list', [
								'controller' => 'EngagementController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'ENGAGEMENTS',
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
		$form = $formBuilder->create('App\Forms\EngagementForm', [
			'method' => 'POST',
			'action' => ['EngagementController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'ENGAGEMENT';
		$action = 'ADD_OBJ';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.ENGAGEMENT')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EngagementRequest $request)
	{
		$data = $request->all();
		$engagement = new Engagement();
        $engagement->fromArray($data);
        $engagement->save();
		
		flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.ENGAGEMENT')]);
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
	public function edit($sid, $cid, $syid, FormBuilder $formBuilder)
	{
		if(!isset($sid) || !isset($cid) || !isset($syid))
			return redirect($this->main_page);
		
        $engagement_arr = [];
		$engagement = EngagementQuery::create()->findPK([$sid, $cid, $syid]);
		$engagement_arr = $engagement->toArray();
		$engagement_arr['SubjectIdOrig'] = $engagement->getSubjectId();
		$engagement_arr['CourseIdOrig'] = $engagement->getCourseId();
		$engagement_arr['SchoolYearIdOrig'] = $engagement->getSchoolYearId();
		
		$form = $formBuilder->create('App\Forms\EngagementForm', [
			'method' => 'PATCH',
			'action' => ['EngagementController@update', $sid, $cid, $syid],
			'model' => $engagement_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'ENGAGEMENT';
		$action = 'EDIT_OBJ';
		$path = $this->main_page;
		session(['attribute' => \Lang::get('general.ENGAGEMENT')]);
        
		return view('manage', compact('form', 'form_name', 'action', 'path'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($sid, $cid, $syid, EngagementRequest $request)
	{
        $data = $request->all();
		$con = Propel::getConnection();
		$sql = "update engagement set
			professor_id = ".$data['ProfessorId'].",
			subject_id = ".$data['SubjectId'].",
			course_id = ".$data['CourseId'].",
			school_year_id = ".$data['SchoolYearId']."
		where subject_id = $sid and course_id = $cid and school_year_id = $syid;";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.ENGAGEMENT')]);
		return redirect($this->main_page);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($sid, $cid, $syid)
	{
		$engagement = EngagementQuery::create()->findPK([$sid, $cid, $syid]);
		$engagement->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.ENGAGEMENT')]);
		return redirect($this->main_page);
	}

}
