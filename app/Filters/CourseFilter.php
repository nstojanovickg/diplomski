<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;

class CourseFilter extends Form
{
    public function buildForm()
    {
        $this
            ->add('Name', 'text', [
                'label' => 'Name',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ]);
    }
}