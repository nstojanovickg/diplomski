<?php namespace App\Lists;

use App\Models\ProfessorQuery;

class ProfessorList extends BaseList {
	private $professors;
	
	/**
	 * Create a new ProfessorList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','first_name', 'last_name');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create Professor list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$professor_filter = $request->all();
		$this->handleFilterRequest($professor_filter, 'professor_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->professors->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->professors->paginate($page, $this->maxPerPage) as $key => $professor){
			$professor_id = $professor->getId();
			$this->data_arr[$professor_id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$professor_id]['first_name'] = $professor->getFirstName();
            $this->data_arr[$professor_id]['last_name'] = $professor->getLastName();
	    }
    }
	
	/**
	 * Create Professor query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->professors = ProfessorQuery::create();
        if(isset($array['FirstName']) && $array['FirstName'] !== "") $this->professors->where("professor.first_name like '%".$array['FirstName']."%'");
        if(isset($array['LastName']) && $array['LastName'] !== "") $this->professors->where("professor.last_name like '%".$array['LastName']."%'");
        
		if($search) session(['professor_filter' => $array]);
	}

}
