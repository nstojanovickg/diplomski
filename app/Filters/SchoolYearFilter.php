<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;

class SchoolYearFilter extends Form
{
    public function buildForm()
    {
        $this
            ->add('Year', 'text', [
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
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
            */
            ->add('Description', 'text',[
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ]);
    }
}