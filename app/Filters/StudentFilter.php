<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;
use App\Models\SchoolYearQuery;
use App\Models\CourseQuery;

class StudentFilter extends Form
{
    public function buildForm()
    {
        $this
            ->add('IdentificationNumber', 'number',[
                'label' => 'Identification Number'
            ])
            ->add('SchoolYearId', 'select',[
                'label' => 'School Year',
                'choices' => $this->getSchoolYears()
            ])
            ->add('CourseId', 'select',[
                'label' => 'Course',
                'choices' => $this->getCourses()
            ])
            ->add('FirstName', 'text', [
                'label' => 'First Name'
            ])
            ->add('LastName', 'text', [
                'label' => 'Last Name'
            ])
            ->add('BirthPlace', 'text', [
                'label' => 'Birth Place'
            ])
            ->add('BirthdayFrom', 'datepicker', [
                'label' => 'Birthday From'
            ])
            ->add('BirthdayTo', 'datepicker', [
                'label' => 'Birthday To'
            ]);
    }
    
    private function getCourses() {
        $courses = CourseQuery::create()->orderByName()->find();
        $courses_arr = ['' => ''];
        foreach($courses as $course){
            $name = $course->getName();
            $id = $course->getId();
            $courses_arr[$id] = $name;
        }
        return $courses_arr;
    }
    
    private function getSchoolYears() {
        $schoolYears = SchoolYearQuery::create()->orderByYear('desc')->find();
        $schoolYears_arr = ['' => ''];
        foreach($schoolYears as $schoolYear){
            $name = $schoolYear->__toString();
            $id = $schoolYear->getId();
            $schoolYears_arr[$id] = $name;
        }
        return $schoolYears_arr;
    }
}