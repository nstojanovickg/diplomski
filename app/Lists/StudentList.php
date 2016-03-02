<?php namespace App\Lists;

use App\Models\StudentQuery;

class StudentList extends BaseList {
	
	/**
	 * Create a new StudentList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','id_num/year','course','first_name', 'last_name','birth_place', 'birthday', 'phone');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create Student list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$object_filter = $request->all();
		$this->handleFilterRequest($object_filter, 'student_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->objects->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->objects->paginate($page, $this->maxPerPage) as $key => $object){
			$id = $object->getId();
			$this->data_arr[$id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$id]['id_num/year'] = $object->getIdentificationNumber()."/".$object->getSchoolYear()->__toString();
            $this->data_arr[$id]['course'] = $object->getCourse()->__toString();
            $this->data_arr[$id]['first_name'] = $object->getFirstName();
            $this->data_arr[$id]['last_name'] = $object->getLastName();
            $this->data_arr[$id]['birth_place'] = $object->getBirthPlace();
            $this->data_arr[$id]['birthday'] = $object->getBirthday();
			$this->data_arr[$id]['phone'] = $object->getPhoneNumber();
	    }
    }
	
	/**
	 * Create Student query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->objects = StudentQuery::create()
			->useSchoolYearQuery()
				->orderByYear('desc')
			->endUse()
			->orderByIdentificationNumber();
        if(isset($array['IdentificationNumber']) && $array['IdentificationNumber'] !== "") $this->objects->where("student.identification_number = ?",$array['IdentificationNumber']);
        if(isset($array['SchoolYearId']) && $array['SchoolYearId'] !== "") $this->objects->where("student.school_year_id = ?", $array['SchoolYearId']);
        if(isset($array['CourseId']) && $array['CourseId'] !== "") $this->objects->where("student.course_id = '".$array['CourseId']."'");
        if(isset($array['FirstName']) && $array['FirstName'] !== "") $this->objects->where("student.first_name like '%".$array['FirstName']."%'");
        if(isset($array['LastName']) && $array['LastName'] !== "") $this->objects->where("student.last_name like '%".$array['LastName']."%'");
        if(isset($array['BirthPlace']) && $array['BirthPlace'] !== "") $this->objects->where("student.birth_place like '%".$array['BirthPlace']."%'");
        if(isset($array['BirthdayFrom']) && $array['BirthdayFrom'] !== "") $this->objects->where("student.birthday >= ?",$array['BirthdayFrom']);
        if(isset($array['BirthdayTo']) && $array['BirthdayTo'] !== "") $this->objects->where("student.birthday <= ?",$array['BirthdayTo']);
		if(isset($array['PhoneNumber']) && $array['PhoneNumber'] !== "") $this->objects->where("student.phone_number like '%".$array['PhoneNumber']."%'");
        
		if($search) session(['student_filter' => $array]);
	}

}
