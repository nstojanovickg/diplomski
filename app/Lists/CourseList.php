<?php namespace App\Lists;

use App\Models\CourseQuery;

class CourseList extends BaseList {
	private $courses;
	
	/**
	 * Create a new CourseList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','name');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create Course list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$course_filter = $request->all();
		$this->handleFilterRequest($course_filter, 'course_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->courses->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->courses->paginate($page, $this->maxPerPage) as $key => $course){
			$course_id = $course->getId();
			$this->data_arr[$course_id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$course_id]['name'] = $course->getName();
	    }
    }
	
	/**
	 * Create Course query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->courses = CourseQuery::create();
        if(isset($array['Name']) && $array['Name'] !== "") $this->courses->where("course.name like '%".$array['Name']."%'");
        
		if($search) session(['course_filter' => $array]);
	}

}
