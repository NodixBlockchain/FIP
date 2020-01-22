<?php namespace App\Models;
use CodeIgniter\Model;

require_once (APPPATH."Libraries/ExifCleaning.php");

class BloodModel extends Model
{
    protected $table = 'blood';

    protected $allowedFields = ['cat_hash','cat_blood_date', 'cat_red_cells','cat_hematocrit','cat_hemaglobin' ,'cat_white_cells' ,'cat_lymphocytes','cat_neutrophils','cat_total_protein','cat_albumin','cat_globulin','cat_ag_ratio','cat_total_bilirubin'];

	protected $DATA_PATH =WRITEPATH.'/data';
	protected $TEMP_PATH =WRITEPATH.'/data/tmp';

	public function getHash($fields)
	{
		 return hash('ripemd160', $fields['cat_hash'].$fields['cat_blood_date'].$fields['cat_red_cells'].$fields['cat_hematocrit'].$fields['cat_hemaglobin'].$fields['cat_white_cells'].$fields['cat_lymphocytes'].$fields['cat_neutrophils'].$fields['cat_total_protein'].$fields['cat_albumin'].$fields['cat_globulin'].$fields['cat_ag_ratio'].$fields['cat_total_bilirubin']);
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

		$path = $this->TEMP_PATH.'/blood_'.$fields['cat_hash'];

		if(!is_dir($path))
		{
			if(!mkdir($path))
			  return FALSE;
		}

		file_put_contents($path.'/blood', $fields['cat_hash'].';'.$fields['cat_blood_date'].';'.$fields['cat_red_cells'].';'.$fields['cat_hematocrit'].';'.$fields['cat_hemaglobin'].';'.$fields['cat_white_cells'].';'.$fields['cat_lymphocytes'].';'.$fields['cat_neutrophils'].';'.$fields['cat_total_protein'].';'.$fields['cat_albumin'].';'.$fields['cat_globulin'].';'.$fields['cat_ag_ratio'].';'.$fields['cat_total_bilirubin']."\n");
		return $hash;
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
		$fileName = $fileHash.'_'.str_replace('/','_',$date);

		rename($file->getTempName(),$picDir.'/'.$fileName);

		ExifCleaning::adjustImageOrientation($picDir.'/'.$fileName); 

		return $fileName;
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

	public function dosave($userHash,$fields)
	{

		$bloodDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$fields['cat_hash'].'/bloods';

		if(!is_dir($bloodDir))
		{
			if(!mkdir($bloodDir))
				return FALSE;
		}

		$bloodDate = str_replace('/','_',$fields['cat_blood_date']);

		$bloodDateDir = $bloodDir.'/'.$bloodDate;

		if(!is_dir($bloodDateDir))
		{
			if(!mkdir($bloodDateDir))
				return FALSE;
		}

		$bloodPath = $bloodDateDir.'/values.csv';

		file_put_contents($bloodPath, $fields['cat_hash'].';'.$fields['cat_blood_date'].';'.$fields['cat_red_cells'].';'.$fields['cat_hematocrit'].';'.$fields['cat_hemaglobin'].';'.$fields['cat_white_cells'].';'.$fields['cat_lymphocytes'].';'.$fields['cat_neutrophils'].';'.$fields['cat_total_protein'].';'.$fields['cat_albumin'].';'.$fields['cat_globulin'].';'.$fields['cat_ag_ratio'].';'.$fields['cat_total_bilirubin']."\n");
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
	

	public function validate_tmp_cat($catHash,$newCatHash,$userHash)
	{
		$userDir=$this->DATA_PATH.'/users';

		if(!is_dir($userDir))
			return FALSE;

		$myDir=$userDir.'/'.$userHash;

		if(!is_dir($myDir))
			return FALSE;

		$catDir = $myDir.'/'.$newCatHash;

		if(!is_dir($catDir))
			return FALSE;
		
		$src = $this->TEMP_PATH.'/blood_'.$catHash.'/blood';

		if(!is_file($src))
			return FALSE;

		$vals = $this->doloadtmp($catHash);

		if(!$vals)
			return FALSE;

		$this->dosave($userHash,['cat_hash' => $newCatHash,
								 'cat_blood_date' => $vals['cat-blood-date'],
								 'cat_red_cells' => $vals['cat-red-cells'],
								 'cat_hematocrit' => $vals['cat-hematocrit'],
								 'cat_hemaglobin' => $vals['cat-hemaglobin'],
								 'cat_white_cells' => $vals['cat-white-cells'],
								 'cat_lymphocytes' => $vals['cat-lymphocytes'],
								 'cat_neutrophils' => $vals['cat-neutrophils'],
								 'cat_total_protein' => $vals['cat-total-protein'],
								 'cat_albumin' => $vals['cat-albumin'],
								 'cat_globulin' => $vals['cat-globulin'],
								 'cat_ag_ratio' => $vals['cat-ag-ratio'],
								 'cat_total_bilirubin' => $vals['cat-total-bilirubin']]);

	}
}