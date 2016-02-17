<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class SubjectForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('Id', 'hidden')
            ->add('Name', 'text')
            ->add('Code', 'text');
    }
}