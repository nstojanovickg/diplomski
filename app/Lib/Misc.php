<?php namespace App\Lib;

use App\Models\TranslationLanguageQuery;
use App\Models\AdminUserCredentialQuery;
use Illuminate\Support\Facades\Session;

class Misc{
    
    /**
	 * Retrieve active translation languages.
	 *
	 * @return array
	 */
    public static function getLocales(){
        $translationLanguages = TranslationLanguageQuery::create()
            ->where('is_active = 1')
            ->find();
        $locales = array();
        foreach($translationLanguages as $translationLanguage){
            $culture = $translationLanguage->getCulture();
            $locales[$culture] = $translationLanguage->getName();
        }
        
        return $locales;
    }
    
    /**
	 * Set credentials and permision for user.
	 *
	 * @param  int  $id
	 */
    public static function setCredentials($id){
        $myCredentials = AdminUserCredentialQuery::create()
            ->filterByAdminUserId($id)
            ->useAdminCredentialQuery()
				->useAdminCredentialGroupQuery()
					->orderBySequence()
				->endUse()
            ->endUse()
            ->find();
        $credentials = array();
        $permissions = array();
        foreach($myCredentials as $key => $credential){
            $group = $credential->getAdminCredential()->getAdminCredentialGroup()->getTitle();
            $group_name = $credential->getAdminCredential()->getAdminCredentialGroup()->getName();
            $credentials[$group][$key]['title'] = $credential->getAdminCredential()->getTitle();
            $path = $group_name."/".$credential->getAdminCredential()->getName();
            $credentials[$group][$key]['path'] = $path;
            
            $permissions[$path]['read'] = $credential->getPermRead();
            $permissions[$path]['write'] = $credential->getPermWrite();
            $permissions[$path]['exec'] = $credential->getPermExec();
        }
        session(['myCredentials' => $credentials]);
        session(['myPermissions' => $permissions]);
    }
    
    /**
	 * Set site translation language.
	 *
	 * @param  int  $language_id
	 */
    public static function setLocale($language_id){
        $translationLanguage = TranslationLanguageQuery::create()->findPK($language_id);
        $culture = $translationLanguage->getCulture();
        Session::put('lang', $culture);
    }
    
}