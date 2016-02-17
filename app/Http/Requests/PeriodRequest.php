<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\PeriodSchoolYearQuery;

class PeriodRequest extends Request {

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
			'PeriodId' => 'required',
			'SchoolYearId' => 'required',
			'DateStart' => 'date',
			'DateEnd' => 'date'
		];
	}
	
	public function customValidation($validator){
        $validator->after(function($validator)
        {
			$arr = Request::all();
			$pid = $arr['PeriodId'];
			$pid_orig = isset($arr['PeriodIdOrig']) ? $arr['PeriodIdOrig'] : false;
			$syid = $arr['SchoolYearId'];
			$syid_orig = isset($arr['SchoolYearIdOrig']) ? $arr['SchoolYearIdOrig'] : false;
			
			if($pid !== $pid_orig || $syid !== $syid_orig) {
				$periodSchoolYear = PeriodSchoolYearQuery::create()->findPk([$pid, $syid]);
				if(!is_null($periodSchoolYear)){
					$validator->errors()->add('PeriodId', 'This combination of period and school year is taken.');
					$validator->errors()->add('SchoolYearId', 'This combination of period and school year is taken.');
				}
			}
        });
    }

}
