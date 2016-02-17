<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\TranslationLanguageQuery;

class AdminUserForm extends Form
{
    public function buildForm()
    {
        $translationLanguages = TranslationLanguageQuery::create()
            ->where('is_active = 1')
            ->find();
        $languages = array();
        foreach($translationLanguages as $translationLanguage){
            $name = $translationLanguage->getName();
            $id = $translationLanguage->getId();
            $languages[$id] = $name;
        }
        $this
            ->add('Id', 'hidden')
            ->add('Name', 'text')
            ->add('Login', 'text')
            ->add('Email', 'email');
        if($this->getModel()['Status'] !== 'super_admin'){
            $this
                ->add('Status', 'select', [
                    'choices' => ['NEW' => 'NEW','admin' => 'admin','professor' => 'professor', 'student' => 'student'],
                ]);
        }
        $this
            ->add('Credentials', 'form',[
                'wrapper' => [
                    'class' => 'form-group credential-padding'
                ],
                'class' => $this->formBuilder->create('App\Forms\AdminCredentialForm', ['model' => isset($this->model['Credentials']) ? $this->model['Credentials'] : []])
            ])
            ->add('LanguageId', 'select', [
                'label' => 'Default Language',
                'choices' => $languages,
            ]);
            
    }
}