<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\SchoolYearQuery;
use App\Models\CourseQuery;

class StudentForm extends Form
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
            ->add('IdentificationNumber', 'number')
            ->add('IdentificationNumberOrig', 'hidden')
            ->add('SchoolYearId', 'select',[
                'label' => 'School Year',
                'choices' => $shoolYears_arr
            ])
            ->add('SchoolYearIdOrig', 'hidden')
            ->add('CourseId', 'select',[
                'label' => 'Course',
                'choices' => $courses_arr
            ])
            ->add('FirstName', 'text', [
                'label' => 'First Name',
            ])
            ->add('LastName', 'text', [
                'label' => 'Last Name',
            ])
            ->add('BirthPlace', 'text', [
                'label' => 'Birth Place',
            ])
            ->add('Birthday', 'datepicker',[
                'date' => true
            ])
            ->add('AccountAmount', 'number',[
                'label' => 'Account Amount',
            ])
            ->add('PhoneNumber', 'text', [
                'label' => 'Phone Number',
            ]);
    }
}