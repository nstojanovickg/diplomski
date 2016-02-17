<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;

class ProfessorFilter extends Form
{
    public function buildForm()
    {
        $this
            ->add('FirstName', 'text', [
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('LasName', 'text', [
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ]);
    }
}