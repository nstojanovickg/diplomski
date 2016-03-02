<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\StudentQuery;
use App\Models\SubjectQuery;
use App\Models\PeriodQuery;
use App\Models\SchoolYearQuery;
use App\Models\OralExamInvitationQuery;

class ApplicationForm extends Form
{
    public function buildForm()
    {
        $status = \Auth::user()->getStatus();
        if($status === 'professor') $attr_disabled = 'disabled';
        else $attr_disabled = '';
        $this
            ->add('StudentId', 'select',[
                'choices' => $this->getStudents(),
                'label' => 'Student',
                'attr' => [$attr_disabled]
            ])
            ->add('SubjectId', 'select',[
                'choices' => $this->getSubjects(),
                'label' => 'Subject',
                'attr' => [$attr_disabled]
            ])
            ->add('PeriodId', 'select',[
                'choices' => $this->getPeriods(),
                'label' => 'Period',
                'attr' => [$attr_disabled]
            ])
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'choices' => $this->getSchoolYears(),
                'attr' => [$attr_disabled]
            ])/*
            ->add('OralExamInvitationId', 'select', [
                'label' => 'Oral Exam Invitation',
                'choices' => $exam_invitation_arr
            ])*/
            ->add('ApplicationDate', 'datepicker',[
                'label' => 'Application Date',
                'date' => true,
                'attr' => [$attr_disabled]
            ])
            ->add('ExamDate', 'datepicker',[
                'label' => 'Exam Date',
                'date' => true
            ])
            ->add('ExamTime', 'time',[
                'label' => 'Exam Time',
            ])
            ->add('ExamScore', 'number');
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
    
    private function getStudents() {
		$students = StudentQuery::create()->useSchoolYearQuery()
				->orderByYear('desc')
			->endUse()
			->orderByIdentificationNumber()
            ->find();
        $students_arr = [];
        foreach($students as $student){
            $name = $student->__toString();
            $id = $student->getId();
            $students_arr[$id] = $name;
        }
		return $students_arr;
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
	
	private function getPeriods() {
		$periods = PeriodQuery::create()->orderBySequence()->find();
        $periods_arr = [];
        foreach($periods as $period){
            $name = $period->__toString();
            $id = $period->getId();
            $periods_arr[$id] = $name;
        }
		return $periods_arr;
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