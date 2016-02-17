<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\StudyProgramQuery;

class StudyProgramRequest extends Request {

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
			'SubjectId' => 'required',
			'CourseId' => 'required',
            'Year' => 'required|digits_between:1,4',
            'Semester' => 'required|digits_between:1,2'
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
			
			if($sid !== $sid_orig || $cid !== $cid_orig) {
				$studyProgram = StudyProgramQuery::create()->findPk([$sid, $cid]);
				if(!is_null($studyProgram)){
					$validator->errors()->add('SubjectId', 'This combination of subject and course is taken.');
					$validator->errors()->add('CourseId', 'This combination of subject and course is taken.');
				}
			}
        });
    }

}
