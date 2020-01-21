<?php namespace App\Controllers;


use App\Models\TmpCatModel;
use App\Models\CatModel;
use App\Models\SymptomsModel;
use App\Models\BloodModel;
use App\Models\ValidationModel;
use App\Models\UserModel;
use App\Models\MetricsModel;

class MyCat extends BaseController
{

	function checkDate($mydate)
	{
		$segs= explode('/',$mydate);

		if(count($segs)!=3)
			return FALSE;

		return checkdate($segs[0],$segs[1],$segs[2]);
	}
	
	public function index($catHash=NULL)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$user = new UserModel();
		$cat = new CatModel();
		$symptoms = new SymptomsModel();

		$my_cats = $user->getCats($userHash);

		$MyCats = [];

		foreach($my_cats as $my_cat)
		{
			$theCat = $cat->doget($userHash, $my_cat);
			$pics = $cat->dogetpics($userHash, $my_cat);

			if(count($pics)>0)
			{
				$theCat['picture'] = site_url('MyCat/catpic/'.$my_cat.'/'.$pics[0]);
			}
			else
			{
				$theCat['picture'] = base_url().'assets/img/cat_default.png';
			}

		
			array_push($MyCats, $theCat);
		}
		return view('MyCat/my_cats',['cats' => $MyCats]);
	}


	public function signin()
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if($userHash)
			return redirect()->to(site_url('MyCat/index'));

		$infos=['user-email' => '', 'user-pw' => ''];

		return view('MyCat/login', ['infos' => $infos, 'loginError' => FALSE, 'errors' => []]);
	}

	public function signout()
	{
		$session = \Config\Services::session();
		$session->destroy();
		return redirect()->to(site_url('MyCat/signin'));
	}

	public function do_login()
	{
		$user = new UserModel();

		$email = $this->request->getPost('user-email');
		$pw	= $this->request->getPost('user-pw');

		$userInfos = $user->checkId(['email' => $email, 'pw' => $pw]);

		if($userInfos === FALSE)
		{
			return view('MyCat/login', [ 'infos' => ['user-email' => $email, 'user-pw' => ''], 'loginError' => TRUE, 'errors' => []]);
		}
		else
		{
			$session = \Config\Services::session();
			$session->start();
			$session->set(['user-hash' => $userInfos['user-hash']]);

			return redirect()->to(site_url('MyCat/index'));
		}
	}

	public function catpic($catHash,$pic)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/users/'.$userHash.'/'.$catHash.'/pics/'.urldecode($pic));
	}

	public function eyespic($catHash,$date,$pic)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/users/'.$userHash.'/'.$catHash.'/eyes/'.urldecode($date).'/'.urldecode($pic));
	}

	public function bloodpic($catHash,$date,$pic)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/users/'.$userHash.'/'.$catHash.'/bloods/'.urldecode($date).'/'.urldecode($pic));
	}

	public function xrayspic($catHash,$date,$pic)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/users/'.$userHash.'/'.$catHash.'/xrays/'.urldecode($date).'/'.urldecode($pic));
	}

	public function echographypic($catHash,$date,$pic)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/users/'.$userHash.'/'.$catHash.'/echos/'.urldecode($date).'/'.urldecode($pic));
	}

	public function my_cat($catHash)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$user = new UserModel();
		$cat = new CatModel();
		
		$theCat = $cat->doget($userHash,$catHash);
		$pics = $cat->dogetpics($userHash,$catHash);

		$theCat['pictures'] = [];
		foreach($pics as $image)
		{
			array_push($theCat['pictures'], ['url' => site_url('MyCat/catpic/'.$catHash.'/'.$image)]);
		}


		return view('MyCat/my_cat',['cat' => $theCat]);
	}

	public function my_infos()
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$user = new UserModel();
		$userInfos = $user->doget($userHash);
				
		return view('MyCat/my_infos',['infos'=>$userInfos,'errors'=>[]]);
	}

	public function set_my_infos()
	{	
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');
		
		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		helper('form');

		$user = new UserModel();

		$userInfos = $user->doget($userHash);

		if(!$userInfos)
		{
			echo 'invalid user';
			return;
		}

		$isValid=$this->validate([	'user-email' => "required|trim|valid_email",
									'user-weight-unit' => 'in_list[kg,pnd]',
									'user-temp-unit' => 'in_list[celsius,fahrenheit]',
									'user-timezone' => 'timezone']);

		$mailUsed = FALSE;

		if(($isValid)&&(($userInfos['email'])!=$this->request->getPost('user-email')))
		{
			if($user->findbymail($this->request->getPost('user-email')))
			{
				$isValid = FALSE;
				$mailUsed = TRUE;
			}
		}

		if (!$isValid)
		{
			$errors = $this->validator->getErrors();

			if($mailUsed)
				$errors['user-email'] = 'email already used';


			return view('MyCat/my_infos',['infos' => $userInfos, 'errors' => $errors]);
		}
		else
		{
			$result = $user->doupdate ($userHash, [	'email' => $this->request->getPost('user-email'),
													'pwhash' => $userInfos['pwhash'],
													'weight_unit' => $this->request->getPost('user-weight-unit'),
													'temp_unit' => $this->request->getPost('user-temp-unit'),
													'timezone' => $this->request->getPost('user-timezone'),
													'creation_time'=> $userInfos['creation-time']]);

			return redirect()->to(site_url('MyCat/my_infos'));

		}
	}

	public function set_my_pw()
	{	
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		helper('form');

		$user = new UserModel();
		$userInfos = $user->doget($userHash);

		if(!$userInfos)
		{
			echo 'invalid user';
			return;
		}

		if (! $this->validate([	'user-pw' => "required|min_length[6]|max_length[32]",
								'user-pw2' => "matches[user-pw]"]))
		{
			
			return view('MyCat/my_infos',['infos' => $userInfos, 'errors' => $this->validator->getErrors()]);
		}
		else
		{
			$result = $user->doupdatepw ($userHash, $this->request->getPost('user-pw'));
			return redirect()->to(site_url('MyCat/my_infos'));
		}
	}

	public function my_cat_symptoms($catHash)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$user = new UserModel();
		$cat = new CatModel();
		$symptoms = new SymptomsModel();
				
		$theCat = $cat->doget($userHash, $catHash);
		
		$symDates = $symptoms->doloaddates($userHash, $catHash);
		$Symptoms = [];

		foreach($symDates as $symDate)
		{
			$values = $symptoms->doloaddate($userHash,$catHash,$symDate);
			array_push($Symptoms, ['symptoms-date' => $symDate, 'symptoms' => $values]);
		}

		
		return view('MyCat/cat_symptoms',['cat' => $theCat, 'symptomsDates' => $Symptoms]);
	}
	

	public function set_cat_infos($catHash, $date)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');
		
		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		helper('form');

		$isValid=$this->validate([	'cat-weight' => 'greater_than[0]',
									'cat-temperature' => 'greater_than[0]',
									'cat-activity' => 'greater_than_equal_to[0]|less_than_equal_to[5]',
									'cat-appetite' => 'greater_than_equal_to[0]|less_than_equal_to[5]']);

		$date = str_replace('_','/',$date);

		$dateError = FALSE;

		if(!$this->checkDate($date))
		{
			$dateError = TRUE;
			$isValid = FALSE;
		}
		
		if(!$isValid)
		{
			$user = new UserModel();
			$cat = new CatModel();
		
			$userInfos = $user->doget($userHash);		
			$theCat = $cat->doget($userHash,$catHash);

			$metricsDates = $metrics->doloaddates($userHash,$catHash);
			$Metrics = [];

			foreach($metricsDates as $metricsDate)
			{
				$values = $metrics->doloaddate($userHash,$catHash,$metricsDate);
				array_push($Metrics, ['metrics-date' => $metricsDate,'values'=>$values]);
			}

			$errors = $this->validator->getErrors();
			
			if($dateError)
				$errors['date'] = 'invalid date';

			return  view('MyCat/cat_infos',['cat' => $theCat, 'catinfos' => $this->request->getPost(), 'metrics' => $Metrics, 'userinfos' => $userInfos, 'errors' => $errors]);
		}
		else
		{
			$metrics = new MetricsModel();
			$result = $metrics->dosave ($userHash,[	'cat_hash' => $catHash,
													'date' => $date,
													'cat_weight' => $this->request->getPost('cat-weight'),
													'cat_temperature' => $this->request->getPost('cat-temperature'),
													'cat_activity' => $this->request->getPost('cat-activity'),
													'cat_appetite' => $this->request->getPost('cat-appetite')]);

			return redirect()->to(site_url('MyCat/my_cat_infos/'.$catHash));
		}
	}

	public function my_cat_del_metrics_date($catHash, $metricsDate)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$metricsDate = str_replace('_', '/', $metricsDate);

		if($this->checkDate($metricsDate))
		{
			$metrics = new MetricsModel();
			$metrics->delmetricsdate($userHash, $catHash, $metricsDate);
		}

		return redirect()->to(site_url('MyCat/my_cat_infos/'.$catHash));
	}

	public function my_cat_infos($catHash, $date = NULL)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$user = new UserModel();
		$cat = new CatModel();
		$metrics = new MetricsModel();

		$userInfos = $user->doget($userHash);		
		$theCat = $cat->doget($userHash,$catHash);

		$metricsDates = $metrics->doloaddates($userHash,$catHash);
		$Metrics = [];

		foreach($metricsDates as $metricsDate)
		{
			$values = $metrics->doloaddate($userHash,$catHash,$metricsDate);
			array_push($Metrics,['metrics-date' => $metricsDate, 'metrics-date-url' => str_replace('/','_',$metricsDate), 'values' => $values]);
		}

		if($date !== NULL)
		{
			$idate = str_replace('_','/',$date);

			if($this->checkDate($idate))
				$mDate = $date;
			else
				$mDate = date('m/d/Y');
		}
		else
			$mDate = date('m/d/Y');

		$catinfos = $metrics->doloaddate($userHash,$catHash,$mDate);

		if($catinfos === FALSE)
			$catinfos = ['date' => $mDate, 'cat-weight' => '', 'cat-temperature' => '', 'cat-activity' => 0, 'cat-appetite' => 0];

		$catinfos['metrics-date-url'] = str_replace('/','_',$mDate);


		return view('MyCat/cat_infos',['cat' => $theCat, 'catinfos' => $catinfos, 'metrics' => $Metrics, 'userinfos' => $userInfos, 'errors' =>[]]);
	}

	
	public function add_blood_pic($catHash)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		helper('form');

		$date = $this->request->getPost('blood-date');

		if(!$this->checkDate($date))
		{
			$date = date('m/d/Y');
			return redirect()->to(site_url('MyCat/my_cat_edit_blood/'.$catHash.'/'.$date.'/invalid+picture+date'));
		}

		if(!$this->validate(['cat-blood' => 'is_image[cat-blood]']))
			return redirect()->to(site_url('MyCat/my_cat_edit_blood/'.$catHash.'/'.$date.'/upload+a+valid+image'));

		$model = new BloodModel();
		$file = $this->request->getFile('cat-blood');
		$result = $model->dosavebloodpic($userHash,$catHash,$file,$date,$error);

		$date = str_replace("/","_",$date);
			
		if($result === FALSE)
			return redirect()->to(site_url('MyCat/my_cat_edit_blood/'.$catHash.'/'.$date.'/'.$error));
		else
			return redirect()->to(site_url('MyCat/my_cat_edit_blood/'.$catHash.'/'.$date));
	}

	public function add_blood_vals($catHash)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		helper('form');

		$blood = new BloodModel();

		if (! $this->validate([	'cat-red-cells' => "greater_than_equal_to[0]",
								'cat-hematocrit' => "greater_than_equal_to[0]",
								'cat-hemaglobin' => "greater_than_equal_to[0]",
								'cat-white-cells' => "greater_than_equal_to[0]",
								'cat-lymphocytes' => "greater_than_equal_to[0]",
								'cat-neutrophils' => "greater_than_equal_to[0]",
								'cat-total-protein' => "greater_than_equal_to[0]",
								'cat-albumin' => "greater_than_equal_to[0]",
								'cat-globulin' => "greater_than_equal_to[0]",
								'cat-ag-ratio' => "greater_than_equal_to[0]",
								'cat-total-bilirubin' => "greater_than_equal_to[0]"]))
		{
			$cat = new CatModel();
			$user = new UserModel();

			$theCat = $cat->doget($userHash,$catHash);
			$userInfos = $user->doget($userHash);	

			$blood_vals = $this->request->getPost();

			$pictures = [];
			$images = $blood->doloaddatepics($userHash, $catHash, $blood_vals['blood-date']);

			if($images !== FALSE)
			{
				foreach($images as $image)
				{
					array_push($pictures,['file' => $image, 'url' => site_url('MyCat/bloodpic/'.$catHash.'/'.str_replace('/','_',$blood_vals['blood-date']).'/'.$image), 'date' => $blood_vals['blood-date']]);
				}
			}

			$errors = $this->validator->getErrors();

			$Blood = ['blood-date' => $blood_vals['blood-date'], 'blood-date-url' =>  str_replace('/','_',$blood_vals['blood-date']), 'values' => $values, 'pictures' => $pictures];

			return view('MyCat/my_new_blood',['infos' => $userInfos, 'cat' => $theCat, 'blood' => $Blood, 'errors' => $errors]);
		}
		else
		{
			$blood->dosave($userHash, [ 'cat_hash' => $catHash,
									   'cat_blood_date' => $this->request->getPost('blood-date'),
										'cat_red_cells' => $this->request->getPost('cat-red-cells'),
										'cat_hematocrit' => $this->request->getPost('cat-hematocrit'),
										'cat_hemaglobin' => $this->request->getPost('cat-hemaglobin'),
										'cat_white_cells' => $this->request->getPost('cat-white-cells'),
										'cat_lymphocytes' => $this->request->getPost('cat-lymphocytes'),
										'cat_neutrophils' => $this->request->getPost('cat-neutrophils'),
										'cat_total_protein' =>$this->request->getPost('cat-total-protein'),
										'cat_albumin' => $this->request->getPost('cat-albumin'),
										'cat_globulin' => $this->request->getPost('cat-globulin'),
										'cat_ag_ratio' => $this->request->getPost('cat-ag-ratio'),
										'cat_total_bilirubin' => $this->request->getPost('cat-total-bilirubin')]);

			return redirect()->to(site_url('MyCat/my_cat_blood/'.$catHash));
		}
	}

	public function my_cat_del_blood_date($catHash, $bloodDate)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$bloodDate=str_replace('_','/',$bloodDate);

		if($this->checkDate($bloodDate))
		{
			$blood = new BloodModel();
			$blood->delblooddate($userHash, $catHash, $bloodDate);
		}

		return redirect()->to(site_url('MyCat/my_cat_blood/'.$catHash));
	}

	public function my_cat_edit_blood($catHash, $date = NULL, $error = NULL)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		if($date !== NULL)
		{
			$date = str_replace('_','/',$date);

			if($this->checkDate($date))
				$bloodDate = $date;
			else
				$bloodDate = date('m/d/Y');
		}
		else
			$bloodDate = date('m/d/Y');

		$blood = new BloodModel();
		$cat = new CatModel();
		$user = new UserModel();

		$theCat = $cat->doget($userHash,$catHash);
		$userInfos = $user->doget($userHash);	

		$values = $blood->doloaddate($userHash, $catHash, $bloodDate);
		
		if($values===FALSE)
			$values = $blood->defaultValues();

		$pictures = [];
		$images = $blood->doloaddatepics($userHash, $catHash, $bloodDate);

		if($images !== FALSE)
		{
			foreach($images as $image)
			{
				array_push($pictures,['file' => $image, 'url' => site_url('MyCat/bloodpic/'.$catHash.'/'.str_replace('/','_',$bloodDate).'/'.$image), 'date' => $bloodDate]);
			}
		}

		$Blood = ['blood-date' => $bloodDate, 'blood-date-url' => str_replace('/','_',$bloodDate), 'values' => $values, 'pictures' => $pictures];

		$errors = [];

		if($error)
			$errors['cat-blood'] = $error;

		return view('MyCat/my_new_blood',['infos' => $userInfos, 'cat' => $theCat, 'blood' => $Blood, 'errors' => $errors]);
	}

	public function my_cat_blood($catHash)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$blood = new BloodModel();
		$cat = new CatModel();

		$theCat = $cat->doget($userHash,$catHash);

		$bloodDates = $blood->doloaddates($userHash,$catHash);
		$Bloods = [];

		foreach($bloodDates as $bloodDate)
		{
			$values= $blood->doloaddate($userHash,$catHash,$bloodDate);
			$images= $blood->doloaddatepics($userHash,$catHash,$bloodDate);

			$pictures=[];
			foreach($images as $image)
			{
				array_push($pictures, ['file' => $image, 'url' => site_url('MyCat/bloodpic/'.$catHash.'/'.str_replace('/','_',$bloodDate).'/'.$image)]);
			}
			array_push($Bloods, ['blood-date' => $bloodDate, 'blood-date-url' => str_replace("/","_",$bloodDate), 'values' => $values, 'pictures' => $pictures]);
		}

		return view('MyCat/cat_bloods', ['cat' => $theCat, 'bloods' => $Bloods]);
	}

	public function add_eyes_pic($catHash)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$date = $this->request->getPost('eyes-date');

		if(!$this->checkDate($date))
			return redirect()->to(site_url('MyCat/my_cat_eyes/'.$catHash.'/invalid+picture+date'));

		helper('form');

		if(!$this->validate(['cat-eyes' => 'is_image[cat-eyes]']))
			return redirect()->to(site_url('MyCat/my_cat_eyes/'.$catHash.'/upload+a+valid+image'));

		$file = $this->request->getFile('cat-eyes');

		$model = new CatModel();
		
		$result = $model->dosaveeyespic($userHash, $catHash, $file, $date, $error);
			
		if($result === FALSE)
			return redirect()->to(site_url('MyCat/my_cat_eyes/'.$catHash.'/'.$error));
		else
			return redirect()->to(site_url('MyCat/my_cat_eyes/'.$catHash));
	}


	public function my_cat_del_eyes($catHash,$date,$pic,$error = NULL)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$cat = new CatModel();

		$cat->deleyespic($userHash,$catHash,$date,$pic);

		return redirect()->to(site_url('MyCat/my_cat_eyes/'.$catHash));
	}

	public function my_cat_eyes($catHash,$error = NULL)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$cat = new CatModel();

		$theCat = $cat->doget($userHash,$catHash);
		$EyesDates = $cat->doloadeyesdates($userHash,$catHash);

		$Eyes = [];

		foreach($EyesDates as $eyeDate)
		{
			$images = $cat->doloadeyespics($userHash, $catHash, $eyeDate);
			$pictures = [];

			foreach($images as $image)
			{
				array_push($pictures,['file'=>$image, 'url'=>site_url('MyCat/eyespic/'.$catHash.'/'.str_replace('/','_',$eyeDate).'/'.$image)]);
			}
			array_push($Eyes,['eye-date' => $eyeDate,'eye-date-url' => str_replace('/','_',$eyeDate), 'pictures' => $pictures]);
		}
	
		return view('MyCat/cat_eyes',['cat' => $theCat,'currentdate'=>date('m/d/Y') ,'eyes' => $Eyes, 'error' => urldecode($error)]);
	}


	public function add_xrays_pic($catHash)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$date = $this->request->getPost('xray-date');

		if(!$this->checkDate($date))
			return redirect()->to(site_url('MyCat/my_cat_xrays/'.$catHash.'/invalid+picture+date'));

		helper('form');
	
		if(!$this->validate(['cat-xray' => 'is_image[cat-xray]']))
			return redirect()->to(site_url('MyCat/my_cat_xrays/'.$catHash.'/upload+a+valid+image'));

		$file = $this->request->getFile('cat-xray');

		$model = new CatModel();
		
		$result = $model->dosavexrayspic($userHash,$catHash,$file,$date,$error);
			
		if($result === FALSE)
			return redirect()->to(site_url('MyCat/my_cat_xrays/'.$catHash.'/'.$error));
		else
			return redirect()->to(site_url('MyCat/my_cat_xrays/'.$catHash));
	}


	public function my_cat_del_xrays($catHash,$date,$pic,$error = NULL)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$cat = new CatModel();

		$cat->delxrayspic($userHash,$catHash,$date,$pic);

		return redirect()->to(site_url('MyCat/my_cat_xrays/'.$catHash));
	}


	public function my_cat_xrays($catHash, $error = NULL)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$cat = new CatModel();

		$theCat = $cat->doget($userHash,$catHash);

		$XraysDates = $cat->doloadxraysdates($userHash,$catHash);
		$Xrays = [];

		foreach($XraysDates as $XrayDate)
		{
			$images = $cat->doloadxrayspics($userHash,$catHash,$XrayDate);
			$pictures = [];
			foreach($images as $image)
			{
				array_push($pictures,['file'=>$image,'url'=>site_url('MyCat/xrayspic/'.$catHash.'/'.str_replace('/','_',$XrayDate).'/'.$image)]);
			}
			array_push($Xrays,['xray-date' => $XrayDate, 'xray-date-url' => str_replace('/','_',$XrayDate), 'pictures' => $pictures]);
		}

		return view('MyCat/cat_xrays',['cat' => $theCat, 'xrays' => $Xrays, 'xrayDate' => date('m/d/Y'), 'error' => urldecode($error)]);
	}

	public function add_echo_pic($catHash)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$date = $this->request->getPost('echography-date');

		if(!$this->checkDate($date))
			return redirect()->to(site_url('MyCat/my_cat_echographies/'.$catHash.'/invalid+picture+date'));

		helper('form');

		if(!$this->validate(['cat-echography' => 'is_image[cat-echography]']))
			return redirect()->to(site_url('MyCat/my_cat_echographies/'.$catHash.'/upload+a+valid+image'));

		$file = $this->request->getFile('cat-echography');

		$model = new CatModel();
		
		$result = $model->dosaveechopic($userHash,$catHash,$file,$date,$error);
			
		if($result === FALSE)
			return redirect()->to(site_url('MyCat/my_cat_echographies/'.$catHash.'/'.$error));
		else
			return redirect()->to(site_url('MyCat/my_cat_echographies/'.$catHash));
	}


	public function my_cat_del_echo($catHash,$date,$pic,$error = NULL)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$cat = new CatModel();

		$cat->delechopic($userHash,$catHash,$date,$pic);

		return redirect()->to(site_url('MyCat/my_cat_echographies/'.$catHash));
	}

	public function my_cat_echographies($catHash,$error = NULL)
	{
		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if(($userHash === FALSE)||($userHash === NULL))
			return redirect()->to(site_url('MyCat/signin'));

		$cat = new CatModel();

		$theCat = $cat->doget($userHash,$catHash);

		$EchoDates = $cat->doloadechodates($userHash,$catHash);
		$Echos = [];

		foreach($EchoDates as $EchoDate)
		{
			$images = $cat->doloadechopics($userHash,$catHash,$EchoDate);
			$pictures = [];

			foreach($images as $image)
			{
				array_push($pictures,['file' => $image, 'url' => site_url('MyCat/echographypic/'.$catHash.'/'.str_replace('/','_',$EchoDate).'/'.$image)]);
			}
			array_push($Echos,['echography-date' => $EchoDate, 'echography-date-url' => str_replace('/','_',$EchoDate), 'pictures' => $pictures]);
		}

		return view('MyCat/cat_echos',['cat' => $theCat, 'echographies' => $Echos, 'currentdate' => date('m/d/Y'), 'error' => urldecode($error)]);
	}
	//--------------------------------------------------------------------

}
