<?php namespace App\Models;
use CodeIgniter\Model;

class MetricsModel extends Model
{
    protected $table = 'metrics';

    protected $allowedFields = ['cat_hash','date','cat_weight', 'cat_temp','cat_activity','cat_appetite'];

	protected $DATA_PATH =WRITEPATH.'/data/users';

	public function getHash($fields)
	{
		 return hash('ripemd160', $fields['cat_hash'].$fields['date'].$fields['cat_weight'].$fields['cat_temperature'].$fields['cat_activity'].$fields['cat_appetite']);
	}
	
	function array2fields($farray)
	{
		$fields['cat-hash']		=$farray[0];
		$fields['date']			=$farray[1];
		$fields['cat-weight']	=$farray[2];
		$fields['cat-temperature']=$farray[3];
		$fields['cat-activity']	=$farray[4];
		$fields['cat-appetite']	=$farray[5];
		return $fields;
	}

	public function dosave($userHash,$fields)
	{
		$infosDir = $this->DATA_PATH.'/'.$userHash.'/'. $fields['cat_hash'].'/infos';

		if(!is_dir($infosDir))
		{
			if(!mkdir($infosDir))
			  return FALSE;
		}

		$filePath = $infosDir.'/'.str_replace('/','_',$fields['date']).'.csv';

		file_put_contents($filePath, $fields['cat_hash'].';'.$fields['date'].';'.$fields['cat_weight'].';'.$fields['cat_temperature'].';'.$fields['cat_activity'].';'.$fields['cat_appetite']."\n");
		return TRUE;
	}

	public function doloaddate($userHash,$catHash,$date)
	{
		$infosDir = $this->DATA_PATH.'/'.$userHash.'/'.$catHash.'/infos';

		if(!is_dir($infosDir))
			 return FALSE;
			
		$infosPath = $infosDir.'/'.str_replace('/','_',$date).'.csv';

		if(!is_file($infosPath))
			return FALSE;

		$data = file_get_contents($infosPath);
		$data = substr($data, 0, -1);
		$farray = explode(';', $data);
		return $this->array2fields($farray);
	}
	
	public function delmetricsdate($userHash,$catHash,$date)
	{
		$infosDir = $this->DATA_PATH.'/'.$userHash.'/'.$catHash.'/infos';

		if(!is_dir($infosDir))
			return FALSE;

		$tFile = str_replace('/','_',$date).'.csv';

		$files = scandir($infosDir);

		foreach($files as $file)
		{
			if($file==$tFile)
				unlink($infosDir.'/'.$file);
		}

	}

	public function doloaddates($userHash,$catHash)
	{
		$infosDir =  $this->DATA_PATH.'/'.$userHash.'/'.$catHash.'/infos';

		if(!is_dir($infosDir))
			return  [];

		$infosDates = scandir($infosDir);
		$Infos = [];

		foreach($infosDates as $infosDate)
		{
			if(($infosDate!='.')&&($infosDate!='..'))
			{
				array_push($Infos,str_replace('_','/',substr($infosDate,0,-4)));
			}
		}

		return $Infos;
	}
	

}