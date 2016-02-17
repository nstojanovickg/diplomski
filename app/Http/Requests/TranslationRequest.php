<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\TranslationKeywordQuery;

class TranslationRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		$arr = Request::only('Id', 'CatalogId', 'Keyword');
		$keyword = $arr['Keyword'];
		$catalog_id = $arr['CatalogId'];
		$id = $arr['Id'];
		
		if($id){
			if($this->checkKeyword($id, $catalog_id, $keyword)){
				return [
					//'CatalogId' => 'required',
					//'Keyword' => 'required'
				];
			}
			else{
				return [
					'CatalogId' => 'required',
					'Keyword' => 'required|unique:translation_keyword,keyword,NULL,id,catalog_id,'.$catalog_id
				];
			}
		}
		else{
			return [
				'CatalogId' => 'required',
				'Keyword' => 'required|unique:translation_keyword,keyword,NULL,id,catalog_id,'.$catalog_id
			];
		}
	}
	
	public function messages(){
		return [
			'Keyword.unique' => \Lang::get('general.CATALOG_KEYWORD_UNIQUE')
		];
	}
	
	public function checkKeyword($id, $catalog_id, $keyword){
		$translationKeyword = TranslationKeywordQuery::create()->findPK($id);
		if($catalog_id != $translationKeyword->getCatalogId()){
			return false;
		}
		elseif($keyword != $translationKeyword->getKeyword()){
			return false;
		}
		return true;
	}
}