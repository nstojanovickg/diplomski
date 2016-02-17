<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Models\PeriodSchoolYearQuery;
use App\Models\PeriodSchoolYear;
use App\Http\Requests\PeriodRequest;
use App\Lists\PeriodList;
use Propel\Runtime\Propel;

class PeriodController extends Controller {
    private $main_page = 'basic/period';
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$periodList = new PeriodList($request,$this->main_page,$page);
		
		$keys = $periodList->getKeys();
		$data_arr = $periodList->getDataArr();
		$paginationForm = $periodList->getPaginationForm();
		$filter = session('period_filter');
		
		$form_filter = $formBuilder->create('App\Filters\PeriodFilter', [
			'method' => 'PATCH',
			'action' => ['PeriodController@index'],
			'model'  => $filter
		]);
		
		session(['attribute' => \Lang::get('general.PERIODS')]);
		session(['attribute' => \Lang::get('general.PERIOD')]);
        
		return view('list', [
								'controller' => 'PeriodController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'PERIOD',
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
		$form = $formBuilder->create('App\Forms\PeriodForm', [
			'method' => 'POST',
			'action' => ['PeriodController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'PERIOD';
		$action = 'ADD';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.PERIOD')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(PeriodRequest $request)
	{
		$data = $request->all();
		$period = new PeriodSchoolYear();
        $period->fromArray($data);
        $period->save();
		
		flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.PERIOD')]);
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
	public function edit($period_id, $school_year_id, FormBuilder $formBuilder)
	{
        $period_arr = [];
		$period = PeriodSchoolYearQuery::create()->findPK([$period_id, $school_year_id]);
		$period_arr = $period->toArray();
		$period_arr['PeriodIdOrig'] = $period->getPeriodId();
		$period_arr['SchoolYearIdOrig'] = $period->getSchoolYearId();
		
		$form = $formBuilder->create('App\Forms\PeriodForm', [
			'method' => 'PATCH',
			'action' => ['PeriodController@update', $period_id, $school_year_id],
			'model' => $period_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'PERIOD';
		$action = 'EDIT';
		$path = $this->main_page;
		session(['attribute' => \Lang::get('general.PERIOD')]);
        
		return view('manage', compact('form', 'form_name', 'action', 'path'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($period_id, $school_year_id, PeriodRequest $request)
	{
        $data = $request->all();
		$con = Propel::getConnection();
		$sql = "update period_school_year set
			period_id = ".$data['PeriodId'].",
			school_year_id = ".$data['SchoolYearId'].",
			date_start = '".$data['DateStart']."',
			date_end = '".$data['DateEnd']."'
		where period_id = $period_id and school_year_id = $school_year_id;";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.PERIOD')]);
		return redirect($this->main_page);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($period_id, $school_year_id)
	{
		$period = PeriodSchoolYearQuery::create()->findPK([$period_id, $school_year_id]);
		$period->delete();
		
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.PERIOD')]);
		return redirect($this->main_page);
	}

}
