<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;
use App\Models\SubjectQuery;
use App\Models\CourseQuery;
use App\Models\SchoolYearQuery;

class ApplicationBySubjectFilter extends Form
{
    public function buildForm()
    {
        $status = \Auth::user()->getStatus();
        $this
            ->add('SubjectId', 'select', [
                'label' => 'Subject',
                'choices' => $this->getSubjects($status)
            ])
            ->add('CourseId', 'select', [
                'label' => 'Course',
                'choices' => $this->getCourses()
            ])
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'choices' => $this->getSchoolYears()
            ]);
    }
    
    private function getSubjects($status) {
		$subjects = SubjectQuery::create()->orderByName();
		if($status === 'professor') {
            $subjects->joinEngagement();
            $subjects->where('Engagement.professor_id = ?', \Auth::user()->getProfessorId());
        }
		else if($status === 'student') {
			$subjects->joinStudyProgram();
            $subjects->where('StudyProgram.course_id = ?', \Auth::user()->getStudent()->getCourseId());
        }
		$subjects->find();
        $subjects_arr = ['' => ''];
        foreach($subjects as $subject){
            $name = $subject->__toString();
            $id = $subject->getId();
            $subjects_arr[$id] = $name;
        }
		return $subjects_arr;
	}
	
    private function getCourses() {
		$courses = CourseQuery::create()->orderByName()->find();
        $courses_arr = ['' => ''];
        foreach($courses as $course){
            $name = $course->__toString();
            $id = $course->getId();
            $courses_arr[$id] = $name;
        }
		return $courses_arr;
	}
    
	private function getSchoolYears() {
		$schoolYears = SchoolYearQuery::create()->orderByYear('desc')->find();
        $school_years_arr = ['' => ''];
        foreach($schoolYears as $schoolYear){
            $name = $schoolYear->__toString();
            $id = $schoolYear->getId();
            $school_years_arr[$id] = $name;
        }
		return $school_years_arr;
	}
}