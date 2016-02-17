<?php
/*
namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
*/
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Lib\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use App\Lib\Misc;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers, ThrottlesLogins;

	protected $redirectTo = 'dashboard';
	protected $redirectAfterLogout = 'auth/login';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

	/**
	 * Handle a registration request for the application. Overrided
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postRegister(Request $request)
	{
		$validator = $this->registrar->validator($request->all());

		if ($validator->fails())
		{
			$this->throwValidationException(
				$request, $validator
			);
		}

		$this->registrar->create($request->all());
		flash()->overlay('REGISTER_SUCCESS_MESSAGE', 'REGISTER_SUCCESS_TITLE');

		return redirect('auth/login');
	}

	/**
	 * Handle a login request to the application. Overrided
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function postLogin(Request $request)
	{
		$this->validate($request, [
			'login' => 'required', 'password' => 'required',
		]);

		$credentials = $request->only('login', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
			if($this->auth->user()->getStatus() !== 'NEW'){
				Misc::setCredentials($this->auth->user()->getId());
				Misc::setLocale($this->auth->user()->getLanguageId());
				flash()->success("LOGIN_SUCCESS");
				return redirect($this->redirectTo);
			}
			$this->auth->logout();
		}

		return redirect($this->loginPath())
			->withInput($request->only('login', 'remember'))
			->withErrors([
				'login' => "LOGIN_FAILED"//$this->getFailedLoginMessage()
			]);
	}

}