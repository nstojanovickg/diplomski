<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;
use App\Models\StudentQuery;
use App\Models\SubjectQuery;
use App\Models\PeriodQuery;
use App\Models\SchoolYearQuery;
use App\Models\ProfessorQuery;
use App\Models\OralExamInvitationQuery;

class ApplicationFilter extends Form
{
    public function buildForm()
    {
        $status = \Auth::user()->getStatus();
        if($status !== 'professor'){
            $this
            ->add('ProfessorId', 'select', [
                'label' => 'Professor',
                'choices' => $this->getProfessors($status)
            ]);
        }
        if($status !== 'student'){
            $this
            ->add('StudentId', 'select', [
                'label' => 'Student',
                'choices' => $this->getStudents($status)
            ]);
        }
        $this
            ->add('SubjectId', 'select', [
                'label' => 'Subject',
                'choices' => $this->getSubjects($status)
            ])
            ->add('PeriodId', 'select', [
                'label' => 'Period',
                'choices' => $this->getPeriods()
            ])
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'choices' => $this->getSchoolYears()
            ])
            ->add('ApplicationDateFrom', 'datepicker',[
                'label' => 'Application Date From',
                'date' => true
            ])
            ->add('ApplicationDateTo', 'datepicker',[
                'label' => 'Application Date To',
                'date' => true
            ])
            ->add('ExamDateFrom', 'datepicker',[
                'label' => 'Exam Date From',
                'date' => true
            ])
            ->add('ExamDateTo', 'datepicker',[
                'label' => 'Exam Date To',
                'date' => true
            ])
            ->add('ExamTime', 'time',[
                'label' => 'Exam Time'
            ])
            ->add('ExamScore', 'number',[
                'label' => 'Exam Score'
            ]);
    }
	
    private function getProfessors($status) {
		$professors = ProfessorQuery::create()->orderByLastName()->orderByFirstName();
		if($status === 'student'){
			$course_id = \Auth::user()->getStudent()->getCourseId();
			$professors->joinEngagement();
			$professors->where('Engagement.course_id = ?', $course_id);
		}
		$professors->find();
		$professors_arr = ['' => ''];
		foreach($professors as $professor) {
			$name = $professor->toString(true);
			$id = $professor->getId();
			$professors_arr[$id] = $name;
		}
		return $professors_arr;
    }
    
    private function getStudents($status) {
		$students = StudentQuery::create()
			->useSchoolYearQuery()
				->orderByYear('desc')
			->endUse()
			->orderByIdentificationNumber();
		if($status === 'professor') {
			$students->join('Student.Course');
			$students->join('Course.Engagement');
			$students->where('Engagement.professor_id = ?', \Auth::user()->getProfessorId());
		}
		$students
			->orderByIdentificationNumber()->find();
		$students_arr = ['' => ''];
		foreach($students as $student){
			$name = $student->__toString();
			$id = $student->getId();
			$students_arr[$id] = $name;
		}
		return $students_arr;
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
	
	private function getPeriods() {
		$periods = PeriodQuery::create()->orderBySequence()->find();
        $periods_arr = ['' => ''];
        foreach($periods as $period){
            $name = $period->__toString();
            $id = $period->getId();
            $periods_arr[$id] = $name;
        }
		return $periods_arr;
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