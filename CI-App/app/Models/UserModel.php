<?php namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';

    protected $allowedFields = ['email', 'pwhash', 'weight-unit', 'temp-unit', 'timezone', 'creation-time'];

	protected $DATA_PATH =WRITEPATH.'/data/users';

	public function getHash($fields)
	{
		 return hash('ripemd160', $fields['email'].$fields['pwhash'].$fields['weight-unit'].$fields['temp-unit'].$fields['timezone'].$fields['creation-time']);
	}

	function array2fields($farray)
	{
		$fields['user-email']=$farray[0];
		$fields['pwhash']=$farray[1];
		$fields['user-weight-unit']=$farray[2];
		$fields['user-temp-unit']=$farray[3];
		$fields['user-timezone']=$farray[4];
		$fields['creation-time']=$farray[5];

		$fields['regdate'] = date('m/d/Y',$fields['creation-time']);

		return $fields;
	}
	
	

	
	public function doget($hash)
	{
		$userDir=$this->DATA_PATH.'/'.$hash;

		if(!is_dir($userDir))
			return FALSE;

		if(!is_file($userDir.'/infos.csv'))
			return FALSE;
		
		$data = file_get_contents($userDir.'/infos.csv');

		$data = substr($data, 0, -1);

		$farray = explode(';', $data);

		return $this->array2fields($farray);
	
	}


	public function dosave($fields)
	{
		$fields['email'] = strtolower ($fields['email']);

		$hash  = $this->getHash($fields);
		$myDir = $this->DATA_PATH.'/'.$hash;

		if(!is_dir($myDir))
		{
			if(!mkdir($myDir))
				return FALSE;
		}
		else
		{
			$infos = $this->doget($hash);

			if($infos['pwhash'] != $fields['pwhash'])
				return FALSE;
		}

		

		file_put_contents($myDir.'/infos.csv', $fields['email'].';'.$fields['pwhash'].';'.$fields['weight-unit'].';'.$fields['temp-unit'].';'.$fields['timezone'].';'.$fields['creation-time']."\n");

		return $hash;
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

		file_put_contents($myDir.'/infos.csv', $fields['email'].';'.$fields['pwhash'].';'.$fields['weight-unit'].';'.$fields['temp-unit'].';'.$fields['timezone'].';'.$fields['creation-time']."\n");

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

	
	public function checkId($fields)
	{
		
		$pwHash = hash('sha256', $fields['pw']);
		$users  = scandir($this->DATA_PATH);

		$fields['email'] = strtolower ($fields['email']);


		foreach($users as $user)
		{
			if(strlen($user) == 40)
			{
				$infos = $this->doget($user);

				if($infos !== FALSE)
				{
					if(($infos['user-email'] == $fields['email']) && ($infos['pwhash'] == $pwHash))
					{
						$infos['user-hash']=$user;
						return $infos;
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