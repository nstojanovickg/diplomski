<?php namespace App\Lib;

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;
use App\Models\TranslationLanguageQuery;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:100',
			'login' => 'required|max:32|unique:admin_user',
			'email' => 'required|email|max:100|unique:admin_user',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		$translationLanguage = TranslationLanguageQuery::create()
			->where('is_active = 1')
			->findOne();
		return User::create([
			'name' => $data['name'],
			'login' => $data['login'],
			'email' => $data['email'],
			'language_id' => $translationLanguage->getId(),
			'password' => bcrypt($data['password']),
		]);
	}

}
