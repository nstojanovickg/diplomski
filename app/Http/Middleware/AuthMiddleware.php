<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Routing\Middleware;

class AuthMiddleware implements Middleware {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (\Auth::guest())
		{
			if ($request->ajax())
			{
			    return response('Unauthorized.', 401);
			}
			else
			{
			    flash()->error("PLEASE_LOGIN");
			    return redirect()->guest('auth/login');
			}
		}

		if (!$request->is('dashboard') && !$request->is('/'))//dashboard je default za logovanog usera
		{
			$page = $request->path();
			$myCredentials = session('myCredentials');
			
			$flag = true;
			foreach($myCredentials as $credential_group){
				foreach($credential_group as $credential){
					$credential_path = $credential['path'];
					if(strpos($page, $credential_path) == 0){
						$reg_edit = "~^(?:$credential_path/(\d+)/edit)$~x";
						$reg_create = "~^(?:$credential_path/create)$~x";
						$myPermissions = session('myPermissions');
						if(preg_match($reg_edit, $page) || preg_match($reg_create, $page)){
							if($myPermissions[$credential_path]['write'] == 1){
								$flag = false;
								break 2;
							}
						}
						else{
							$flag = false;
							break 2;
						}
						if ($request->isMethod('post')){
							if($myPermissions[$credential_path]['write'] == 1){
								$flag = false;
								break 2;
							}
						}
					}
				}
			}
			if($flag){
				//Lang::get('general.NO_PERMISSION', ['page' => $page]);
			    flash()->error("You do not have permission to access $page.");
			    return redirect()->intended('dashboard');
			}
		}
		\Session::regenerateToken();
		return $next($request);
	}

}

