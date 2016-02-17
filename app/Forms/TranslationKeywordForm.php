<?php namespace App\Forms;

use Kris\LaravelFormBuilder\Form;
use App\Models\TranslationCatalogQuery;

class TranslationKeywordForm extends Form
{
    public function buildForm()
    {
        $translationCatalogs = TranslationCatalogQuery::create()->find();
        $translation_arr = array();
        foreach($translationCatalogs as $translationCatalog){
            $name = $translationCatalog->getName();
            $id = $translationCatalog->getId();
            $translation_arr[$id] = $name;
        }
        $this
            ->add('Id', 'hidden')
            ->add('CatalogId', 'select',[
                'choices' => $translation_arr,
                'label' => 'Catalog'
            ])
            ->add('Keyword', 'text')
            ->add('Languages', 'form', [
                'class' => 'App\Forms\TranslationLanguageForm',
                'label' => false
            ]);
    }
}