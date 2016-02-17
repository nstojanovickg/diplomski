<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;
use App\Models\ProfessorQuery;
use App\Models\SubjectQuery;
use App\Models\CourseQuery;
use App\Models\SchoolYearQuery;

class EngagementFilter extends Form
{
    public function buildForm()
    {
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
        $schoolYears = SchoolYearQuery::create()->orderByYear()->find();
        $schoolYears_arr = array('' => '');
        foreach($schoolYears as $schoolYear){
            $name = $schoolYear->__toString();
            $id = $schoolYear->getId();
            $schoolYears_arr[$id] = $name;
        }
        if(\Auth::user()->getStatus() !== 'professor'){
            $professors = ProfessorQuery::create()->orderByLastName()->orderByFirstName()->find();
            $professors_arr = array('' => '');
            foreach($professors as $professor){
                $name = $professor->__toString();
                $id = $professor->getId();
                $professors_arr[$id] = $name;
            }
			$this
                ->add('ProfessorId', 'select', [
                    'label' => 'Professor',
                    'wrapper' => [
                        'class' => 'form-group form-filter'
                    ],
                    'choices' => $professors_arr
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
            ->add('CourseId', 'select', [
                'label' => 'Course',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $courses_arr
            ])
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $schoolYears_arr
            ]);
    }
}