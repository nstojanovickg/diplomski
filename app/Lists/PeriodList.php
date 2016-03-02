<?php namespace App\Lists;

use App\Models\PeriodSchoolYearQuery;

class PeriodList extends BaseList {
	private $periods;
	
	/**
	 * Create a new PeriodList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','period', 'school_year', 'date_start','date_end');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create Period list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$period_filter = $request->all();
		$this->handleFilterRequest($period_filter, 'period_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->objects->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->objects->paginate($page, $this->maxPerPage) as $key => $object){
			$id = $object->getPeriodId()."/".$object->getSchoolYearId();
			$this->data_arr[$id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$id]['period'] = $object->getPeriod()->__toString();
			$this->data_arr[$id]['school_year'] = $object->getSchoolYear()->__toString();
			$this->data_arr[$id]['date_start'] = $object->getDateStart();
			$this->data_arr[$id]['date_end'] = $object->getDateEnd();
	    }
    }
	
	/**
	 * Create Period query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->objects = PeriodSchoolYearQuery::create()
			->useSchoolYearQuery()
				->orderByYear('desc')
			->endUse()
			->usePeriodQuery()
				->orderBySequence()
			->endUse();
        if(isset($array['PeriodId']) && $array['PeriodId'] !== "") $this->objects->where("PeriodSchoolYear.period_id = ?",$array['PeriodId']);
        if(isset($array['SchoolYearId']) && $array['SchoolYearId'] !== "") $this->objects->where("PeriodSchoolYear.school_year_id = ?",$array['SchoolYearId']);
		
		if($search) session(['period_filter' => $array]);
	}

}
