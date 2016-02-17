<?php namespace App\Lists;

use App\Models\SchoolYearQuery;

class SchoolYearList extends BaseList {
	
	/**
	 * Create a new SchoolYearList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','year','date_start', 'date_end', 'description');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create SchoolYear list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$SchoolYear_filter = $request->all();
		$this->handleFilterRequest($SchoolYear_filter, 'SchoolYear_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->objects->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->objects->paginate($page, $this->maxPerPage) as $key => $schoolYear){
			$id = $schoolYear->getId();
			$this->data_arr[$id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$id]['year'] = $schoolYear->getYear();
            $this->data_arr[$id]['date_start'] = $schoolYear->getDateStart();
			$this->data_arr[$id]['date_end'] = $schoolYear->getDateEnd();
            $this->data_arr[$id]['description'] = $schoolYear->getDescription();
	    }
    }
	
	/**
	 * Create SchoolYear query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->objects = SchoolYearQuery::create();
        if(isset($array['Year']) && $array['Year'] !== "") $this->objects->where("SchoolYear.year = ?",$array['Year']);
        //if(isset($array['DateStart']) && $array['DateStart'] !== "") $this->objects->where("SchoolYear.date_start >= ?",$array['DateStart']);
        //if(isset($array['DateEnd']) && $array['DateEnd'] !== "") $this->objects->where("SchoolYear.date_end <= ?",$array['DateEnd']);
        if(isset($array['Description']) && $array['Description'] !== "") $this->objects->where("SchoolYear.description like '%".$array['Description']."%'");
        
		if($search) session(['SchoolYear_filter' => $array]);
	}

}
