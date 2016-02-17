<?php namespace App\Lists;

use App\Models\AdminUserQuery;
use App\Models\AdminUserCredentialQuery;

class AdminUserList extends BaseList {
	private $users;
	
	/**
	 * Create a new AdminUserList instance.
	 *
	 * @return bool
	 */
	public function __construct($request,$path,$page)
	{
		$this->keys = array('#','name','login','email','status','default_language','credentials','created');
		$this->createList($request,$path,$page);
	}
    
    /**
	 * Create AdminUser list.
	 *
	 * @return array
	 */
    public function createList($request,$path,$page){
		$admin_user_filter = $request->all();
		$this->handleFilterRequest($admin_user_filter, 'admin_user_filter');
		
		if(is_null($page) || $page < 1) $page = 1;
		$cnt = $this->users->count();
		$maxPages = ceil($cnt/$this->maxPerPage);
		if($maxPages < $page) $page = $maxPages;
		
		$this->setPaginationForm($cnt, $page, $path);
		
	    foreach($this->users->paginate($page, $this->maxPerPage) as $key => $user){
			$user_id = $user->getId();
			$this->data_arr[$user_id]['#'] = ($page - 1) * $this->maxPerPage + $key+1;
			$this->data_arr[$user_id]['name'] = $user->getName();
			$this->data_arr[$user_id]['login'] = $user->getLogin();
			$this->data_arr[$user_id]['email'] = $user->getEmail();
			$this->data_arr[$user_id]['status'] = $user->getStatus();
			$this->data_arr[$user_id]['default_language'] = $user->getTranslationLanguage()->getName();
			$userCredentials = AdminUserCredentialQuery::create()
				->where('admin_user_id = '.$user_id)
				->find();
			$credentials = "<ul class='list-left'>";
			foreach($userCredentials as $credential){
				$credentials .= "<li>".$credential->getAdminCredential()->getName()."</li>";
			}
			$credentials .= "</ul>";
			$this->data_arr[$user_id]['credentials'] = $credentials;
			$this->data_arr[$user_id]['created'] = $user->getCreatedAt();//->format('Y-m-d H:i:s');
	    }
    }
	
	/**
	 * Create AdminUser query.
	 *
	 */
	protected function createQuery($array, $search){
		$this->users = AdminUserQuery::create();
		if(isset($array['Name']) && $array['Name'] !== "") $this->users->where("admin_user.name like '%".$array['Name']."%'");
		if(isset($array['Login']) && $array['Login'] !== "") $this->users->where("admin_user.login like '%".$array['Login']."%'");
		if(isset($array['Email']) && $array['Email'] !== "") $this->users->where("admin_user.email like '%".$array['Email']."%'");
		if(isset($array['Status']) && $array['Status'] !== "") $this->users->where("admin_user.status = '".$array['Status']."'");
		if(isset($array['LanguageId']) && $array['LanguageId'] !== "") $this->users->where("admin_user.language_id = ".$array['LanguageId']);
		if(isset($array['CredentialId']) && $array['CredentialId'] !== "") {
			$this->users->useAdminUserCredentialQuery()
				->where("admin_user_credential.admin_credential_id = ".$array['CredentialId'])
				->endUse();
		}
		
		if($search) session(['admin_user_filter' => $array]);
	}

}
