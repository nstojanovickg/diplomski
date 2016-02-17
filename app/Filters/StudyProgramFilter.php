<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;
use App\Models\SubjectQuery;
use App\Models\CourseQuery;

class StudyProgramFilter extends Form
{
    public function buildForm()
    {
        $subjects = SubjectQuery::create()->orderByName()->find();
        $subjects_arr = ['' => ''];
        foreach($subjects as $subject){
            $name = $subject->__toString();
            $id = $subject->getId();
            $subjects_arr[$id] = $name;
        }
        $courses = CourseQuery::create()->find();
        $courses_arr = ['' => ''];
        foreach($courses as $course){
            $name = $course->__toString();
            $id = $course->getId();
            $courses_arr[$id] = $name;
        }
        $this
            ->add('SubjectId', 'select', [
                'label' => 'Subject',
                'choices' => $subjects_arr,
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('CourseId', 'select', [
                'label' => 'Course',
                'choices' => $courses_arr,
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('Year', 'select',[
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => ['' => '', '1' => 'I', '2' => 'II', '3' => 'III', '4' => 'IV']
            ])
            ->add('Semester', 'select',[
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => ['' => '', '1' => '1', '2' => '2']
            ]);
    }
}