<?php namespace App\Models;
use CodeIgniter\Model;

class TmpCatModel extends Model
{
    protected $table = 'cat';

    protected $allowedFields = ['created_time', 'parent_first_name', 'parent_last_name', 'fb_name','cat_name','cat_birthdate','cat_birthdate_exact','cat_gender','cat_fixed','cat_breed','cat_diagnosis','cat_diagnosis_date'];

	protected $DATA_PATH =WRITEPATH.'/data';
	protected $TEMP_PATH =WRITEPATH.'/data/tmp';

	public function getHash($fields)
	{
		 return hash('ripemd160', $fields['created_time'].$fields['parent_first_name'].$fields['parent_last_name'].$fields['fb_name'].$fields['cat_name'].$fields['cat_birthdate'].$fields['cat_birthdate_exact'].$fields['cat_gender'].$fields['cat_fixed'].$fields['cat_breed'].nl2br(str_replace("\r","",$fields['cat_diagnosis'])).$fields['cat_diagnosis_date']);
	}

	function array2fields($farray)
	{
		$fields['created-time']=$farray[0];
		$fields['parent-first-name']=$farray[1];
		$fields['parent-last-name']=$farray[2];
		$fields['fb-name']=$farray[3];
		$fields['cat-name']=$farray[4];
		$fields['cat-birthdate']=$farray[5];
		$fields['cat-birthdate-exact']=$farray[6];
		$fields['cat-gender']=$farray[7];
		$fields['cat-fixed']=$farray[8];
		$fields['cat-breed']=$farray[9];
		$fields['cat-diagnosis']=$farray[10];
		$fields['cat-diagnosis-date']=$farray[11];

		return $fields;
	}


	function save_diag($diag)
	{
		return str_replace(";",",",str_replace("\n","",nl2br(str_replace("\r","",$diag))));
	}

	public function isValidCat($catHash)
	{
		if(!is_file($this->TEMP_PATH.'/'.$catHash))
			return FALSE;


		return TRUE;
	}
	
	public function dosavetmp($fields)
	{
		if(array_key_exists('cat_hash',$fields))
			$hash = $fields['cat_hash'];
		else
			$hash = $this->getHash($fields);

		file_put_contents($this->TEMP_PATH.'/'.$hash,$fields['created_time'].';'.$fields['parent_first_name'].';'.$fields['parent_last_name'].';'.$fields['fb_name'].';'.$fields['cat_name'].';'.$fields['cat_birthdate'].';'.$fields['cat_birthdate_exact'].';'.$fields['cat_gender'].';'.$fields['cat_fixed'].';'.$fields['cat_breed'].';'.$this->save_diag($fields['cat_diagnosis']).';'.$fields['cat_diagnosis_date']."\n");

		return $hash;
	}
	
	public function dosavepictmp($catHash, $file,&$error)
	{
		if(!$this->isValidCat($catHash))
			return FALSE;

		if(!$file->isValid())
		{
			$error = $file->getErrorString().'('.$file->getError().')';
			return FALSE;
		}
			

		$picDir=$this->TEMP_PATH.'/pic_'.$catHash;

		if(!is_dir($picDir))
		{
			if(!mkdir($picDir))
				return FALSE;
		}
		rename($file->getTempName(),$picDir.'/'.$file->getClientName());

		return $file->getClientName();
	}

	public function delpic($catHash, $file)
	{
		unlink($this->TEMP_PATH.'/pic_'.$catHash.'/'.$file);
	}


	
	public function doloadpicstmp($catHash)
	{
		$picDir=$this->TEMP_PATH.'/pic_'.$catHash;

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

	public function dosaveeyestmp($catHash, $file, $date, &$error)
	{
		if(!$this->isValidCat($catHash))
			return FALSE;

		if(!$file->isValid())
		{
			$error = $file->getErrorString().'('.$file->getError().')';
			return FALSE;
		}

		$picDir=$this->TEMP_PATH.'/eyes_'.$catHash;

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

	public function deleyes($catHash, $file)
	{
		unlink($this->TEMP_PATH.'/eyes_'.$catHash.'/'.$file);
	}

	
	public function doloadeyestmp($catHash)
	{
		$picDir=$this->TEMP_PATH.'/eyes_'.$catHash;

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

	public function dogeteyesdate($catHash)
	{
		$picDir=$this->TEMP_PATH.'/eyes_'.$catHash;
		
		if(!is_dir($picDir))
			return FALSE;

		$files = scandir($picDir);
		foreach($files as $file)
		{
			if(strlen($file)>40)
				return str_replace('_','/',substr($file,41));
		}
		return FALSE;
	}

	public function dosavexraytmp($catHash, $file, $date, &$error)
	{
		if(!$this->isValidCat($catHash))
			return FALSE;

		if(!$file->isValid()){
			$error = $file->getErrorString().'('.$file->getError().')';
			return FALSE;
		}
			

		$picDir=$this->TEMP_PATH.'/xray_'.$catHash;

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

	public function delxray($catHash, $file)
	{
		unlink($this->TEMP_PATH.'/xray_'.$catHash.'/'.$file);
	}
	
	public function dogetxraydate($catHash)
	{
		$picDir=$this->TEMP_PATH.'/xray_'.$catHash;
		
		if(!is_dir($picDir))
			return FALSE;

		$files = scandir($picDir);
		foreach($files as $file)
		{
			if(strlen($file)>40)
				return str_replace('_','/',substr($file,41));
		}
		return FALSE;
	}

	public function doloadxraystmp($catHash)
	{
		$picDir=$this->TEMP_PATH.'/xray_'.$catHash;

		$images = [];

		if(is_dir($picDir))
		{
			$files = scandir($picDir);
			foreach($files as $file)
			{
				if(($file!='.')&&($file!='..'))
					array_push($images, urlencode($file));
			}
		}
		return $images;
	}

	public function dosaveechographytmp($catHash, $file, $date, &$error)
	{
		if(!$this->isValidCat($catHash))
			return FALSE;

		if(!$file->isValid()){
			$error = $file->getErrorString().'('.$file->getError().')';
			return FALSE;
		}

		$picDir=$this->TEMP_PATH.'/echo_'.$catHash;

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

	public function delecho($catHash, $file)
	{
		unlink($this->TEMP_PATH.'/echo_'.$catHash.'/'.$file);
	}

	public function dogetechodate($catHash)
	{
		$picDir=$this->TEMP_PATH.'/echo_'.$catHash;
		
		if(!is_dir($picDir))
			return FALSE;

		$files = scandir($picDir);
		foreach($files as $file)
		{
			if(strlen($file)>40)
				return str_replace('_','/',substr($file,41));
		}
		return FALSE;
	}

	public function doloadechographytmp($catHash)
	{
		$picDir=$this->TEMP_PATH.'/echo_'.$catHash;

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
	 

	public function dosavebloodtmp($catHash, $file)
	{
		if(!$this->isValidCat($catHash))
			return FALSE;

		if(!$file->isValid())
			return FALSE;

		$picDir=$this->TEMP_PATH.'/blood_'.$catHash;

		if(!is_dir($picDir))
		{
			if(!mkdir($picDir))
				return FALSE;
		}

		$fileHash = hash('ripemd160', file_get_contents($file->getTempName()));
		$fileName = $fileHash.'_'.date("Y_m_d");

		rename($file->getTempName(),$picDir.'/'.$fileName);

		return $fileName;
	}

	public function deltmpblood($catHash, $file)
	{
		unlink($this->TEMP_PATH.'/blood_'.$catHash.'/'.$file);
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
	
	public function hastmpBlood($catHash)
	{


		$picDir=$this->TEMP_PATH.'/blood_'.$catHash;

		if(!is_dir($picDir))
			return FALSE;

		$files = scandir($picDir);
		foreach($files as $file)
		{
			if(strlen($file)>=40)
				return TRUE;
		}

		return FALSE;
	}

	public function dogetblooddate($catHash)
	{
		$picDir=$this->TEMP_PATH.'/blood_'.$catHash;
		
		if(!is_dir($picDir))
			return FALSE;

		$files = scandir($picDir);
		foreach($files as $file)
		{
			if(strlen($file)>40)
				return str_replace('_','/',substr($file,41));
		}
		return FALSE;
	}

	public function doloadtmp($hash)
	{
		if(!is_file($this->TEMP_PATH.'/'.$hash))
			return FALSE;
		
		$data = file_get_contents($this->TEMP_PATH.'/'.$hash);

		$data=substr($data, 0, -1);

		$farray = explode(';', $data);

		return $this->array2fields($farray);
	}

	
	public function validate_tmp_cat($catHash, $userhash)
	{

		$catFile = $this->TEMP_PATH.'/'.$catHash;
		
		if(!is_file($catFile))
			return FALSE;

		$data = $this->doloadtmp($catHash);

		if($data === FALSE)
			return FALSE;

		/*
		echo "user $userhash:$catHash<br/>";
		echo "<br/>";
		*/

		$userDir = $this->DATA_PATH.'/users';

		if(!is_dir($userDir))
		{
			if(!mkdir($userDir))
				return FALSE;
		}

		$myDir = $userDir.'/'.$userhash;

		if(!is_dir($myDir))
			return FALSE;

		$catDir = $myDir.'/'.$catHash;

		if(!is_dir($catDir))
		{
			if(!mkdir($catDir))
				return FALSE;
		}

		$picDir = $catDir.'/pics';
		$eyeDir = $catDir.'/eyes';
		$xrayDir = $catDir.'/xrays';
		$echoDir = $catDir.'/echos';
		$bloodDir = $catDir.'/bloods';

		if(!is_dir($picDir))
		{
			if(!mkdir($picDir))
				return FALSE;
		}

		if(!is_dir($eyeDir))
		{
			if(!mkdir($eyeDir))
				return FALSE;
		}

		if(!is_dir($xrayDir))
		{
			if(!mkdir($xrayDir))
				return FALSE;
		}

		if(!is_dir($echoDir))
		{
			if(!mkdir($echoDir))
				return FALSE;
		}

		if(!is_dir($bloodDir))
		{
			if(!mkdir($bloodDir))
				return FALSE;
		}


		$src =	$catFile;
		$dst =	$catDir.'/catinfos.csv';

		/*echo "cat infos '$src' to '$dst' <br/><br/>";*/
		

		rename($src,$dst);


		

		/*
		echo "data : ";
		var_dump($data);
		echo "<br/>";
		echo "<br/>";
		*/

		$pics = $this->doloadpicstmp($catHash);

		foreach($pics as $pic)
		{
			$src =	$this->TEMP_PATH.'/pic_'.$catHash.'/'.$pic;
			$dst =	$picDir.'/'.$pic.'.jpg';

			rename($src, $dst );

			/* echo "cat picture : '$src' to '$dst' <br/>"; */
		}
		/* echo "<br/>"; */

		$pics = $this->doloadeyestmp($catHash);
		foreach($pics as $pic)
		{
			$date = substr($pic,41);
			$ddir = $eyeDir.'/'.$date;

			if(!is_dir($ddir))
			{
				if(!mkdir($ddir))
					return FALSE;
			}

			$src = $this->TEMP_PATH.'/eyes_'.$catHash.'/'.$pic;
			$dst = $ddir.'/'.$pic.'.jpg';

			rename($src, $dst);
			/*echo "cat eyes picture : '$src' to '$dst' <br/>";*/
		}
		/*echo "<br/>";*/

		$pics = $this->doloadxraystmp($catHash);
		foreach($pics as $pic)
		{
			$date = substr($pic,41);
			$ddir = $xrayDir.'/'.$date;

			if(!is_dir($ddir))
			{
				if(!mkdir($ddir))
					return FALSE;
			}

			$src = $this->TEMP_PATH.'/xray_'.$catHash.'/'.$pic;
			$dst = $ddir.'/'.$pic.'.jpg';

			rename($src, $dst);
			/*echo "cat xrays picture : '$src' to '$dst'  <br/>";*/
		}
		/*echo "<br/>";*/

		$pics = $this->doloadechographytmp($catHash);
		foreach($pics as $pic)
		{
			$date = substr($pic,41);
			$ddir = $echoDir.'/'.$date;

			if(!is_dir($ddir))
			{
				if(!mkdir($ddir))
					return FALSE;
			}

			$src = $this->TEMP_PATH.'/echo_'.$catHash.'/'.$pic;
			$dst = $ddir.'/'.$pic.'.jpg';

			rename($src, $dst);
			/*echo "cat echography picture : '$src' to '$dst'  <br/>";*/
		}
		/*echo "<br/>";*/

		$pics = $this->doloadbloodtmp($catHash);
		foreach($pics as $pic)
		{
			$date = substr($pic,41);
			$ddir = $bloodDir.'/'.$date;

			if(!is_dir($ddir))
			{
				if(!mkdir($ddir))
					return FALSE;
			}

			$src = $this->TEMP_PATH.'/blood_'.$catHash.'/'.$pic;
			$dst = $ddir.'/'.$pic.'.jpg';;

			rename($src, $dst);
			/*echo "cat blood picture : '$src' to '$dst' <br/>";*/
		}
		/*echo "<br/>";*/
			   
		return TRUE;
	}

}