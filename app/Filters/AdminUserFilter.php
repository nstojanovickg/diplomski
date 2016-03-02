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
            ->add('Name', 'text')
            ->add('Login', 'text')
            ->add('Email', 'email')
            ->add('Status', 'select', [
                'choices' => ['' => '', 'NEW' => 'NEW','admin' => 'admin','professor' => 'professor', 'student' => 'student'],
            ])
            ->add('LanguageId', 'select', [
                'label' => 'Default Language',
                'choices' => $languages
            ])
            ->add('CredentialId', 'select',[
                'label' => 'Credential',
                'choices' => $credentials
            ]);
    }
}