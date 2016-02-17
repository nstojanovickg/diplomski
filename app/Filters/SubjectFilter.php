<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;

class SubjectFilter extends Form
{
    public function buildForm()
    {
        $this
            ->add('Name', 'text', [
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('Code', 'text', [
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ]);
    }
}