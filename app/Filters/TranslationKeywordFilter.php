<?php namespace App\Filters;

use Kris\LaravelFormBuilder\Form;
use App\Models\TranslationCatalogQuery;
use App\Models\TranslationLanguageQuery;

class TranslationKeywordFilter extends Form
{
    public function buildForm()
    {
        $translationCatalogs = TranslationCatalogQuery::create()->find();
        $translation_arr = array('' => '');
        foreach($translationCatalogs as $translationCatalog){
            $name = $translationCatalog->getName();
            $id = $translationCatalog->getId();
            $translation_arr[$id] = $name;
        }
        $translationLanguages = TranslationLanguageQuery::create()
			->where('is_active = 1')
			->where('is_default = 1')
			->find();
        
        $this
            ->add('CatalogId', 'select',[
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ],
                'choices' => $translation_arr,
                'label' => 'Catalog'
            ])
            ->add('Keyword', 'text',[
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ]);
        foreach($translationLanguages as $translationLanguage){
            $language_name =  $translationLanguage->getName();
            
            $this->add($language_name, 'text',[
                'wrapper' => [
                    'class' => 'form-group form-filter'
                ]
            ]);
        }
    }
}