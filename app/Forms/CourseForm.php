<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CourseForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('Name', 'text');
    }
}