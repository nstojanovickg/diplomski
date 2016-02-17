<?php namespace App\Lists;

use App\Models\StudyProgramQuery;

class StudyProgramList extends BaseList {
	
    /**
	 * Create a new StudyProgramList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','subject', 'course', 'year','semester');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create StudyProgram list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$study_program_filter = $request->all();
		$this->handleFilterRequest($study_program_filter, 'study_program_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->objects->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->objects->paginate($page, $this->maxPerPage) as $key => $object){
			$id = $object->getSubjectId()."/".$object->getCourseId();
			$this->data_arr[$id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$id]['subject'] = $object->getSubject()->__toString();
			$this->data_arr[$id]['course'] = $object->getCourse()->__toString();
			$this->data_arr[$id]['year'] = $object->getYear();
			$this->data_arr[$id]['semester'] = $object->getSemester();
	    }
    }
	
	/**
	 * Create StudyProgram query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->objects = StudyProgramQuery::create();
        if(isset($array['SubjectId']) && $array['SubjectId'] !== "") $this->objects->where("StudyProgram.subject_id = ?",$array['SubjectId']);
        if(isset($array['CourseId']) && $array['CourseId'] !== "") $this->objects->where("StudyProgram.course_id = ?",$array['CourseId']);
		if(isset($array['Year']) && $array['Year'] !== "") $this->objects->where("StudyProgram.year = ?",$array['Year']);
        if(isset($array['Semester']) && $array['Semester'] !== "") $this->objects->where("StudyProgram.semester = ?",$array['Semester']);
		
		if($search) session(['study_program_filter' => $array]);
	}

}
