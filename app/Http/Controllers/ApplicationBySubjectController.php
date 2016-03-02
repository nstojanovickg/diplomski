<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use App\Models\ApplicationQuery;
use App\Models\SubjectQuery;
use App\Models\CourseQuery;
use App\Models\SchoolYearQuery;
use App\Models\EngagementQuery;

use App\Lists\ApplicationBySubjectList;

class ApplicationBySubjectController extends Controller {
    private $main_page = 'additional_info/application_by_subject';
        
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$applicationBySubjectList = new ApplicationBySubjectList($request,$this->main_page,$page);
		
		$keys = $applicationBySubjectList->getKeys();
		$data_arr = $applicationBySubjectList->getDataArr();
		$paginationForm = $applicationBySubjectList->getPaginationForm();
		$filter = session('application_by_subject_filter');
		
		$form_filter = $formBuilder->create('App\Filters\ApplicationBySubjectFilter', [
			'method' => 'PATCH',
			'action' => ['ApplicationBySubjectController@index'],
			'model'  => $filter,
			'class'  => 'form-inline'
		]);
        
		return view('list', [
								'controller' => 'ApplicationBySubjectController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'APPLICATION_BY_SUBJECTS',
								'filter' => $form_filter,
								'pagination' => $paginationForm,
								'add' => false,
								'additional_info' => false,
                                'back' => false,
                                'parent_table_id' => false,
								'edit' => false,
								'delete' => false,
								'modal' => true
							]);
	}

	public function getApplications($subject_id, $school_year_id, $course_id) {
		$subject = SubjectQuery::create()->findPk($subject_id);
		$course = CourseQuery::create()->findPk($course_id);
		$schoolYear = SchoolYearQuery::create()->findPk($school_year_id);
		$applications = ApplicationQuery::create()
			->where('Application.subject_id = ?', $subject_id)
			->where('Application.school_year_id = ?', $school_year_id)
			->join('Application.Student')
			->join('Application.Period')
			->where('Student.course_id = ?', $course_id)
			/*
			->join('Student.Course')
			->join('Course.Engagement')
			->join('Engagement.Professor')
			->where('Engagement.subject_id = Application.subject_id')
			->where('Engagement.school_year_id = Application.school_year_id')
			*/
			->select(['Student.FirstName','Student.LastName','Student.CourseId',//'Professor.FirstName','Professor.LastName',
					  'Period.Name','ApplicationDate','ExamDate','ExamTime', 'ExamScore'])
			->find();
		//dd($applications);
		$applications_arr = [];
		$cnt = 0;
		foreach($applications as $key => $application) {
			$professor = $this->getProfessorName($subject_id, $application['Student.CourseId'], $school_year_id);
			$applications_arr[$professor][$cnt]['student'] = $application['Student.FirstName']. ' ' .$application['Student.LastName'];
			$applications_arr[$professor][$cnt]['period'] = $application['Period.Name'];
			$applications_arr[$professor][$cnt]['application_date'] = $application['ApplicationDate'];
			$applications_arr[$professor][$cnt]['exam_datetime'] = $application['ExamDate']." ".$application['ExamTime'];;
			$applications_arr[$professor][$cnt]['exam_score'] = isset($application['ExamScore']) && $application['ExamScore'] != 0 ? $application['ExamScore'] : '';
			$cnt++;
		}
		
		$result['data'] = $applications_arr;
		$result['course'] = $course->__toString();
		$result['subject'] = $subject->__toString();
		$result['school_year'] = $schoolYear->__toString();
		
		
		return $result;
	}
	
	private function getProfessorName($subject_id, $course_id, $school_year_id) {
		$engagement = EngagementQuery::create()->findPk([$subject_id, $course_id, $school_year_id]);
		if($engagement)
			return $engagement->getProfessor()->toString();
		return "Not in schedule";
	}

}
