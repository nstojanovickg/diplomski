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
		
		$form_filter = $formBuilder->create('App\Filters\EngagementFilter', [
			'method' => 'PATCH',
			'action' => ['EngagementController@index'],
			'model'  => $filter
		]);
		
		session(['attribute' => \Lang::get('general.ENGAGEMENTS')]);
		session(['attribute' => \Lang::get('general.ENGAGEMENT')]);
        
		return view('list', [
								'controller' => 'EngagementController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'ENGAGEMENT',
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
		$action = 'ADD';
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
	public function edit($pid, $sid, $cid, $syid, FormBuilder $formBuilder)
	{
		if(!isset($pid) || !isset($sid) || !isset($cid) || !isset($syid))
			return redirect($this->main_page);
		
        $engagement_arr = [];
		$engagement = EngagementQuery::create()->findPK([$pid, $sid, $cid, $syid]);
		$engagement_arr = $engagement->toArray();
		$period_arr['ProfessorIdOrig'] = $engagement->getProfessorId();
		$period_arr['SubjectIdOrig'] = $engagement->getSubjectId();
		$period_arr['CourseIdOrig'] = $engagement->getCourseId();
		$period_arr['SchoolYearIdOrig'] = $engagement->getSchoolYearId();
		
		$form = $formBuilder->create('App\Forms\EngagementForm', [
			'method' => 'PATCH',
			'action' => ['EngagementController@update', $pid, $sid, $cid, $syid],
			'model' => $engagement_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'ENGAGEMENT';
		$action = 'EDIT';
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
	public function update($pid, $sid, $cid, $syid, EngagementRequest $request)
	{
        $data = $request->all();
		$con = Propel::getConnection();
		$sql = "update engagement set
			professor_id = ".$data['ProfessorId'].",
			subject_id = ".$data['SubjectId'].",
			course_id = ".$data['CourseId'].",
			school_year_id = ".$data['SchoolYearId']."
		where professor_id = $pid and subject_id = $sid and course_id = $cid and school_year_id = $syid;";
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
	public function destroy($pid, $sid, $cid, $syid)
	{
		$engagement = EngagementQuery::create()->findPK([$pid, $sid, $cid, $syid]);
		$engagement->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.ENGAGEMENT')]);
		return redirect($this->main_page);
	}

}
