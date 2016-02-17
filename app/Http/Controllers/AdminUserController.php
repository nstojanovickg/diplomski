<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminUserQuery;
use App\Models\AdminUserCredential;
use App\Models\AdminUserCredentialQuery;
use App\Models\AdminCredentialQuery;
use Carbon\Carbon;
use Kris\LaravelFormBuilder\FormBuilder;
use Illuminate\Support\Facades\Session;

use App\Http\Requests\AdminUserRequest;
use App\Lib\Misc;
use App\Lists\AdminUserList;

class AdminUserController extends Controller {
	private $main_page = 'admin/ac_manage';
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, FormBuilder $formBuilder,$page=null)
	{
		$adminUserList = new AdminUserList($request,$this->main_page,$page);
		
		$keys = $adminUserList->getKeys();
		$data_arr = $adminUserList->getDataArr();
		$paginationForm = $adminUserList->getPaginationForm();
		$filter = session('admin_user_filter');
	    
	    $form_filter = $formBuilder->create('App\Filters\AdminUserFilter', [
			'method' => 'PATCH',
			'action' => ['AdminUserController@index'],
			'model'  => $filter
		]);
		session(['attributes' => \Lang::get('general.USERS')]);
		session(['attribute' => \Lang::get('general.USER')]);
		
	    return view('list', [
								'controller' => 'AdminUserController',
								'data_arr' => $data_arr,
								'keys' => $keys,
								'perm_path' => $this->main_page,
								'path' => $this->main_page,
								'title' => 'USER',
								'filter' => $form_filter,
								'pagination' => $paginationForm,
								'add' => false,
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
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
		$user_arr = [];
	    $user = AdminUserQuery::create()->findPK($id);
		$user_arr = $user->toArray();
		
	    $userCredentials = AdminUserCredentialQuery::create()
			->where('admin_user_id = '.$id)
			->find();
	    foreach($userCredentials as $credential){
			$credential_id = $credential->getAdminCredentialId();
			if($credential->getPermRead() == 1) $user_arr['Credentials'][$credential_id]['read'] = 'read';
			if($credential->getPermWrite() == 1) $user_arr['Credentials'][$credential_id]['write'] = 'write';
			if($credential->getPermExec() == 1) $user_arr['Credentials'][$credential_id]['exec'] = 'exec';
	    }
	    
		$form = $formBuilder->create('App\Forms\AdminUserForm', [
			'method' => 'PATCH',
			'action' => ['AdminUserController@update', $id],
			'model' => $user_arr
		]);
		
		$form_name = 'USER';
		$action = 'EDIT';
		$path = $this->main_page;
		$back = $this->main_page;
		session(['attribute' => \Lang::get('general.USER')]);
		
		return view('manage', compact('form', 'form_name', 'action', 'path', 'back'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, AdminUserRequest $request)
	{
	    $data = $request->all();
	    $user = AdminUserQuery::create()->findPk($id);
		$user->fromArray($data);
	    $user->save();
	    
		Misc::setLocale($data['LanguageId']);
		
	    $adminCredentials = AdminCredentialQuery::create()->find();
	    $credentials_arr = $request->only('Credentials');
	    $credentials_arr = $credentials_arr['Credentials'];
	    foreach($adminCredentials as $adminCredential){
			$credential_id = $adminCredential->getId();
			$adminUserCredential = AdminUserCredentialQuery::create()
				->where('admin_user_id = '.$id)
				->where('admin_credential_id = '.$credential_id)
				->findOne();
			if(isset($credentials_arr[$credential_id])){
				if(is_null($adminUserCredential)){
					$adminUserCredential = new AdminUserCredential();
					$adminUserCredential->setAdminUserId($id);
					$adminUserCredential->setAdminCredentialId($credential_id);
				}
				//$adminUserCredential->setPermRead(0);
				//$adminUserCredential->setPermWrite(0);
				//$adminUserCredential->setPermExec(0);
				foreach($credentials_arr[$credential_id] as $perm){
					if($perm == 'read') $adminUserCredential->setPermRead(1);
					elseif($perm == 'write') $adminUserCredential->setPermWrite(1);
					elseif($perm == 'exec') $adminUserCredential->setPermExec(1);
				}
				$adminUserCredential->save();
			}
			else{
				if(!is_null($adminUserCredential))
					$adminUserCredential->delete();
			}
	    }
		if($id == \Auth::user()->getId())
			Misc::setCredentials($id);
	    
		flash()->success("UPDATED");
        session(['attribute' => \Lang::get('general.USER')]);
		
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
	    $user = AdminUserQuery::create()->findPK($id);
	    $user->delete();
	    
		flash()->success("DELETED");
        session(['attribute' => \Lang::get('general.USER')]);
        return redirect($this->main_page);
	}
	
	/**
	 * Set locale in current session.
	 *
	 * @param  string  $language
	 * @return Response
	 */
	public function setLocale($language)
	{
		Session::put('lang', $language);
		return redirect()->back();
	}

}
