<?php namespace App\Models;
use CodeIgniter\Model;

class BloodModel extends Model
{
    protected $table = 'blood';

    protected $allowedFields = ['cat-hash','cat-blood-date', 'cat-red-cells','cat-hematocrit','cat-hemaglobin' ,'cat-white-cells' ,'cat-lymphocytes','cat-neutrophils','cat-total-protein','cat-albumin','cat-globulin','cat-ag-ratio','cat-total-bilirubin'];

	protected $DATA_PATH =WRITEPATH.'/data';
	protected $TEMP_PATH =WRITEPATH.'/data/tmp';

	
	public function dosavebloodtmp($catHash, $file,$date,&$error)
	{
		if(!$file->isValid()){
			$error = $file->getErrorString().'('.$file->getError().')';
			return FALSE;
		}

		$picDir=$this->TEMP_PATH.'/blood_'.$catHash;

		if(!is_dir($picDir))
		{
			if(!mkdir($picDir))
				return FALSE;
		}

		$fileHash = hash('ripemd160', file_get_contents($file->getTempName()));
		$fileName = $fileHash.'_'.$date;

		rename($file->getTempName(),$picDir.'/'.$fileName);

		return $fileName;
	}

	public function doloadbloodtmp($catHash)
	{
		$picDir=$this->TEMP_PATH.'/blood_'.$catHash;

		$images = [];

		if(is_dir($picDir))
		{
			$files = scandir($picDir);
			foreach($files as $file)
			{
				if(($file!='.')&&($file!='..')&&(strlen($file)>41))
					array_push($images,urlencode($file));
			}
		}
		return $images;
	}
	

	public function getHash($fields)
	{
		 return hash('ripemd160', $fields['cat-hash'].$fields['cat-blood-date'].$fields['cat-red-cells'].$fields['cat-hematocrit'].$fields['cat-hemaglobin'].$fields['cat-white-cells'].$fields['cat-lymphocytes'].$fields['cat-neutrophils'].$fields['cat-total-protein'].$fields['cat-albumin'].$fields['cat-globulin'].$fields['cat-ag-ratio'].$fields['cat-total-bilirubin']);
	}
	
	function array2fields($farray)
	{
		$fields['cat-hash']				=$farray[0];
		$fields['cat-blood-date']		=$farray[1];
		$fields['cat-red-cells']		=$farray[2];
		$fields['cat-hematocrit']		=$farray[3];
		$fields['cat-hemaglobin']		=$farray[4];
		$fields['cat-white-cells']		=$farray[5];
		$fields['cat-lymphocytes']		=$farray[6];
		$fields['cat-neutrophils']		=$farray[7];
		$fields['cat-total-protein']	=$farray[8];
		$fields['cat-albumin']			=$farray[9];
		$fields['cat-globulin']			=$farray[10];
		$fields['cat-ag-ratio']			=$farray[11];
		$fields['cat-total-bilirubin']	=$farray[12];

		return $fields;
	}
	
	function defaultValues()
	{
		return ['cat-red-cells' => 0,
				'cat-hematocrit' => 0,
				'cat-hemaglobin' => 0,
				'cat-white-cells' => 0,
				'cat-lymphocytes' => 0,
				'cat-neutrophils' => 0,
				'cat-total-protein' => 0,
				'cat-albumin' => 0,
				'cat-globulin' => 0,
				'cat-ag-ratio' => 0,
				'cat-total-bilirubin' => 0];	
	}

	public function dosavetmp($fields)
	{
		$hash=$this->getHash($fields);

		$path = $this->TEMP_PATH.'/blood_'.$fields['cat-hash'];

		if(!is_dir($path))
		{
			if(!mkdir($path))
			  return FALSE;
		}

		file_put_contents($path.'/blood', $fields['cat-hash'].';'.$fields['cat-blood-date'].';'.$fields['cat-red-cells'].';'.$fields['cat-hematocrit'].';'.$fields['cat-hemaglobin'].';'.$fields['cat-white-cells'].';'.$fields['cat-lymphocytes'].';'.$fields['cat-neutrophils'].';'.$fields['cat-total-protein'].';'.$fields['cat-albumin'].';'.$fields['cat-globulin'].';'.$fields['cat-ag-ratio'].';'.$fields['cat-total-bilirubin']."\n");
		return $hash;
	}




	public function doloadtmp($catHash)
	{
		$path = $this->TEMP_PATH.'/blood_'.$catHash.'/blood';

		if(!is_file($path))
			return $this->defaultValues();

		
		$data = file_get_contents($path);
		$data = substr($data, 0, -1);
		$farray = explode(';', $data);

		return $this->array2fields($farray);
		
		return FALSE;
	}

	public function dosave($userHash,$catHash,$fields)
	{

		$bloodDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/bloods';

		if(!is_dir($bloodDir))
		{
			if(!mkdir($bloodDir))
				return FALSE;
		}

		$bloodDate = str_replace('/','_',$fields['cat-blood-date']);

		$bloodDateDir = $bloodDir.'/'.$bloodDate;

		if(!is_dir($bloodDateDir))
		{
			if(!mkdir($bloodDateDir))
				return FALSE;
		}

		$bloodPath = $bloodDateDir.'/values.csv';

		file_put_contents($bloodPath, $fields['cat-hash'].';'.$fields['cat-blood-date'].';'.$fields['cat-red-cells'].';'.$fields['cat-hematocrit'].';'.$fields['cat-hemaglobin'].';'.$fields['cat-white-cells'].';'.$fields['cat-lymphocytes'].';'.$fields['cat-neutrophils'].';'.$fields['cat-total-protein'].';'.$fields['cat-albumin'].';'.$fields['cat-globulin'].';'.$fields['cat-ag-ratio'].';'.$fields['cat-total-bilirubin']."\n");
		return TRUE;
	}


	public function delblooddate($userHash,$catHash,$date)
	{
		
		$bloodDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/bloods';

		if(!is_dir($bloodDir))
			return FALSE;

		$bloodDate = str_replace('/','_',$date);

		$bloodDateDir = $bloodDir.'/'.$bloodDate;

		if(!is_dir($bloodDateDir))
			return FALSE;

		$files = scandir($bloodDateDir);

		foreach($files as $file)
		{
			if(($file!='.')&&($file!='..'))
				unlink($bloodDateDir.'/'.$file);
		}

		rmdir($bloodDateDir);

	}

	public function dosavebloodpic($userHash,$catHash,$file,$date,&$error)
	{
		$bloodDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/bloods';

		if(!is_dir($bloodDir))
		{
			if(!mkdir($bloodDir))
				return FALSE;
		}

		$bloodDate = str_replace('/','_',$date);

		$bloodDateDir = $bloodDir.'/'.$bloodDate;

		if(!is_dir($bloodDateDir))
		{
			if(!mkdir($bloodDateDir))
				return FALSE;
		}

		$fileHash = hash('ripemd160', file_get_contents($file->getTempName()));
		$fileName = $fileHash.'_'.$bloodDate;

		rename($file->getTempName(),$bloodDateDir.'/'.$fileName);

		return $fileName;
		
	}
	
	public function doloaddatepics($userHash,$catHash,$date)
	{
		$bloodDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/bloods/'.str_replace('/','_',$date);

		if(!is_dir($bloodDir))
			return FALSE;

		$bloods = scandir($bloodDir);

		$pictures=[];
		
		foreach($bloods as $blood)
		{
			if(strlen($blood) >= 40)
				array_push($pictures,$blood);
		}
		return $pictures;
	}

	public function doloaddate($userHash,$catHash,$date)
	{
		$bloodDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/bloods/'.str_replace('/','_',$date);

		if(!is_dir($bloodDir))
			return FALSE;

		$bloodPath = $bloodDir.'/values.csv';
		
		if(!is_file($bloodPath))
			return $this->defaultValues();

		$data = file_get_contents($bloodPath);
		$data = substr($data, 0, -1);
		$farray = explode(';', $data);
		return $this->array2fields($farray);
	}


	public function doloaddates($userHash,$catHash)
	{
		$bloodsDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/bloods';

		if(!is_dir($bloodsDir))
			return FALSE;

		$bloodDates = scandir($bloodsDir);
		$Bloods = [];

		foreach($bloodDates as $bloodDate)
		{
			if(($bloodDate!='.')&&($bloodDate!='..'))
			{
				array_push($Bloods,str_replace('_','/',$bloodDate));
			}
		}
		return $Bloods;
	}
	

	public function validate_tmp_cat($catHash,$userHash)
	{
		
		$userDir=$this->DATA_PATH.'/users';

		if(!is_dir($userDir))
			return FALSE;

		$myDir=$userDir.'/'.$userHash;

		if(!is_dir($myDir))
			return FALSE;

		$catDir = $myDir.'/'.$catHash;

		if(!is_dir($catDir))
			return FALSE;
		
		$bloodDir = $catDir.'/bloods';
	
		$src = $this->TEMP_PATH.'/blood_'.$catHash.'/blood';

		if(!is_file($src))
			return FALSE;

		$vals = $this->doloadtmp($catHash);

		if(!$vals)
			return FALSE;

		$date = str_replace("/","_",$vals['cat-blood-date']);

		$ddir = $bloodDir.'/'.$date;
		$dst  = $ddir.'/values.csv';

		rename($src,$dst);

	
	}
}