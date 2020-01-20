<?php namespace App\Models;
use CodeIgniter\Model;

class SymptomsModel extends Model
{
 protected $table = 'cat';

    protected $allowedFields = ['cat_hash','date','symptoms_misc','symptoms_misc_other','symptoms_wet','symptoms_neuro','symptoms_ocular','symptoms_FIP','symptoms_effusion'];

	protected $DATA_PATH =WRITEPATH.'/data';
	protected $TEMP_PATH =WRITEPATH.'/data/tmp';

	public function getHash($fields)
	{
		 return hash('ripemd160', $fields['date'].implode('/',$fields['symptoms-misc']).$fields['symptoms-misc-other'].implode('/',$fields['symptoms-wet']).implode('/',$fields['symptoms-neuro']).implode('/',$fields['symptoms-ocular']).implode('/',$fields['symptoms-FIP']).implode('/',$fields['symptoms-effusion']));
	}

	function array2fields($farray)
	{

		if(count($farray)==8)
		{
			$fields['date']=$farray[0];
			$fields['symptoms-misc']=$farray[1]?explode('/',$farray[1]):[];
			$fields['symptoms-misc-other']=$farray[2];
			$fields['symptoms-wet']=$farray[3]?explode('/',$farray[3]):[];
			$fields['symptoms-neuro']=$farray[4]?explode('/',$farray[4]):[];
			$fields['symptoms-ocular']=$farray[5]?explode('/',$farray[5]):[];
			$fields['symptoms-FIP']=$farray[6]?explode('/',$farray[6]):[];
			$fields['symptoms-effusion']=$farray[7]?explode('/',$farray[7]):[];
		}

		if(count($farray)==9)
		{
			$fields['date']=$farray[1];
			$fields['symptoms-misc']=$farray[2]?explode('/',$farray[2]):[];
			$fields['symptoms-misc-other']=$farray[3];
			$fields['symptoms-wet']=$farray[4]?explode('/',$farray[4]):[];
			$fields['symptoms-neuro']=$farray[5]?explode('/',$farray[5]):[];
			$fields['symptoms-ocular']=$farray[6]?explode('/',$farray[6]):[];
			$fields['symptoms-FIP']=$farray[7]?explode('/',$farray[7]):[];
			$fields['symptoms-effusion']=$farray[8]?explode('/',$farray[8]):[];
		}

		return $fields;
	}


	public function dosavetmp($fields)
	{
		$symFile = $this->TEMP_PATH.'/'.$fields['cat_hash'].'_symptoms';

		file_put_contents($symFile,  $fields['cat_hash'].';'.$fields['date'].';'.implode('/',$fields['symptoms_misc']).';'.$fields['symptoms_misc_other'].';'.implode('/',$fields['symptoms_wet']).';'.implode('/',$fields['symptoms_neuro']).';'.implode('/',$fields['symptoms_ocular']).';'.implode('/',$fields['symptoms_FIP']).';'.implode('/',$fields['symptoms_effusion'])."\n");

		return TRUE;
	}


	public function doloadtmp($catHash)
	{
		$symFile = $this->TEMP_PATH.'/'.$catHash.'_symptoms';

		if(!is_file($symFile))
			return FALSE;
		
		$data	= file_get_contents($symFile);
		$data	= substr($data, 0, -1);
		$farray = explode(';', $data);

		return $this->array2fields($farray);
	}

		
	public function validate_tmp_cat($catHash, $userhash)
	{
		$userDir=$this->DATA_PATH.'/users';

		if(!is_dir($userDir))
			return FALSE;

		$myDir=$userDir.'/'.$userhash;

		if(!is_dir($myDir))
			return FALSE;

		$catDir = $myDir.'/'.$catHash;

		if(!is_dir($catDir))
			return FALSE;

		$src = $this->TEMP_PATH.'/'.$catHash.'_symptoms';

		if(!is_file($src))
			return FALSE;

		$symDir = $catDir.'/symptoms';

		if(!is_dir($symDir))
		{
			if(!mkdir($symDir))
				return FALSE;
		}
	
		$vals = $this->doloadtmp($catHash);

		if(!$vals)
			return FALSE;

		$date = str_replace("/","_",$vals['date']);
		$dst  = $symDir.'/'.$date.'.csv';

		rename($src,$dst);

	}

	public function doloaddate($userHash,$catHash,$date)
	{
		$symDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/symptoms';

		if(!is_dir($symDir))
			return FALSE;

		$symFiles = scandir($symDir);
		$Symptoms = [];

		foreach($symFiles as $symFile)
		{
			if(strlen($symFile)>2)
			{
				$symDate= str_replace('_','/',substr($symFile,0,-4));
				
				if($symDate == $date)
				{
					$data = file_get_contents($symDir.'/'.$symFile);
					$data = substr($data, 0, -1);
					$farray = explode(';', $data);
					return $this->array2fields($farray);
				}
			}
		}
		return FALSE;
	}


	public function doloaddates($userHash,$catHash)
	{
		$symDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/symptoms';

		if(!is_dir($symDir))
			return FALSE;

		$symFiles = scandir($symDir);
		$Symptoms = [];

		foreach($symFiles as $symFile)
		{
			if(strlen($symFile)>2)
			{
				$symDate= str_replace('_','/',substr($symFile,0,-4));
				array_push($Symptoms,$symDate);
			}
		}
		return $Symptoms;

	}

	

}