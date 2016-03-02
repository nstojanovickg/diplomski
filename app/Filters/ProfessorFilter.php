<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;

class ProfessorFilter extends Form
{
    public function buildForm()
    {
        $this
            ->add('FirstName', 'text', [
                'label' => 'First Name'
            ])
            ->add('LastName', 'text', [
                'label' => 'Last Name'
            ]);
    }
}