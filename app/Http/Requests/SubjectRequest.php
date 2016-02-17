<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SubjectRequest extends Request {

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
		$id_arr = Request::only('Id');
		$id = $id_arr['Id'];
		
		return [
			//unique:table,column,except,idColumn
			'Name' => 'required|max:100|unique:subject,name,'.$id,
            'Code' => 'required|max:10|unique:subject,code,'.$id
		];
	}

}
