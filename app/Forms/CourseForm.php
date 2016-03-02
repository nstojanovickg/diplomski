<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CourseForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('Id', 'hidden')
            ->add('Name', 'text');
    }
}