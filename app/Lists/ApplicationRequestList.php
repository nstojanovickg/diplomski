<?php namespace App\Lists;

use App\Models\ApplicationRequestQuery;

class ApplicationRequestList extends BaseList {
	
	/**
	 * Create a new ApplicationRequestList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','application_id', 'description', 'response', 'created_at');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create ApplicationRequest list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$application_request_filter = $request->all();
		$this->handleFilterRequest($application_request_filter, 'application_request_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->objects->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->objects->paginate($page, $this->maxPerPage) as $key => $application_request){
			$id = $application_request->getId();
			$this->data_arr[$id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$id]['application_id'] = $application_request->getApplicationId();
            $this->data_arr[$id]['description'] = $application_request->getDescription();
            $this->data_arr[$id]['response'] = $application_request->getResponse();
            $this->data_arr[$id]['created_at'] = $application_request->getCreatedAt();
	    }
    }
	
	/**
	 * Create ApplicationRequest query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->objects = ApplicationRequestQuery::create();
        
		if($search) session(['application_request_filter' => $array]);
	}

}
