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
        $students = StudentQuery::create()->find();
        $students_arr = [];
        foreach($students as $student){
            $name = $student->__toString();
            $id = $student->getId();
            $students_arr[$id] = $name;
        }
        $subjects = SubjectQuery::create()->orderByName()->find();
        $subjects_arr = [];
        foreach($subjects as $subject){
            $name = $subject->__toString();
            $id = $subject->getId();
            $subjects_arr[$id] = $name;
        }
        $periods = PeriodQuery::create()->find();
        $periods_arr = [];
        foreach($periods as $period){
            $name = $period->__toString();
            $id = $period->getId();
            $periods_arr[$id] = $name;
        }
        $schoolYears = SchoolYearQuery::create()->orderByYear()->find();
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
        $attr_disabled = '';
        if($status === 'professor') $attr_disabled = 'disabled';
        $this
            ->add('StudentId', 'select',[
                'choices' => $students_arr,
                'label' => 'Student',
                'attr' => [$attr_disabled]
            ])
            ->add('SubjectId', 'select',[
                'choices' => $subjects_arr,
                'label' => 'Subject',
                'attr' => [$attr_disabled]
            ])
            ->add('PeriodId', 'select',[
                'choices' => $periods_arr,
                'label' => 'Period',
                'attr' => [$attr_disabled]
            ])
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'choices' => $schoolYears_arr,
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
}