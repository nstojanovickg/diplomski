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
        $professors = ProfessorQuery::create()->orderByLastName()->orderByFirstName()->find();
        $professors_arr = array('' => '');
        foreach($professors as $professor){
            $name = $professor->__toString();
            $id = $professor->getId();
            $professors_arr[$id] = $name;
        }
        $subjects = SubjectQuery::create()->orderByName()->find();
        $subjects_arr = array('' => '');
        foreach($subjects as $subject){
            $name = $subject->__toString();
            $id = $subject->getId();
            $subjects_arr[$id] = $name;
        }
        $courses = CourseQuery::create()->find();
        $courses_arr = array('' => '');
        foreach($courses as $course){
            $name = $course->__toString();
            $id = $course->getId();
            $courses_arr[$id] = $name;
        }
        $shoolYears = SchoolYearQuery::create()->orderByYear()->find();
        $shoolYears_arr = array('' => '');
        foreach($shoolYears as $shoolYear){
            $name = $shoolYear->__toString();
            $id = $shoolYear->getId();
            $shoolYears_arr[$id] = $name;
        }
        $this
            ->add('ProfessorId', 'select', [
                'label' => 'Professor',
                'choices' => $professors_arr
            ])
            ->add('ProfessorIdOrig', 'hidden')
            ->add('SubjectId', 'select', [
                'label' => 'Subject',
                'choices' => $subjects_arr
            ])
            ->add('SubjectIdOrig', 'hidden')
            ->add('CourseId', 'select', [
                'label' => 'Course',
                'choices' => $courses_arr
            ])
            ->add('CourseIdOrig', 'hidden')
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'choices' => $shoolYears_arr
            ])
            ->add('SchoolYearIdOrig', 'hidden');
    }
}