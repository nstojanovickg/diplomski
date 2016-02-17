<?php namespace App\Lists;

use App\Models\TranslationCatalogQuery;
use App\Models\TranslationLanguageQuery;
use App\Models\TranslationKeywordQuery;
use App\Models\TranslationLanguageKeywordQuery;

class TranslationKeywordList extends BaseList {
	private $translations;
	private $translationLanguage;
	
	/**
	 * Create a new AdminUserList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->translationLanguage = TranslationLanguageQuery::create()
			->where('is_active = 1')
			->where('is_default = 1')
			->findOne();
			
		$this->keys = array('#','catalog','keyword',$this->translationLanguage->getName());
		$this->createList($request,$path,$page);
	}
	
    /**
	 * Create TranslationKeyword list and put in session.
	 *
	 */
    private function createList($request,$path,$page){
		$translation_filter = $request->all();
		$this->handleFilterRequest($translation_filter, 'translation_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->translations->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		$language_name = $this->translationLanguage->getName();
		$language_id = $this->translationLanguage->getId();
		
		foreach($this->translations->paginate($page, $this->maxPerPage) as $key => $translationKeyword){
			$keyword_id = $translationKeyword->getId();
			$this->data_arr[$keyword_id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$keyword_id]['catalog'] = $translationKeyword->getTranslationCatalog()->getName();
			$this->data_arr[$keyword_id]['keyword'] = $translationKeyword->getKeyword();
			
			$translationLanguageKeyword = TranslationLanguageKeywordQuery::create()
				->where('keyword_id = '. $keyword_id)
				->where('language_id = '.$language_id)
				->findOne();
			$this->data_arr[$keyword_id][$language_name] = (is_null($translationLanguageKeyword)) ? '' : $translationLanguageKeyword->getTranslation();
		}
    }
	
	/**
	 * Create TranslationKeyword query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->translations = TranslationKeywordQuery::create();
		if(isset($array['CatalogId']) && $array['CatalogId'] !== "")
			$this->translations->where("translation_keyword.catalog_id = ".$array['CatalogId']);
		if(isset($array['Keyword']) && $array['Keyword'] !== "")
			$this->translations->where("translation_keyword.keyword like '%".$array['Keyword']."%'");
        $language_name = $this->translationLanguage->getName();
        if(isset($array[$language_name]) && $array[$language_name] !== ""){
            $this->translations->useTranslationLanguageKeywordQuery()
                ->where("translation_language_keyword.translation like '%".$array[$language_name]."%'")
                ->endUse();
        }
		
        if($search) session(['translation_filter' => $array]);
	}

}
?>