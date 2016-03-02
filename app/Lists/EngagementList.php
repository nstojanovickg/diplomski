<?php namespace App\Lists;

use App\Models\EngagementQuery;

class EngagementList extends BaseList {
	
	/**
	 * Create a new EngagementList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','professor','subject','course','school_year_id');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create Engagement list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$object_filter = $request->all();
		$this->handleFilterRequest($object_filter, 'engagement_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->objects->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->objects->paginate($page, $this->maxPerPage) as $key => $object){
			$id = $object->getSubjectId().'/'.$object->getCourseId().'/'.$object->getSchoolYearId();
			$this->data_arr[$id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$id]['professor'] = $object->getProfessor()->toString();
            $this->data_arr[$id]['subject'] = $object->getSubject()->__toString();
            $this->data_arr[$id]['course'] = $object->getCourse()->__toString();
			$this->data_arr[$id]['school_year_id'] = $object->getSchoolYear()->__toString();
	    }
    }
	
	/**
	 * Create Engagement query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->objects = EngagementQuery::create()
			->useSchoolYearQuery()
				->orderByYear('desc')
			->endUse()
			->useCourseQuery()
				->orderByName()
			->endUse()
			->useSubjectQuery()
				->orderByName()
			->endUse();
		if(\Auth::user()->getStatus() == 'professor'){
			$professor_id = \Auth::user()->getProfessorId();
			$this->objects->where("engagement.professor_id = ?",$professor_id);
		}
		else
			if(isset($array['ProfessorId']) && $array['ProfessorId'] !== "") $this->objects->where("engagement.professor_id = ?",$array['ProfessorId']);
        if(isset($array['SubjectId']) && $array['SubjectId'] !== "") $this->objects->where("engagement.subject_id = ?",$array['SubjectId']);
        if(isset($array['CourseId']) && $array['CourseId'] !== "") $this->objects->where("engagement.course_id = ?",$array['CourseId']);
        if(isset($array['SchoolYearId']) && $array['SchoolYearId'] !== "") $this->objects->where("engagement.school_year_id = ?",$array['SchoolYearId']);
        
		if($search) session(['engagement_filter' => $array]);
	}

}
