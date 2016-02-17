<?php namespace App\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CredentialChoice extends FormField {

    protected function getTemplate()
    {
        return 'fields.credential_choice';
    }
    
    public function render(array $options = [], $showLabel = true, $showField = true, $showError = true)
    {
        dd(parent::getParent());
        $choice = new ChoiceType('some_choice', 'choice', new Form(), $options);
        return $choice->render();
        //return parent::render($options, $showLabel, $showField, $showError);
    }

}