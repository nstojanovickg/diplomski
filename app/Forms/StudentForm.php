<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\SchoolYearQuery;
use App\Models\CourseQuery;

class StudentForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('IdentificationNumber', 'number')
            ->add('IdentificationNumberOrig', 'hidden')
            ->add('SchoolYearId', 'select',[
                'label' => 'School Year',
                'choices' => $this->getSchoolYears()
            ])
            ->add('SchoolYearIdOrig', 'hidden')
            ->add('CourseId', 'select',[
                'label' => 'Course',
                'choices' => $this->getCourses()
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
            ->add('PhoneNumber', 'text', [
                'label' => 'Phone Number',
            ]);
    }
    
    private function getCourses() {
        $courses = CourseQuery::create()->orderByName()->find();
        $courses_arr = [];
        foreach($courses as $course){
            $name = $course->getName();
            $id = $course->getId();
            $courses_arr[$id] = $name;
        }
        return $courses_arr;
    }
    
    private function getSchoolYears() {
        $schoolYears = SchoolYearQuery::create()->orderByYear('desc')->find();
        $schoolYears_arr = [];
        foreach($schoolYears as $schoolYear){
            $name = $schoolYear->__toString();
            $id = $schoolYear->getId();
            $schoolYears_arr[$id] = $name;
        }
        return $schoolYears_arr;
    }
}