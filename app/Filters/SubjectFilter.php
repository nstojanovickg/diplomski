<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;

class SubjectFilter extends Form
{
    public function buildForm()
    {
        $this
            ->add('Name', 'text')
            ->add('Code', 'text');
    }
}