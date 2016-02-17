<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ProfessorForm extends Form
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