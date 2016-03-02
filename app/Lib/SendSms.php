<?php
namespace App\Lib;
class SendSms
{
	public function __constrcut()
	{}
	public static function Send($phoneNoRecip,$msgText){
		$fp = fsockopen('127.0.0.1','8800', $errno, $errstr);
		if (!$fp){
			echo "errno: $errno \n";
			echo "errstr: $errstr\n";
			return $result;
		}
		fwrite($fp, "GET /?Phone=" . rawurlencode($phoneNoRecip) . "&Text=" .
			   rawurlencode($msgText) . " HTTP/1.0\n");
		$auth = 'nikola' . ":" . 'nikola123';
		$auth = base64_encode($auth);
		fwrite($fp, "Authorization: Basic " . $auth . "\n");
		fwrite($fp, "\n");
		$res = "";
		while(!feof($fp)) {
			$res .= fread($fp,1);
		}
		fclose($fp);
		return $res;
	}
}
?>