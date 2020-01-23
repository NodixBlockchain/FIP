<?php namespace App\Models;
use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';

    protected $allowedFields = ['username', 'pwhash', 'creation_time'];

	protected $DATA_PATH =WRITEPATH.'/data/adm';

	public function getHash($fields)
	{
		 return hash('ripemd160', $fields['username'].$fields['pwhash'].$fields['creation_time']);
	}

	function array2fields($farray)
	{
		$fields['adm-username']=$farray[0];
		$fields['adm-pwhash']=$farray[1];
		$fields['creation-time']=$farray[2];

		$fields['regdate'] = date('m/d/Y',$fields['creation-time']);

		return $fields;
	}
	
	public function create_first_admin($fields)
	{
		$admDir = $this->DATA_PATH;

		if(!is_dir($admDir))
		{
			if(!mkdir($admDir))
				return FALSE;
		}

		$admins = scandir($admDir);

		foreach($admins as $admin)
		{
			if((is_dir($admin))&&(strlen($admin)>=40))
			{
				if(is_file($admDir.'/'.$admin.'/infos.csv'))
					return FALSE;
			}
		}

		return $this->dosave(['username' => $fields['username'], 'pw' => $fields['pw'], 'creation_time' => $fields['creation-time']]);
	}
	

	public function dosave($fields)
	{
		$hash  = $this->getHash($fields);
		$myDir = $this->DATA_PATH.'/'.$hash;

		$fields['pwhash'] = hash('sha256', $fields['pw']);

		if(is_dir($myDir))
			return FALSE;
		
		if(!mkdir($myDir))
			return FALSE;
		
		file_put_contents($myDir.'/infos.csv', $fields['username'].';'.$fields['pwhash'].';'.$fields['creation_time']."\n");

		return $hash;
	}
	
	public function doget($hash)
	{
		$myDir = $this->DATA_PATH.'/'.$hash;

		if(!is_dir($myDir))
			return FALSE;

		$data = file_get_contents($myDir.'/infos.csv');
		$data = substr($data, 0, -1);
		return $this->array2fields(explode(';', $data));
	}


	
	public function checkId($fields)
	{
		
		$pwHash = hash('sha256', $fields['pw']);


		$admins  = scandir($this->DATA_PATH);

		foreach($admins as $admin)
		{
			if(strlen($admin) == 40)
			{
				$infos = $this->doget($admin);

				if(($infos !== FALSE)&&($infos['adm-username'] == $fields['adm-username']) && ($infos['adm-pwhash'] == $pwHash))
				{
					$infos['adm-hash'] = $admin;
					return $infos;
				}
			}
		}

		return FALSE;

	}

	public function doupdate($userHash,$fields)
	{
		$myDir=$this->DATA_PATH.'/'.$userHash;

		if(!is_dir($myDir))
		{
			if(!mkdir($myDir))
				return FALSE;
		}

		$fields['email'] = strtolower ($fields['email']);

		file_put_contents($myDir.'/infos.csv', $fields['email'].';'.$fields['pwhash'].';'.$fields['weight_unit'].';'.$fields['temp_unit'].';'.$fields['timezone'].';'.$fields['creation_time']."\n");

		return TRUE;
	}

	public function doupdatepw($userHash,$pw)
	{
		$myDir=$this->DATA_PATH.'/'.$userHash;

		if(!is_dir($myDir))
		{
			if(!mkdir($myDir))
				return FALSE;
		}

		$infos = $this->doget($userHash);
		if(!$infos)
			return FALSE;


		$pwHash = hash('sha256', $pw);

		file_put_contents($myDir.'/infos.csv', $infos['user-email'].';'.$pwHash.';'.$infos['user-weight-unit'].';'.$infos['user-temp-unit'].';'.$infos['user-timezone'].';'.$infos['creation-time']."\n");

		return TRUE;
	}


	public function findbymail($email)
	{
		$email = strtolower ($email);

		$users  = scandir($this->DATA_PATH);
		foreach($users as $user)
		{
			if(strlen($user) == 40)
			{
				$infos = $this->doget($user);
				if($infos !== FALSE)
				{
					if($infos['user-email'] == $email)
					{
						return $user;
					}
				}
			}
		}
		return FALSE;
	}

	

	public function getCats($userHash)
	{
		$myDir = $this->DATA_PATH.'/'.$userHash;

		$myCats = scandir($myDir);
		$cats = [];

		foreach($myCats as $cat)
		{
			if(strlen($cat) == 40)
			{
				array_push($cats,$cat);
			}
			
		}

		return $cats;
	}


}