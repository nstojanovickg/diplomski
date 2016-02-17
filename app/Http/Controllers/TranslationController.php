<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TranslationKeyword;
use App\Models\TranslationLanguageKeyword;
use App\Models\TranslationLanguageQuery;
use App\Models\TranslationKeywordQuery;
use App\Models\TranslationLanguageKeywordQuery;
use Kris\LaravelFormBuilder\FormBuilder;

use App\Http\Requests\TranslationRequest;
use App\Lists\TranslationKeywordList;

class TranslationController extends Controller {
    private $main_page = 'admin/translation';
        
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$translationKeywordList = new TranslationKeywordList($request,$this->main_page,$page);
		
		$keys = $translationKeywordList->getKeys();
		$data_arr = $translationKeywordList->getDataArr();
		$paginationForm = $translationKeywordList->getPaginationForm();
		$filter = session('translation_filter');
		
		$form_filter = $formBuilder->create('App\Filters\TranslationKeywordFilter', [
			'method' => 'PATCH',
			'action' => ['TranslationController@index'],
			'model'  => $filter
		]);
		session(['attributes' => \Lang::get('general.TRANSLATIONS')]);
		session(['attribute' => \Lang::get('general.TRANSLATION')]);
        
		return view('list', [
								'controller' => 'TranslationController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'TRANSLATION',
								'filter' => $form_filter,
								'pagination' => $paginationForm,
								'add' => true,
								'additional_info' => false,
                                'back' => false,
                                'parent_table_id' => false
							]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(FormBuilder $formBuilder)
	{
		$form = $formBuilder->create('App\Forms\TranslationKeywordForm', [
			'method' => 'POST',
			'action' => ['TranslationController@store'],
			//'class' => 'form-horizontal'
		]);
		$form_name = 'TRANSLATION';
		$action = 'ADD';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.TRANSLATION')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(TranslationRequest $request)
	{
		$data = $request->all();
		$translationKeyword = new TranslationKeyword();
		$translationKeyword->setCatalogId($data['CatalogId']);
		$translationKeyword->setKeyword($data['Keyword']);
		$translationKeyword->save();
		
		foreach($data['Languages'] as $language_id => $translation){
			$translationLanguageKeyword = new TranslationLanguageKeyword();
			$translationLanguageKeyword->setLanguageId($language_id);
			$translationLanguageKeyword->setKeywordId($translationKeyword->getId());
			$translationLanguageKeyword->setTranslation($translation);
			$translationLanguageKeyword->save();
		}
		
		if($translationKeyword->getTranslationCatalog()->getName() == 'general')
			$this->rebuildTranslation();
		flash()->success("ADDED");
        session(['attribute' => \Lang::get('general.TRANSLATION')]);
		return redirect($this->main_page);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id, FormBuilder $formBuilder)
	{
        $translation_arr = array();
		$translationKeyword = TranslationKeywordQuery::create()->findPK($id);
		$translation_arr['Id'] = $id;
		$translation_arr['CatalogId'] = $translationKeyword->getCatalogId();
		$translation_arr['Keyword'] = $translationKeyword->getKeyword();
		$translationLanguages = TranslationLanguageQuery::create()
			->where('is_active = 1')
			->find();
		$keyword_id = $translationKeyword->getId();
		foreach($translationLanguages as $translationLanguage){
			$language = $translationLanguage->getName();
			$language_id = $translationLanguage->getId();
			$translationLanguageKeyword = TranslationLanguageKeywordQuery::create()
				->where('keyword_id = '. $keyword_id)
				->where('language_id = '.$language_id)
				->findOne();
			$translation_arr['Languages'][$language_id] = (is_null($translationLanguageKeyword)) ? '' : $translationLanguageKeyword->getTranslation();
		}
		
		$form = $formBuilder->create('App\Forms\TranslationKeywordForm', [
			'method' => 'PATCH',
			'action' => ['TranslationController@update', $id],
			'model' => $translation_arr,
			//'class' => 'form-horizontal'
		]);
		$form_name = 'TRANSLATION';
		$action = 'EDIT';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.TRANSLATION')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, TranslationRequest $request)
	{
        $data = $request->all();
		
		$translationKeyword = TranslationKeywordQuery::create()->findPK($id);
		$translationKeyword->setCatalogId($data['CatalogId']);
		$translationKeyword->setKeyword($data['Keyword']);
		$translationKeyword->save();
		
		foreach($data['Languages'] as $language_id => $translation){
			$translationLanguageKeyword = TranslationLanguageKeywordQuery::create()
				->where('keyword_id = '. $id)
				->where('language_id = '.$language_id)
				->findOne();
			if(is_null($translationLanguageKeyword)){
				$translationLanguageKeyword = new TranslationLanguageKeyword();
				$translationLanguageKeyword->setLanguageId($language_id);
				$translationLanguageKeyword->setKeywordId($id);
				$translationLanguageKeyword->setTranslation($translation);
				$translationLanguageKeyword->save();
			}
			else{
				$translationLanguageKeyword->setTranslation($translation);
				$translationLanguageKeyword->save();
			}
		}
		
		if($translationKeyword->getTranslationCatalog()->getName() == 'general')
			$this->rebuildTranslation();
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.TRANSLATION')]);
		return redirect($this->main_page);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$translationKeyword = TranslationKeywordQuery::create()->findPK($id);
		$translationKeyword->delete();
		
		if($translationKeyword->getTranslationCatalog()->getName() == 'general')
			$this->rebuildTranslation();
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.TRANSLATION')]);
		return redirect($this->main_page);
	}
	
	/**
	 * Rebuild translation from database.
	 *
	 * @return Response
	 */
	public function rebuildTranslation()
	{
		\Artisan::call('rebuild-translation');
		
		return true;
	}

}
