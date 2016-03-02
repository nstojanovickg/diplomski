<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\EngagementQuery;

class EngagementRequest extends Request {

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
			'ProfessorId' => 'required',
			'SubjectId' => 'required',
			'CourseId' => 'required',
			'SchoolYearId' => 'required'
		];
	}
	
	public function customValidation($validator){
        $validator->after(function($validator)
        {
			$arr = Request::all();
			$sid = $arr['SubjectId'];
			$sid_orig = isset($arr['SubjectIdOrig']) ? $arr['SubjectIdOrig'] : false;
			$cid = $arr['CourseId'];
			$cid_orig = isset($arr['CourseIdOrig']) ? $arr['CourseIdOrig'] : false;
			$syid = $arr['SchoolYearId'];
			$syid_orig = isset($arr['SchoolYearIdOrig']) ? $arr['SchoolYearIdOrig'] : false;
			if($sid !== $sid_orig || $cid !== $cid_orig || $syid !== $syid_orig) {
				$engagement = EngagementQuery::create()->findPk([$sid, $cid, $syid]);
				if(!is_null($engagement)){
					//$validator->errors()->add('ProfessorId', 'This combination of professor, subject, course and school year is taken.');
					$validator->errors()->add('SubjectId', 'This combination of subject, course and school year is taken.');
					$validator->errors()->add('CourseId', 'This combination of subject, course and school year is taken.');
					$validator->errors()->add('SchoolYearId', 'This combination of subject, course and school year is taken.');
				}
			}
        });
    }

}
