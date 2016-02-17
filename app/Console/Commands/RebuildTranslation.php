<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Models\TranslationLanguageQuery;
use App\Models\TranslationKeywordQuery;
use App\Models\TranslationLanguageKeywordQuery;
use App\Models\TranslationCatalogQuery;

class RebuildTranslation extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'rebuild-translation';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Rebuild translation for general catalog.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$translationLanguageKeywords = TranslationLanguageKeywordQuery::create()
			->useTranslationLanguageQuery()
			->where('translation_language.is_active = 1')
			->endUse()
			->useTranslationKeywordQuery()
			->useTranslationCatalogQuery()
			->where("translation_catalog.name = 'general'")
			->endUse()
			->endUse()
			->find();
		$translation_lang_keyword_arr = array();
		$languages = array();
		foreach($translationLanguageKeywords as $translationLanguageKeyword){
			$lang_culture = $translationLanguageKeyword->getTranslationLanguage()->getCulture();
			$keyword = $translationLanguageKeyword->getTranslationKeyword()->getKeyword();
			$translation = $translationLanguageKeyword->getTranslation();
			if(!isset($languages[$lang_culture])){
				$languages[$lang_culture] = $lang_culture;
				$translation_lang_keyword_arr[$lang_culture] = '<?php

return [
';
			}
			$translation_lang_keyword_arr[$lang_culture] .= "\t'".$keyword."' => '".$translation."',\n";
		}
		
		$path = base_path()."/resources/lang/";
		foreach($languages as $lang_culture){
			$string = $translation_lang_keyword_arr[$lang_culture] .= '];';
			
            $lang_path = $path.$lang_culture;
            if (!is_dir($lang_path))
                mkdir($lang_path);
                
			$fp=fopen($lang_path.'/general.php','w');
			fwrite($fp, $string);
			fclose($fp);
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			//['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	//protected function getOptions()
	//{
	//	return [
	//		['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
	//	];
	//}

}
