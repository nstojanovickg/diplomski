<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;
use Propel\Runtime\Propel;
use App\Models\PeriodSchoolYearQuery;
use App\Models\ApplicationQuery;
use App\Models\StudyProgramQuery;

class DashboardController extends Controller {
    
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder)
	{
		$new_stats_arr = $courses = [];
		$period_year = null;
		$professor_id = null;
		$student_id = null;
		$user = \Auth::user();
		if($user->getStatus() === 'professor') $professor_id = $user->getProfessorId();
		else if($user->getStatus() === 'student') $student_id = $user->getStudentId();
		
		if($user->getStatus() !== 'student') {
			$stats_array = $this->getNewApplications($professor_id);
			$new_stats_arr = $stats_array['stats_arr'];
			$courses = $stats_array['courses'];
			$period_year = $stats_array['period_year'];
		}
		
		$stats_array = $this->getStatsArray($professor_id, $student_id);
		$stats_arr = $stats_array['stats_arr'];
		$years = $stats_array['years'];
		
		return view('dashboard',compact('stats_arr', 'years', 'new_stats_arr', 'courses', 'period_year'));
	}
	
	private function getStatsArray($professor_id, $student_id) {
		$new_periods = $this->getNewPeriodSchoolYears();
		
		$application_stats_arr = [];
		$years_arr = [];
		$applications = ApplicationQuery::create();
		$applications->join('Application.SchoolYear');
		$applications->orderByPeriodId();
		
		if(!is_null($professor_id)){
			$applications->join('Application.Student');
			$applications->join('Student.Course');
			$applications->join('Course.Engagement');
			$applications->where('Engagement.subject_id = Application.subject_id');
			$applications->where('Engagement.school_year_id = Application.school_year_id');
			$applications->where('Engagement.professor_id = ?',$professor_id);
		}
		if(!is_null($student_id))
			$applications->where('Application.student_id = ?',$student_id);
		foreach($applications as $application) {
			$school_year_id = $application->getSchoolYearId();
			$period_id = $application->getPeriodId();
			$flag = false;
			foreach($new_periods as $new_period) {
				if($period_id == $new_period['period_id'] && $school_year_id == $new_period['school_year_id']) {
					$flag = true; break;
				}
			}
			if($flag) continue;
			$year = $application->getSchoolYear()->__toString();
			$rok = $application->getPeriod()->__toString();
			if(!isset($years_arr[$year]))
				$years_arr[$year] = $year;
				
			if(!isset($application_stats_arr[$year][$rok])) {
				$application_stats_arr[$year][$rok]['polozili'] = 0;
				$application_stats_arr[$year][$rok]['pali'] = 0;
				$application_stats_arr[$year][$rok]['odustali'] = 0;
			}
			$application_stats_arr[$year][$rok]['rok'] = $application->getPeriod()->__toString();
			if($application->getExamScore() > 5)
				$application_stats_arr[$year][$rok]['polozili']++;
			else if($application->getExamScore() == 5)
				$application_stats_arr[$year][$rok]['pali']++;
			else
				$application_stats_arr[$year][$rok]['odustali']++;
		}
		
		$stats_arr = [];
		foreach($application_stats_arr as $year => $array) {
			foreach($array as $arr) {
				$stats_arr[$year][] = $arr;
			}
		}
		$years = array_values($years_arr);
		rsort($years);
		//echo "<pre>";print_r($stats_arr);die;
		$result['stats_arr'] = $stats_arr;
		$result['years'] = $years;
		return $result;
	}
	
	private function getNewApplications($professor_id) {
		$date = date('Y-m-d H:i:s');
		
		$period = PeriodSchoolYearQuery::create()
				->where('PeriodSchoolYear.date_start <= ?', $date)
				->where('PeriodSchoolYear.date_end >= ?', $date)
				->findOne();
		if(is_null($period)) return ['stats_arr' => [], 'courses' => [], 'period_year' => ''];
		
		$applications = ApplicationQuery::create()
				->where('Application.period_id = ?', $period->getPeriodId())
				->where('Application.school_year_id = ?', $period->getSchoolYearId());
		$applications->useStudentQuery()
			->useCourseQuery()
				->orderById()
			->endUse()
		->endUse();
		if(!is_null($professor_id)){
			$applications->join('Application.Student');
			$applications->join('Student.Course');
			$applications->join('Course.Engagement');
			$applications->where('Engagement.subject_id = Application.subject_id');
			$applications->where('Engagement.school_year_id = Application.school_year_id');
			$applications->where('Engagement.professor_id = ?',$professor_id);
		}
		else
			$study_programs_arr = $this->getSubjectYears();
		if(count($applications) == 0) return ['stats_arr' => [], 'courses' => [], 'period_year' => ''];
		
		$period_year = $period->getPeriod()->__toString().", ".$period->getSchoolYear()->__toString();
		$courses_arr = [];
		$application_stats_arr = [];
		foreach($applications as $application) {
			$course = $application->getStudent()->getCourse()->__toString();
			if(!isset($courses_arr[$course]))
				$courses_arr[$course] = $course;
				
			if(!is_null($professor_id)) {
				$subject = $application->getSubject()->__toString();
				if(!isset($application_stats_arr[$course][$subject])) 
					$application_stats_arr[$course][$subject]['prijavljeno'] = 0;
				$application_stats_arr[$course][$subject]['xkey'] = $subject;
				$application_stats_arr[$course][$subject]['prijavljeno']++;
			}
			else {
				$course_id = $application->getStudent()->getCourseId();
				$subject_id = $application->getSubjectId();
				$year = $study_programs_arr[$subject_id][$course_id].". godina";
				if(!isset($application_stats_arr[$course][$year])) 
					$application_stats_arr[$course][$year]['prijavljeno'] = 0;
				$application_stats_arr[$course][$year]['xkey'] = $year;
				$application_stats_arr[$course][$year]['prijavljeno']++;
			}
		}
		$stats_arr = [];
		foreach($application_stats_arr as $course => $array) {
			foreach($array as $arr) {
				$stats_arr[$course][] = $arr;
			}
		}
		$courses = array_values($courses_arr);
		
		$result['courses'] = $courses;
		$result['stats_arr'] = $stats_arr;
		$result['period_year'] = $period_year;
		return $result;
	}
	
	private function getSubjectYears() {
		$studyPrograms = StudyProgramQuery::create()->find();
		$study_programs_arr = [];
		foreach($studyPrograms as $studyProgram) {
			$study_programs_arr[$studyProgram->getSubjectId()][$studyProgram->getCourseId()] = $studyProgram->getYear();
		}
		return $study_programs_arr;
	}
	
	private function getNewPeriodSchoolYears() {
		$periodSchoolYears = PeriodSchoolYearQuery::create()
				->where('PeriodSchoolYear.date_end >= ?', date('Y-m-d'))
				->find();
		
		$periods = [];
		if(count($periodSchoolYears) == 0) return $periods;
		foreach($periodSchoolYears as $key => $periodSchoolYear){
			$periods[$key]['period_id'] = $periodSchoolYear->getPeriodId();
			$periods[$key]['school_year_id'] = $periodSchoolYear->getSchoolYearId();
		}
		//echo "<pre>";print_r($periods);die;
		return $periods;
	}

}
