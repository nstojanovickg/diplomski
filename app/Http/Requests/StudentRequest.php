<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\StudentQuery;

class StudentRequest extends Request {

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
			'IdentificationNumber' => 'required|integer',
			'SchoolYearId' => 'required',
			'CourseId' => 'required',
            'FirstName' => 'required|max:100',
			'LastName' => 'required|max:100',
			'BirthPlace' => 'required|max:100',
			'PhoneNumber' => 'required|max:20'
		];
	}
	
	public function customValidation($validator){
        $validator->after(function($validator)
        {
			$arr = Request::all();
			$idn = $arr['IdentificationNumber'];
			$idn_orig = isset($arr['IdentificationNumberOrig']) ? $arr['IdentificationNumberOrig'] : false;
			$syid = $arr['SchoolYearId'];
			$syid_orig = isset($arr['SchoolYearIdOrig']) ? $arr['SchoolYearIdOrig'] : false;
			
			if($idn !== $idn_orig || $syid !== $syid_orig) {
				$student = StudentQuery::create()
					->where('Student.identification_number = ?', $idn)
					->where('Student.school_year_id = ?', $syid)
					->findOne();
				if(!is_null($student)){
					$validator->errors()->add('IdentificationNumber', 'This combination of identification number and school year is taken.');
					$validator->errors()->add('SchoolYearId', 'This combination of identification number and school year is taken.');
				}
			}
        });
    }

}
