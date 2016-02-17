<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;
use App\Models\TranslationLanguageQuery;
use App\Models\AdminCredentialQuery;

class AdminUserFilter extends Form
{
    public function buildForm()
    {
        $translationLanguages = TranslationLanguageQuery::create()
            ->where('is_active = 1')
            ->find();
        $languages = array('' => '');
        foreach($translationLanguages as $translationLanguage){
            $name = $translationLanguage->getName();
            $id = $translationLanguage->getId();
            $languages[$id] = $name;
        }
        $adminCredentials = AdminCredentialQuery::create()
            ->orderBySequence()
            ->find();
        $credentials = array('' => '');
        foreach($adminCredentials as $adminCredential){
            $name = $adminCredential->getName();
            $id = $adminCredential->getId();
            $credentials[$id] = $name;
        }
        $this
            ->add('Name', 'text',[
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('Login', 'text',[
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('Email', 'email',[
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ])
            ->add('Status', 'select', [
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => ['' => '', 'NEW' => 'NEW','admin' => 'admin','professor' => 'professor', 'student' => 'student'],
            ])
            ->add('LanguageId', 'select', [
                'label' => 'Default Language',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $languages
            ])
            ->add('CredentialId', 'select',[
                'label' => 'Credential',
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $credentials
            ]);
    }
}