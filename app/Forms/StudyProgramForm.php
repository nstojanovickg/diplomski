<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\SubjectQuery;
use App\Models\CourseQuery;

class StudyProgramForm extends Form
{
    public function buildForm()
    {
        $subjects = SubjectQuery::create()->orderByName()->find();
        $subjects_arr = [];
        foreach($subjects as $subject){
            $name = $subject->__toString();
            $id = $subject->getId();
            $subjects_arr[$id] = $name;
        }
        $courses = CourseQuery::create()->find();
        $courses_arr = [];
        foreach($courses as $course){
            $name = $course->__toString();
            $id = $course->getId();
            $courses_arr[$id] = $name;
        }
        $this
            ->add('SubjectId', 'select',[
                'label' => 'Subject',
                'choices' => $subjects_arr,
            ])
            ->add('SubjectIdOrig', 'hidden')
            ->add('CourseId', 'select',[
                'label' => 'Course',
                'choices' => $courses_arr,
            ])
            ->add('CourseIdOrig', 'hidden')
            ->add('Year', 'select',[
                'choices' => ['1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV']
            ])
            ->add('Semester', 'select',[
                'choices' => ['1' => '1', '2' => '2']
            ]);
    }
}