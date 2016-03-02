<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lib\SendSms;
use App\Models\StudentQuery;
use App\Models\SubjectQuery;
use App\Models\PeriodQuery;
use App\Models\PeriodSchoolYearQuery;
use App\Models\SchoolYearQuery;
use App\Models\StudyProgramQuery;
use App\Models\Application;
use App\Models\ApplicationQuery;
use App\Models\ApplicationRequest;

class NowSmsController extends Controller {
  
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$storage_path = storage_path();		
		$sms_request = $request->all();
		$phone_number = $sms_request['sender'];
		$description = json_encode($sms_request);
		$student = StudentQuery::retrieveByPhoneNumber($phone_number);
		if (is_null($student)) {
			$msg_text = 'Niste registrovani. Kontaktirajte administratora PMF-a.';
			//$this->sendSms($phone_number, $msg_text, $description);
			exit;
		}
		if ($sms_request['sms_prefix'] !== 'PRIJAVA_ISPITA') {
			$msg_text = "Nepostojeca komanda! Za prijavu ispita poslati: ‘PRIJAVA_ISPITA <šifra_predmeta> <ispitni_rok>'";
			$this->sendSms($phone_number, $msg_text, $description);
			exit;
		}
		
		$fullsms = explode(" ",$sms_request['fullsms']);
		$subject_code = isset($fullsms[1]) ? $fullsms[1] : null;
		$period_name = isset($fullsms[2]) ? $fullsms[2] : null;
		
		if(!isset($subject_code) && !isset($period_name)) {
			$msg_text = 'Doslo je do greske, proverite unete podatke.';
			$this->sendSms($phone_number, $msg_text, $description);
			exit;
		}
		
		$subject = SubjectQuery::retrieveByCode($subject_code);
		if(is_null($subject)) {
			$msg_text = 'Nepostojeca šifra predmeta.';
			$this->sendSms($phone_number, $msg_text, $description);
			exit;
		}
		
		$period = $this->getPeriodIdByName($period_name);
		if(is_null($period)) {
			$msg_text = 'Ispitni rok ne postoji';
			$this->sendSms($phone_number, $msg_text, $description);
			exit;
		}
		$school_year_id = $this->getSchoolYearIdByDate();
		$periodSchoolYear = PeriodSchoolYearQuery::create()->findPk([$period->getId(), $school_year_id]);
		if(is_null($periodSchoolYear)) {
			$msg_text = 'Ispitni rok ne postoji';
			$this->sendSms($phone_number, $msg_text, $description);
			exit;
		}
		
		$studyProgram = StudyProgramQuery::create()->findPk([$subject->getId(), $student->getCourseId()]);
		if(is_null($studyProgram)) {
			$msg_text = 'Ovaj predmet nije u vašem studijskom programu.';
			$this->sendSms($phone_number, $msg_text, $description);
			exit;
		}
		
		$msg_text = $this->allowedToApply($student->getId(), $subject, $period->getId(), $school_year_id);
		if($msg_text !== null) {
			$this->sendSms($phone_number, $msg_text, $description);
			exit;
		}
		
		$application = new Application();
		$application->setStudentId($student->getId());
		$application->setSubjectId($subject->getId());
		$application->setPeriodId(8);
		$application->setSchoolYearId(8);
		$application->setApplicationDate(date('Y-m-d'));
		$application->save();
		$msg_text = 'Uspesno ste prijavili ispit.';
		$this->sendSms($phone_number, $msg_text, $description, $application->getId());
		exit;
	}
	
	private function sendSms($phone_number, $msg_text, $description, $application_id = null) {
		$applicationRequest = new ApplicationRequest();
		$applicationRequest->setApplicationId($application_id);
		$applicationRequest->setDescription($description);
		$applicationRequest->setResponse($msg_text);
		$applicationRequest->save();
		SendSms::Send($phone_number, $msg_text);
	}
	
	private function getSchoolYearIdByDate() {
		$schoolYear = SchoolYearQuery::create()
			->where("SchoolYear.date_start <= ?", date('Y-m-d'))
			->where("SchoolYear.date_end >= ?", date('Y-m-d'))
			->findOne();
		return $schoolYear->getId();
	}
	
	private function getPeriodIdByName($name) {
		$period = PeriodQuery::create()
			->where("Period.name like '%".$name."%'")
			->findOne();
		return $period;
	}
	
	private function allowedToApply($student_id, $subject, $period_id, $school_year_id) {
		$applications = ApplicationQuery::create()
			->where("Application.student_id = ?", $student_id)
			->where("Application.subject_id = ?", $subject->getId())
			//->where("period_id = ?", $period_id)
			->where("Application.school_year_id = ?", $school_year_id)
			->find();
		if(count($applications) == 3) {
			return "Izgubili ste pravo da polažete ispit iz predmeta ".$subject->getName();
		}
		foreach($applications as $application) {
			if($application->getPeriodId() == $period_id) {
				return "Vec ste prijavili ispit iz predmeta ".$subject->getName();
			}
			if($application->getExamScore() > 5) {
				return "Vec ste polozili ispit iz predmeta ".$subject->getName();
			}
		}
		return null;
	}

}
