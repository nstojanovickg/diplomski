<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminUserRequest extends Request {

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
			'Name' => 'required|max:100',
			'Login' => 'required|max:32|unique:admin_user,login,'.$id,
			'Email' => 'required|max:50|email|unique:admin_user,email,'.$id
		];
	}

}
