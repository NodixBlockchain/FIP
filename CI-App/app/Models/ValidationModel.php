<?php namespace App\Models;
use CodeIgniter\Model;

class ValidationModel extends Model
{
    protected $table = 'cat';

    protected $allowedFields = ['code', 'cat-hash', 'user-email', 'user-pw-hash', 'user-weight-unit', 'user-temp-unit', 'user-timezone'];

	protected $TEMP_PATH =WRITEPATH.'/data/tmp';

	public function create_code($catHash,$email,$pw,$weight,$temp,$tz)
	{
		$valDir=$this->TEMP_PATH.'/validation';

		if(!is_dir($valDir))
		{
			if(!mkdir($valDir))
				return FALSE;
		}

		$email = strtolower ($email);

		$validationCode='';

		for($n=0;$n<8;$n++)
		{
			$validationCode = $validationCode.rand(0,9);
		}

		$filePath = $valDir.'/'.$validationCode;
		$pwHash = hash('sha256', $pw);
		file_put_contents($filePath,$catHash.';'.$email.';'.$pwHash.';'.$weight.';'.$temp.';'.$tz.';'.time()."\n");

		return $validationCode;
	}

	public function getvalidation($validationCode)
	{
		$valDir=$this->TEMP_PATH.'/validation';

		if(!is_dir($valDir))
			return FALSE;

		$filePath = $valDir.'/'.$validationCode;

		if(!is_file($filePath))
			return FALSE;

		$data = file_get_contents($filePath);
		$data = substr($data,0,-1);

		$farray = explode(';', $data);

		return ['cat-hash'=> $farray[0],'user-email'=> $farray[1],'user-pw-hash'=> $farray[2],'user-weight-unit'=> $farray[3],'user-temp-unit'=> $farray[4], 'user-timezone'=> $farray[5], 'user-creation-time'=> $farray[6]];
	}
	
}