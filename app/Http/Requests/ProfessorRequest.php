<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfessorRequest extends Request {

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
		return [
			'FirstName' => 'required|max:100',
            'LastName' => 'required|max:100'
		];
	}

}
