<?php namespace App\Lists;

use App\Models\ApplicationQuery;
use App\Models\EngagementQuery;

class ApplicationList extends BaseList {

	/**
	 * Create a new ApplicationList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','student','subject','period','school_year_id','application_date','exam_date','exam_score');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create Application list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$object_filter = $request->all();
		$this->handleFilterRequest($object_filter, 'application_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->objects->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->objects->paginate($page, $this->maxPerPage) as $key => $object){
			$id = $object->getId();
			$this->data_arr[$id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$id]['student'] = $object->getStudent()->__toString();
			$this->data_arr[$id]['subject'] = $object->getSubject()->__toString();
			$this->data_arr[$id]['period'] = $object->getPeriod()->__toString();
			$this->data_arr[$id]['school_year_id'] = $object->getSchoolYear()->__toString();
			//$this->data_arr[$id]['oral_exam_invitation_id'] = !is_null($object->getOralExamInvitationId()) ? $object->getOralExamInvitation()->__toString() : '';
			$this->data_arr[$id]['application_date'] = $object->getApplicationDate();//->format('Y-m-d H:i:s');
			$this->data_arr[$id]['exam_date'] = $object->getExamDate();
			$this->data_arr[$id]['exam_score'] = $object->getExamScore();
	    }
    }
	
	/**
	 * Create Application query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->objects = ApplicationQuery::create();
		$this->objects->join('Application.Subject');
		$this->objects->join('Application.SchoolYear');
		$this->objects->join('Application.Student');
		$this->objects->join('Student.Course');
		//$c->addJoin(BookTableMap::AUTHOR_ID, AuthorTableMap::ID, Criteria::INNER_JOIN);
		$this->objects->join('Course.Engagement');
		$this->objects->where('Engagement.subject_id = subject.id');
		$this->objects->where('Engagement.school_year_id = school_year.id');
		
		if(isset($array['StudentId']) && $array['StudentId'] !== "") $this->objects->where("application.student_id = ".$array['StudentId']);
		if(isset($array['SubjectId']) && $array['SubjectId'] !== "") $this->objects->where("application.subject_id = ".$array['SubjectId']);
		if(isset($array['ProfessorId']) && $array['ProfessorId'] !== "") $this->objects->where('Engagement.ProfessorId = ?', $array['ProfessorId']);
		if(\Auth::user()->getStatus() == 'professor'){
			$professor_id = \Auth::user()->getProfessorId();
			$this->objects->where('Engagement.ProfessorId = ?', $professor_id);
		}
		else if(\Auth::user()->getStatus() == 'student'){
			$student_id = \Auth::user()->getStudentId();
			$this->objects->where('Application.student_id = ?', $student_id);
		}
		if(isset($array['PeriodId']) && $array['PeriodId'] !== "") $this->objects->where("application.period_id = ".$array['PeriodId']);
        if(isset($array['SchoolYearId']) && $array['SchoolYearId'] !== "") $this->objects->where("application.school_year_id = ".$array['SchoolYearId']);
        //if(isset($array['OralExamInvitationId']) && $array['OralExamInvitationId'] !== "") $this->objects->where("application.oral_exam_invitation_id = ".$array['OralExamInvitationId']);
        if(isset($array['ApplicationDateFrom']) && $array['ApplicationDateFrom'] !== "") $this->objects->where("application.application_date >= '".$array['ApplicationDateFrom']."'");
        if(isset($array['ApplicationDateTo']) && $array['ApplicationDateTo'] !== "") $this->objects->where("application.application_date >= '".$array['ApplicationDateTo']."'");
        if(isset($array['ExamDateFrom']) && $array['ExamDateFrom'] !== "") $this->objects->where("application.exam_date >= '".$array['ExamDateFrom']."'");
        if(isset($array['ExamDateTo']) && $array['ExamDateTo'] !== "") $this->objects->where("application.exam_date >= '".$array['ExamDateTo']."'");
		if(isset($array['ExamScore']) && $array['ExamScore'] !== "") $this->objects->where("application.exam_score = ".$array['ExamScore']);
		
		if($search) session(['application_filter' => $array]);
	}

}
