<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;

class SchoolYearFilter extends Form
{
    public function buildForm()
    {
        $this
            ->add('Year', 'text')
            /*
            ->add('DateStart', 'datepicker',[
                'label' => 'Date Start',
                'date' => true
            ])
            ->add('DateEnd', 'datepicker',[
                'label' => 'Date End',
                'date' => true
            ])
            */
            ->add('Description', 'text');
    }
}