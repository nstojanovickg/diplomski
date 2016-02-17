<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class SchoolYearForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('Year', 'number')
            ->add('DateStart', 'datepicker',[
                'label' => 'Date Start',
                'date' => true
            ])
            ->add('DateEnd', 'datepicker',[
                'label' => 'Date End',
                'date' => true
            ])
            ->add('Description', 'textarea');
    }
}