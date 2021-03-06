<?php namespace App\Models;
use CodeIgniter\Model;

class CatModel extends Model
{
    protected $table = 'cat';

    protected $allowedFields = ['cat_hash','user_hash','created_time', 'parent_first_name', 'parent_last_name', 'fb_name','cat_name','cat_birthdate','cat_birthdate_exact','cat_gender','cat_fixed','cat_breed','cat_diagnosis','cat_diagnosis_date'];

	protected $DATA_PATH =WRITEPATH.'/data';
	protected $TEMP_PATH =WRITEPATH.'/data/tmp';

	function save_diag($diag)
	{
		return str_replace("\n","",nl2br(str_replace("\r","",$diag)));
	}

	public function getHash($fields)
	{
		 return hash('ripemd160', $fields['user_hash'].$fields['created_time'].$fields['parent_first_name'].$fields['parent_last_name'].$fields['fb_name'].$fields['cat_name'].$fields['cat_birthdate'].$fields['cat_birthdate_exact'].$fields['cat_gender'].$fields['cat_fixed'].$fields['cat_breed'].$this->save_diag($fields['cat_diagnosis']).$fields['cat_diagnosis_date']);
	}

	function array2fields($farray)
	{
		$fields['cat-hash']=$farray[0];
		$fields['user-hash']=$farray[1];
		$fields['created-time']=$farray[2];
		$fields['parent-first-name']=$farray[3];
		$fields['parent-last-name']=$farray[4];
		$fields['fb-name']=$farray[5];
		$fields['cat-name']=$farray[6];
		$fields['cat-birthdate']=$farray[7];
		$fields['cat-birthdate-exact']=$farray[8];
		$fields['cat-gender']=$farray[9];
		$fields['cat-fixed']=$farray[10];
		$fields['cat-breed']=$farray[11];
		$fields['cat-diagnosis']=$farray[12];
		$fields['cat-diagnosis-date']=$farray[13];

		return $fields;
	}



	public function dogetpics($userHash,$catHash)
	{
		$catDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash;

		if(!is_dir($catDir))
			return FALSE;

		$picDir=$catDir.'/pics';

		$images = [];

		if(is_dir($picDir))
		{
			$files = scandir($picDir);
			foreach($files as $file)
			{
				if(($file!='.')&&($file!='..'))
					array_push($images,urlencode($file));
			}
		}
		return $images;
	}

	public function doloadeyespics($userHash,$catHash,$date)
	{
		$eyesDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/eyes/'.str_replace('/','_',$date);

		if(!is_dir($eyesDir))
			return FALSE;

		$eyes = scandir($eyesDir);

		$pictures=[];
		
		foreach($eyes as $eye)
		{
			if(strlen($eye) >= 40)
				array_push($pictures,$eye);
		}

		return $pictures;
	}

	public function dosaveeyespic($userHash,$catHash,$file,$date,&$error)
	{
		if(!$file->isValid())
		{
			$error = $file->getErrorString().'('.$file->getError().')';
			return FALSE;
		}

		$eyesDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/eyes';

		if(!is_dir($eyesDir))
		{
			if(!mkdir($eyesDir))
				return FALSE;
		}

		$date = str_replace('/','_',$date);
		$dateDir = $eyesDir.'/'. $date;

		if(!is_dir($dateDir))
		{
			if(!mkdir($dateDir))
				return FALSE;
		}
			
		$fileHash = hash('ripemd160', file_get_contents($file->getTempName()));
		$fileName = $fileHash.'_'.$date;

		rename($file->getTempName(),$dateDir.'/'.$fileName);

		return $fileName;
	}

	public function deleyespic($userHash,$catHash,$date,$file)
	{
		$date = str_replace('/','_',$date);

		$picDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/eyes/'.$date;

		$picFile = $picDir.'/'.$file;

		if(!is_file($picFile))
			return FALSE;

		unlink($picFile);

		if(!(new \FilesystemIterator($picDir))->valid())
			rmdir($picDir);

		return TRUE;

	}

	public function dosavexrayspic($userHash,$catHash,$file,$date,&$error)
	{
		if(!$file->isValid())
		{
			$error = $file->getErrorString().'('.$file->getError().')';
			return FALSE;
		}

		$xraysDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/xrays';

		if(!is_dir($xraysDir))
		{
			if(!mkdir($xraysDir))
				return FALSE;
		}

		$date = str_replace('/','_',$date);
		$dateDir = $xraysDir.'/'. $date;

		if(!is_dir($dateDir))
		{
			if(!mkdir($dateDir))
				return FALSE;
		}
			
		$fileHash = hash('ripemd160', file_get_contents($file->getTempName()));
		$fileName = $fileHash.'_'.$date;

		rename($file->getTempName(),$dateDir.'/'.$fileName);

		return $fileName;
	}

	public function delxrayspic($userHash,$catHash,$date,$file)
	{
		$date = str_replace('/','_',$date);

		$picDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/xrays/'.$date;

		$picFile = $picDir.'/'.$file;

		if(!is_file($picFile))
			return FALSE;

		unlink($picFile);

		if(!(new \FilesystemIterator($picDir))->valid())
			rmdir($picDir);

		return TRUE;

	}

	

	public function doloadeyesdates($userHash,$catHash)
	{
		$eyesDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/eyes';

		if(!is_dir($eyesDir))
			return FALSE;

		$eyesDates = scandir($eyesDir);
		$Eyes = [];

		foreach($eyesDates as $eyesDate)
		{
			if(($eyesDate!='.')&&($eyesDate!='..'))
			{
				array_push($Eyes,str_replace('_','/',$eyesDate));
			}
		}
		return $Eyes;
	}


	public function doloadxrayspics($userHash,$catHash,$date)
	{
		$xraysDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/xrays/'.str_replace('/','_',$date);

		if(!is_dir($xraysDir))
			return FALSE;

		$Xrays = scandir($xraysDir);

		$pictures=[];
		
		foreach($Xrays as $Xray)
		{
			if(strlen($Xray) >= 40)
				array_push($pictures,$Xray);
		}

		return $pictures;
	}

	public function doloadxraysdates($userHash,$catHash)
	{
		$xraysDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/xrays';

		if(!is_dir($xraysDir))
			return FALSE;

		$xraysDates = scandir($xraysDir);
		$Xrays = [];

		foreach($xraysDates as $xrayDate)
		{
			if(($xrayDate!='.')&&($xrayDate!='..'))
			{
				array_push($Xrays,str_replace('_','/',$xrayDate));
			}
		}
		return $Xrays;
	}

	public function doloadechopics($userHash,$catHash,$date)
	{
		$xraysDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/echos/'.str_replace('/','_',$date);

		if(!is_dir($xraysDir))
			return FALSE;

		$Xrays = scandir($xraysDir);

		$pictures=[];
		
		foreach($Xrays as $Xray)
		{
			if(strlen($Xray) >= 40)
				array_push($pictures,$Xray);
		}

		return $pictures;
	}

	public function dosaveechopic($userHash,$catHash,$file,$date,&$error)
	{
		if(!$file->isValid())
		{
			$error = $file->getErrorString().'('.$file->getError().')';
			return FALSE;
		}

		$echoDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/echos';

		if(!is_dir($echoDir))
		{
			if(!mkdir($echoDir))
				return FALSE;
		}

		$date = str_replace('/','_',$date);
		$dateDir = $echoDir.'/'. $date;

		if(!is_dir($dateDir))
		{
			if(!mkdir($dateDir))
				return FALSE;
		}
			
		$fileHash = hash('ripemd160', file_get_contents($file->getTempName()));
		$fileName = $fileHash.'_'.$date;

		rename($file->getTempName(),$dateDir.'/'.$fileName);

		return $fileName;
	}

	public function delechopic($userHash,$catHash,$date,$file)
	{
		$date = str_replace('/','_',$date);

		$picDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/echos/'.$date;

		$picFile = $picDir.'/'.$file;

		if(!is_file($picFile))
			return FALSE;

		unlink($picFile);

		if(!(new \FilesystemIterator($picDir))->valid())
			rmdir($picDir);

		return TRUE;

	}

	public function doloadechodates($userHash,$catHash)
	{
		$echoDir = $this->DATA_PATH.'/users/'.$userHash.'/'.$catHash.'/echos';

		if(!is_dir($echoDir))
			return FALSE;

		$echoDates = scandir($echoDir);
		$Echos = [];

		foreach($echoDates as $echoDate)
		{
			if(($echoDate!='.')&&($echoDate!='..'))
			{
				array_push($Echos,str_replace('_','/',$echoDate));
			}
		}
		return $Echos;
	}

	public function doget($userHash,$hash)
	{
		$catFile = $this->DATA_PATH.'/users/'.$userHash.'/'.$hash.'/catinfos.csv';

		if(!is_file($catFile))
			return FALSE;
		
		$data = file_get_contents($catFile);
		$data = substr($data, 0, -1);
		$farray = explode(';', $data);
		return $this->array2fields($farray);	
	}

	public function dogetAll($first = 0, $count = 10)
	{
		$userDir = $this->DATA_PATH.'/users';

		if(!is_dir($userDir))
			return FALSE;

		$users = scandir($userDir);

		$allCats = [];

		foreach($users as $user)
		{
			if(strlen($user)>=40)
			{
				$cats = scandir($userDir.'/'.$user);
				foreach($cats as $cat)
				{
					if(strlen($cat)>=40)
					{
						$theCat = $this->doget($user, $cat);
						

						array_push($allCats, $theCat);
					}

				

				}
			}
		}
		return $allCats;
	}
}