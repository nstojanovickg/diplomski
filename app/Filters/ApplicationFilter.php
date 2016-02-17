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
        if($status !== 'professor') {
            $professors = ProfessorQuery::create();
            if($status === 'student'){
                $course_id = \Auth::user()->getStudent()->getCourseId();
                $professors->joinEngagement();
                $professors->where('Engagement.course_id = ?', $course_id);
            }
            $professors->find();
            $professors_arr = ['' => ''];
            foreach($professors as $professor) {
                $name = $professor->__toString();
                $id = $professor->getId();
                $professors_arr[$id] = $name;
            }
        }
		if($status !== 'student') {
            $students = StudentQuery::create()
                ->useSchoolYearQuery()
                    ->orderByYear()
                ->endUse();
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
        }
        
        $subjects = SubjectQuery::create();
        if($status === 'professor') {
            $subjects->joinEngagement();
            $subjects->where('Engagement.professor_id = ?', \Auth::user()->getProfessorId());
        }
		else if($status === 'student') {
			$subjects->joinStudyProgram();
            $subjects->where('StudyProgram.course_id = ?', \Auth::user()->getStudent()->getCourseId());
        }
        $subjects->orderByName()->find();
        $subjects_arr = ['' => ''];
        foreach($subjects as $subject){
            $name = $subject->__toString();
            $id = $subject->getId();
            $subjects_arr[$id] = $name;
        }
        $periods = PeriodQuery::create()->find();
        $periods_arr = ['' => ''];
        foreach($periods as $period){
            $name = $period->__toString();
            $id = $period->getId();
            $periods_arr[$id] = $name;
        }
        $schoolYears = SchoolYearQuery::create()->orderByYear()->find();
        $schoolYears_arr = ['' => ''];
        foreach($schoolYears as $schoolYear){
            $name = $schoolYear->__toString();
            $id = $schoolYear->getId();
            $schoolYears_arr[$id] = $name;
        }
        /*
        $invitations = OralExamInvitationQuery::create()->find();
        $exam_invitation_arr = ['' => ''];
        foreach($invitations as $invitation){
            $name = $invitation->__toString();
            $id = $invitation->getId();
            $exam_invitation_arr[$id] = $name;
        }
        */
        if($status !== 'professor'){
            $this
            ->add('ProfessorId', 'select', [
                'label' => 'Professor',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $professors_arr
            ]);
        }
        if($status !== 'student'){
            $this
            ->add('StudentId', 'select', [
                'label' => 'Student',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $students_arr
            ]);
        }
        $this
            ->add('SubjectId', 'select', [
                'label' => 'Subject',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $subjects_arr
            ])
            ->add('PeriodId', 'select', [
                'label' => 'Period',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $periods_arr
            ])
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $schoolYears_arr
            ])/*
            ->add('OralExamInvitationId', 'select', [
                'label' => 'Oral Exam Invitation',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $exam_invitation_arr
            ])*/
            ->add('ApplicationDateFrom', 'datepicker',[
                'label' => 'Application Date From',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'date' => true
            ])
            ->add('ApplicationDateTo', 'datepicker',[
                'label' => 'Application Date To',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'date' => true
            ])
            ->add('ExamDateFrom', 'datepicker',[
                'label' => 'Exam Date From',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'date' => true
            ])
            ->add('ExamDateTo', 'datepicker',[
                'label' => 'Exam Date To',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'date' => true
            ])
            ->add('ExamTime', 'time',[
                'label' => 'Exam Time',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('ExamScore', 'number',[
                'label' => 'Exam Score',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ]);
    }
}