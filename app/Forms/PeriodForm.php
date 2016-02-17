<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\PeriodQuery;
use App\Models\SchoolYearQuery;

class PeriodForm extends Form
{
    public function buildForm()
    {
        $periods = PeriodQuery::create()->find();
        $periods_arr = array('' => '');
        foreach($periods as $period){
            $name = $period->__toString();
            $id = $period->getId();
            $periods_arr[$id] = $name;
        }
        $shoolYears = SchoolYearQuery::create()->orderByYear()->find();
        $shoolYears_arr = array('' => '');
        foreach($shoolYears as $shoolYear){
            $name = $shoolYear->__toString();
            $id = $shoolYear->getId();
            $shoolYears_arr[$id] = $name;
        }
        $this
            ->add('PeriodId', 'select', [
                'label' => 'Period',
                'choices' => $periods_arr
            ])
            ->add('PeriodIdOrig', 'hidden')
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'choices' => $shoolYears_arr
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
}