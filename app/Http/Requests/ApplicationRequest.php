<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class ApplicationRequest extends Request {

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
			'StudentId' => 'required',
			'SubjectId' => 'required',
			'PeriodId' => 'required',
			'SchoolYearId' => 'required',
			'ApplicationDate' => 'required|date',
            'ExamDate' => 'date',
			'ExamTime' => 'date_format:"H:i:s"',
			'ExamScore' => 'integer|min:5|max:10'
		];
	}

}
