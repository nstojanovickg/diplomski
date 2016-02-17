<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;
use App\Models\SchoolYearQuery;
use App\Models\CourseQuery;

class StudentFilter extends Form
{
    public function buildForm()
    {
        $shoolYears = SchoolYearQuery::create()->orderByYear()->find();
        $shoolYears_arr = array('' => '');
        foreach($shoolYears as $shoolYear){
            $name = $shoolYear->__toString();
            $id = $shoolYear->getId();
            $shoolYears_arr[$id] = $name;
        }
        
        $courses = CourseQuery::create()->find();
        $courses_arr = array('' => '');
        foreach($courses as $course){
            $name = $course->getName();
            $id = $course->getId();
            $courses_arr[$id] = $name;
        }
        
        $this
            ->add('IdentificationNumber', 'number',[
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('SchoolYearId', 'select',[
                'label' => 'School Year',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $shoolYears_arr
            ])
            ->add('CourseId', 'select',[
                'label' => 'Course',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $courses_arr
            ])
            ->add('FirstName', 'text', [
                'label' => 'First Name',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('LastName', 'text', [
                'label' => 'Last Name',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('BirthPlace', 'text', [
                'label' => 'Birth Place',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('BirthdayFrom', 'datepicker', [
                'label' => 'Birthday From',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('BirthdayTo', 'datepicker', [
                'label' => 'Birthday To',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('AccountAmountFrom', 'number',[
                'label' => 'Account Amount From',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'attr' => ['step' => 0.01]
            ])
            ->add('AccountAmountTo', 'number',[
                'label' => 'Account Amount To',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'attr' => ['step' => 0.01]
            ]);
    }
}