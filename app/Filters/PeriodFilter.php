<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;
use App\Models\PeriodQuery;
use App\Models\SchoolYearQuery;

class PeriodFilter extends Form
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
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $periods_arr
            ])
            ->add('SchoolYearId', 'select', [
                'label' => 'School Year',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $shoolYears_arr
            ])
            /*
            ->add('DateStart', 'datepicker',[
                'label' => 'Date Start',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'date' => true
            ])
            ->add('DateEnd', 'datepicker',[
                'label' => 'Date End',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'date' => true
            ])
            */;
    }
}