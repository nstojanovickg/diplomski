<?php namespace App\Lists;

use App\Models\SubjectQuery;

class SubjectList extends BaseList {
	private $subjects;
	
	/**
	 * Create a new SubjectList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','name','code');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create Subject list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$subject_filter = $request->all();
		$this->handleFilterRequest($subject_filter, 'subject_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->subjects->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->subjects->paginate($page, $this->maxPerPage) as $key => $subject){
			$subject_id = $subject->getId();
			$this->data_arr[$subject_id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$subject_id]['name'] = $subject->getName();
			$this->data_arr[$subject_id]['code'] = $subject->getCode();
	    }
    }
	
	/**
	 * Create Subject query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->subjects = SubjectQuery::create()->orderByCode();
        if(isset($array['Name']) && $array['Name'] !== "") $this->subjects->where("subject.name like '%".$array['Name']."%'");
		if(isset($array['Code']) && $array['Code'] !== "") $this->subjects->where("subject.code like '%".$array['Code']."%'");
		
		if($search) session(['subject_filter' => $array]);
	}

}
