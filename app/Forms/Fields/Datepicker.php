<?php namespace App\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class Datepicker extends FormField {

    protected function getTemplate()
    {
        return 'fields.datepicker';
    }
}