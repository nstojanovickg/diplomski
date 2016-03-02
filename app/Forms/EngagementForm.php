<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\ProfessorQuery;
use App\Models\SubjectQuery;
use App\Models\CourseQuery;
use App\Models\SchoolYearQuery;

class EngagementForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('ProfessorId', 'select', [
                'label' => 'Professor',
                'choices' => $this->getProfessors()
            ])
            ->add('SubjectId', 'select', [
                'label' => 'Subject',
                'choices' => $this->getSubjects()
            ])
            ->add('SubjectIdOrig', 'hidden')
            ->add('CourseId', 'select', [
                'label' => 'Course',
                'choices' => $this->getCourses()
            ])
            ->add('CourseIdOrig', 'hidden')
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'choices' => $this->getSchoolYears()
            ])
            ->add('SchoolYearIdOrig', 'hidden');
    }
    
	private function getProfessors() {
		$professors = ProfessorQuery::create()->orderByLastName()->orderByFirstName()->find();
		$professors_arr = [];
		foreach($professors as $professor){
			$name = $professor->toString(true);
			$id = $professor->getId();
			$professors_arr[$id] = $name;
		}
		return $professors_arr;
	}
	
	private function getSubjects() {
		$subjects = SubjectQuery::create()->orderByName()->find();
        $subjects_arr = [];
        foreach($subjects as $subject){
            $name = $subject->__toString();
            $id = $subject->getId();
            $subjects_arr[$id] = $name;
        }
		return $subjects_arr;
	}
	
	private function getCourses() {
		$courses = CourseQuery::create()->orderByName()->find();
        $courses_arr = [];
        foreach($courses as $course){
            $name = $course->__toString();
            $id = $course->getId();
            $courses_arr[$id] = $name;
        }
		return $courses_arr;
	}
	
	private function getSchoolYears() {
		$schoolYears = SchoolYearQuery::create()->orderByYear('desc')->find();
        $school_years_arr = [];
        foreach($schoolYears as $schoolYear){
            $name = $schoolYear->__toString();
            $id = $schoolYear->getId();
            $school_years_arr[$id] = $name;
        }
		return $school_years_arr;
	}
}