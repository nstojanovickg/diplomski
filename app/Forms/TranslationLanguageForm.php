<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\TranslationLanguageQuery;

class TranslationLanguageForm extends Form
{
    public function buildForm()
    {
        $translationLanguages = TranslationLanguageQuery::create()
            ->where('is_active = 1')
            ->find();
        foreach($translationLanguages as $translationLanguage){
            $name = $translationLanguage->getName();
            $id = $translationLanguage->getId();
            $this->add($id, 'textarea', ['label' => $name]);
        }
    }
}