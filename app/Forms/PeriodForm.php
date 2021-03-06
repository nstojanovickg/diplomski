<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\PeriodQuery;
use App\Models\SchoolYearQuery;

class PeriodForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('PeriodId', 'select', [
                'label' => 'Period',
                'choices' => $this->getPeriods()
            ])
            ->add('PeriodIdOrig', 'hidden')
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'choices' => $this->getSchoolYears()
            ])
            ->add('SchoolYearIdOrig', 'hidden')
            ->add('DateStart', 'datepicker',[
                'label' => 'Date Start',
                'date' => true
            ])
            ->add('DateEnd', 'datepicker',[
                'label' => 'Date End',
                'date' => true
            ]);
    }
    
    private function getPeriods() {
        $periods = PeriodQuery::create()->orderBySequence()->find();
        $periods_arr = [];
        foreach($periods as $period){
            $name = $period->__toString();
            $id = $period->getId();
            $periods_arr[$id] = $name;
        }
        return $periods_arr;
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