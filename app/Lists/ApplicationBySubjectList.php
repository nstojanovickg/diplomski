<?php namespace App\Lists;

use App\Models\ApplicationQuery;
use App\Models\EngagementQuery;

class ApplicationBySubjectList extends BaseList {

	/**
	 * Create a new ApplicationList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','subject','course','school_year','number_of_applications', 'success_rate', 'details');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create Application list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$object_filter = $request->all();
		$this->handleFilterRequest($object_filter, 'application_by_subject_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->objects->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->objects->paginate($page, $this->maxPerPage) as $key => $object){
            //dd($object);
			$id = $key;
			$this->data_arr[$id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$id]['subject'] = $object['Subject.Name'];
			$this->data_arr[$id]['course'] = $object['Course.Name'];
			$this->data_arr[$id]['school_year'] = $object['SchoolYear.Year'];
			$this->data_arr[$id]['number_of_applications'] = $object['ApplicationsNumber'];
			$this->data_arr[$id]['success_rate'] = $object['SuccessRate'];
            $this->data_arr[$id]['details'] = "<a href='javascript:void(0)' id='subject_applications' onclick='showApplicationModal(".$object['SubjectId'].",".$object['SchoolYearId'].",".$object['Course.Id'].")' title=''><span class='btn btn-xs btn-success glyphicon glyphicon-new-window' data-toggle='modal' data-target='#application_modal'></span></a>";
        }
    }
	
	/**
	 * Create Application query.
	 *
	 */
	protected function createQuery($array, $search){
        $this->objects = ApplicationQuery::create()
            ->withColumn('COUNT(*)', 'ApplicationsNumber')
            ->withColumn('case when Application.exam_score > 5 then count(*) end', 'SuccessRate')
            ->select(['Subject.Name', 'SchoolYear.Year','Course.Name','Course.Id','SubjectId', 'SchoolYearId', 'ApplicationsNumber', 'SuccessRate'])
            ->useSubjectQuery()
                ->groupByName()
            ->endUse()
			->useStudentQuery()
				->useCourseQuery()
					->groupByName()
				->endUse()
			->endUse()
            ->useSchoolYearQuery()
                ->groupByYear()
                ->orderByYear('desc')
            ->endUse()
            ->useSubjectQuery()
                ->orderByName()
            ->endUse();
		
		if(isset($array['SubjectId']) && $array['SubjectId'] !== "") $this->objects->where("application.subject_id = ?",$array['SubjectId']);
		if(isset($array['CourseId']) && $array['CourseId'] !== "") {
			$this->objects->useStudentQuery()
				->where("Student.course_id = ?",$array['CourseId'])
			->endUse();
		}
		if(isset($array['SchoolYearId']) && $array['SchoolYearId'] !== "") $this->objects->where("application.school_year_id = ?",$array['SchoolYearId']);
        
		if($search) session(['application_by_subject_filter' => $array]);
	}

}
