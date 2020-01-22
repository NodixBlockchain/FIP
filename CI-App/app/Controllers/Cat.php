<?php namespace App\Controllers;


use App\Models\TmpCatModel;
use App\Models\CatModel;
use App\Models\SymptomsModel;
use App\Models\BloodModel;
use App\Models\ValidationModel;
use App\Models\UserModel;

class Cat extends BaseController
{

	function checkDate($mydate)
	{
		$segs= explode('/',$mydate);

		if(count($segs)!=3)
			return FALSE;

		return checkdate($segs[0],$segs[1],$segs[2]);
	}
		
	function br2nl($str)
	{
		return str_replace('<br />', "\n", $str);
	}
	
	public function index($catHash=NULL)
	{
		$cat = new TmpCatModel();
		$symptoms = new SymptomsModel();

		$currentDate =  date("m/d/Y");

		if($catHash)
		{
			$inputs = $cat->doloadtmp($catHash);
			
			$inputs['cat-diagnosis'] = $this->br2nl($inputs['cat-diagnosis']);
			$inputs['cat-hash'] = $catHash;

			$syminfos = $symptoms->doloadtmp($catHash);
		}
		else
		{
			$inputs	  = ['parent-first-name' => '','parent-last-name' => '','fb-name' => '','cat-name' => '','cat-birthdate' =>'','cat-birthdate-exact' => '', 'cat-gender' => '','cat-fixed' => '','cat-breed' => '','cat-diagnosis'=>'','cat-diagnosis-date' => $currentDate];
			$syminfos = ['symptoms-misc' => [], 'symptoms-misc-other' => '', 'symptoms-wet' => [], 'symptoms-neuro' => [], 'symptoms-ocular' => [], 'symptoms-FIP' => [], 'symptoms-effusion' => []];
		}

		return view('cat_form1',['errors'=>[],'inputs' => $inputs,'symptoms' => $syminfos]);
	}


	public function review_step1()
	{
		helper('form');

		$cat = new TmpCatModel();
		$symptoms = new SymptomsModel();

		$birthError = FALSE;
		$diagDateError = FALSE;

		$isValid = $this->validate(['parent-first-name' => 'alpha_numeric_space|max_length[64]',
									'parent-last-name' => 'alpha_numeric_space|max_length[64]',
									'fb-name' => 'alpha_numeric_space|max_length[128]',
									'cat-name' => 'required|alpha_numeric_space|max_length[32]',
									'cat-birthdate-exact' =>'in_list[exact,approx]',
									'cat-gender' => 'in_list[male,female]',
									'cat-fixed' => 'in_list[fixed,intact]',
									'cat-breed' => 'alpha_numeric_space|max_length[32]',
									'symptoms-misc-other' => 'alpha_numeric_space|max_length[64]',
									'cat-diagnosis'=> 'max_length[256]']);

		if($this->request->getPost('cat-birthdate'))
		{
			if(!$this->checkDate($this->request->getPost('cat-birthdate')))
			{
				$birthError = TRUE;
				$isValid = FALSE;
			}
		}

		if($this->request->getPost('cat-diagnosis-date'))
		{
			if(!$this->checkDate($this->request->getPost('cat-diagnosis-date')))
			{
				$diagDateError = TRUE;
				$isValid = FALSE;
			}
		}
		
		if (!$isValid )
		{
			$inputs	= [	'parent-first-name' => $this->request->getPost('parent-first-name'),
						'parent-last-name' => $this->request->getPost('parent-last-name'),
						'fb-name' => $this->request->getPost('fb-name'),
						'cat-name' => $this->request->getPost('cat-name'),
						'cat-birthdate' => $this->request->getPost('cat-birthdate'),
						'cat-birthdate-exact' => $this->request->getPost('cat-birthdate-exact'),
						'cat-gender' => $this->request->getPost('cat-gender'),
						'cat-fixed' => $this->request->getPost('cat-fixed'),
						'cat-breed' => $this->request->getPost('cat-breed'),
						'cat-diagnosis'=> $this->request->getPost('cat-diagnosis'),
						'cat-diagnosis-date'=> $this->request->getPost('cat-diagnosis-date')];

			if($this->request->getPost('cat-hash'))
				$inputs['cat-hash'] = $this->request->getPost('cat-hash');

			$symFip = $this->request->getPost('symptoms-FIP');
			$symMisc = $this->request->getPost('symptoms-misc');
			$symWet = $this->request->getPost('symptoms-wet');
			$symNeuro = $this->request->getPost('symptoms-neuro');
			$symOcular = $this->request->getPost('symptoms-ocular');
			$symEffusion = $this->request->getPost('symptoms-effusion');

			$syminfos = ['symptoms-misc' => $symMisc?$symMisc:[],
						 'symptoms-misc-other' => $this->request->getPost('symptoms-misc-other'),
						 'symptoms-wet' => $symWet?$symWet:[],
						 'symptoms-neuro' => $symNeuro?$symNeuro:[],
						 'symptoms-ocular' => $symOcular?$symOcular:[],
						 'symptoms-FIP' => $symFip?$symFip:[],
						 'symptoms-effusion' => $symEffusion?$symEffusion:[]];


			$errors = $this->validator->getErrors();

			if($birthError)
				$errors['cat-birthdate'] = 'invalid date';

			if($diagDateError)
				$errors['cat-diagnosis-date'] = 'invalid date';
				

			return view('cat_form1', ['inputs' => $inputs,'symptoms' => $syminfos, 'errors' => $errors]);
		}
		else
		{
			$catFields = [	'created_time' => time(),
							'parent_first_name' => $this->request->getPost('parent-first-name'),
							'parent_last_name' => $this->request->getPost('parent-last-name'),
							'fb_name' => $this->request->getPost('fb-name'),
							'cat_name' => $this->request->getPost('cat-name'),
							'cat_birthdate' => $this->request->getPost('cat-birthdate'),
							'cat_birthdate_exact' => $this->request->getPost('cat-birthdate-exact'),
							'cat_gender' => $this->request->getPost('cat-gender'),
							'cat_fixed' => $this->request->getPost('cat-fixed'),
							'cat_breed' => $this->request->getPost('cat-breed'),
							'cat_diagnosis' => $this->request->getPost('cat-diagnosis'),
							'cat_diagnosis_date' => $this->request->getPost('cat-diagnosis-date')];

			if($this->request->getPost('cat-hash'))
				$catFields['cat_hash'] = $this->request->getPost('cat-hash');

			$newHash = $cat->dosavetmp($catFields);

			if(!array_key_exists('cat_hash', $catFields))
				$catFields['cat_hash'] = $newHash;

			$symFip = $this->request->getPost('symptoms-FIP');
			$symMisc = $this->request->getPost('symptoms-misc');
			$symWet = $this->request->getPost('symptoms-wet');
			$symNeuro = $this->request->getPost('symptoms-neuro');
			$symOcular = $this->request->getPost('symptoms-ocular');
			$symEffusion = $this->request->getPost('symptoms-effusion');

			$symptoms->dosavetmp(['cat_hash'=> $catFields['cat_hash'],
								  'date' => date("m/d/Y"),
								  'symptoms_misc' => $symMisc?$symMisc:[],
								  'symptoms_misc_other' => $this->request->getPost('symptoms-misc-other'),
								  'symptoms_wet' => $symWet?$symWet:[],
								  'symptoms_neuro' => $symNeuro?$symNeuro:[],
								  'symptoms_ocular' => $symOcular?$symOcular:[],
								  'symptoms_FIP' => $symFip?$symFip:[],
								  'symptoms_effusion' => $symEffusion?$symEffusion:[]]);

			return redirect()->to(site_url('cat/review_step2/'.$catFields['cat_hash']));
		}
	}

	public function tmpcatpic($catHash,$pic)
	{
		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/tmp/pic_'.$catHash.'/'.urldecode($pic));
	}

	public function del_tmp_pic($catHash,$pic)
	{
		$model = new TmpCatModel();
		$model->delpic($catHash,$pic);
		return redirect()->to(site_url('cat/review_step2/'.$catHash));
	}

	public function add_tmp_pic($catHash)
	{
		helper('form');

		if(!$this->validate(['cat-picture' => 'is_image[cat-picture]']))
			return redirect()->to(site_url('cat/review_step2/'.$catHash.'/upload+a+valid+image'));

		$model = new TmpCatModel();

		$file = $this->request->getFile('cat-picture');
		$result = $model->dosavepictmp($catHash, $file, $error);
				
		if($result === FALSE)
			return redirect()->to(site_url('cat/review_step2/'.$catHash.'/'.$error));
		else
			return redirect()->to(site_url('cat/review_step2/'.$catHash));
	}

	public function tmpeyespic($catHash,$pic)
	{
		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/tmp/eyes_'.$catHash.'/'.urldecode($pic));
	}

	public function del_tmp_eyes($catHash,$pic)
	{
		$model = new TmpCatModel();
		$model->deleyes($catHash,$pic);
		return redirect()->to(site_url('cat/review_step2/'.$catHash));
	}

	public function add_tmp_eyes($catHash)
	{
		helper('form');

		if(!$this->validate(['cat-eyes' => 'is_image[cat-eyes]']))
			return redirect()->to(site_url('cat/review_step2/'.$catHash.'/upload+a+valid+image'));

		$file = $this->request->getFile('cat-eyes');
		$date = $this->request->getPost('eye-date');
		
		if(!$this->checkDate($date))
			return redirect()->to(site_url('cat/review_step2/'.$catHash.'/invalid+picture+date'));

		$model = new TmpCatModel();
		$result = $model->dosaveeyestmp($catHash, $file, $date, $error);
	
		if($result === FALSE)
			return redirect()->to(site_url('cat/review_step2/'.$catHash.'/'.$error));
		else
			return redirect()->to(site_url('cat/review_step2/'.$catHash));
	}

	public function review_step2($catHash,$error = NULL)
	{
		$cat = new TmpCatModel();
		$symptoms = new SymptomsModel();
		
		$catData = $cat->doloadtmp($catHash);
		if($catData === FALSE)
		{
			echo "cat not found $catHash \n";
			return;
		}

		$syminfos = $symptoms->doloadtmp($catHash);

		$images = $cat->doloadpicstmp($catHash);
		$pictures = [];
		foreach($images as $image)
		{
			array_push($pictures, ['file' => $image, 'url' => site_url('cat/tmpcatpic/'.$catHash.'/'.$image)]);
		}

		$images = $cat->doloadeyestmp($catHash);
		$eyes = [];
		foreach($images as $image)
		{
			array_push($eyes, ['file' => $image, 'url' => site_url('cat/tmpeyespic/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$eyeDate = $cat->dogeteyesdate($catHash);

		if($eyeDate===FALSE)
			$eyeDate = date("m/d/Y");

		echo view('cat_review1',['catHash' => $catHash, 'inputs' =>$catData, 'symptoms' => $syminfos, 'pictures' => $pictures, 'eyes' => $eyes, 'currentdate' => $eyeDate, 'error' => urldecode($error)]);
	}
	
	public function tmpxray($catHash,$pic)
	{
		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/tmp/xray_'.$catHash.'/'.urldecode($pic));
	}

	public function tmpechography($catHash,$pic)
	{
		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/tmp/echo_'.$catHash.'/'.urldecode($pic));
	}

	public function del_tmp_xray($catHash,$pic)
	{
		$model = new TmpCatModel();
		$model->delxray($catHash,$pic);
		return redirect()->to(site_url('cat/review_step3/'.$catHash));
	}

	public function del_tmp_echo($catHash,$pic)
	{
		$model = new TmpCatModel();
		$model->delecho($catHash,$pic);
		return redirect()->to(site_url('cat/review_step3/'.$catHash));
	}

	public function add_tmp_xray($catHash)
	{
		helper('form');

		if(!$this->validate(['cat-xray' => 'is_image[cat-xray]']))
			return redirect()->to(site_url('cat/review_step3/'.$catHash.'/upload+a+valid+image'));

		$model = new TmpCatModel();
		$file = $this->request->getFile('cat-xray');
		$date = $this->request->getPost('xray-date');

		if(!$this->checkDate($date))
			return redirect()->to(site_url('cat/review_step3/'.$catHash.'/invalid+picture+date'));

		$result = $model->dosavexraytmp($catHash, $file, $date, $error);

		if($result === FALSE )
			return redirect()->to(site_url('cat/review_step3/'.$catHash.'/'.$error));
		else
			return redirect()->to(site_url('cat/review_step3/'.$catHash));
	}

	public function add_tmp_echography($catHash)
	{
		helper('form');

		if(!$this->validate(['cat-echography' => 'is_image[cat-echography]']))
			return redirect()->to(site_url('cat/review_step3/'.$catHash.'/upload+a+valid+image'));

		$model = new TmpCatModel();
		$file = $this->request->getFile('cat-echography');
		$date = $this->request->getPost('echography-date');

		if(!$this->checkDate($date))
			return redirect()->to(site_url('cat/review_step3/'.$catHash.'/invalid+picture+date'));

		$result = $model->dosaveechographytmp($catHash, $file, $date, $error);
					
		if($result === FALSE )
			return redirect()->to(site_url('cat/review_step3/'.$catHash.'/'.$error));
		else
			return redirect()->to(site_url('cat/review_step3/'.$catHash));
	}

	public function review_step3($catHash,$error = NULL)
	{
		$cat = new TmpCatModel();
		$symptoms = new SymptomsModel();
		
		$catData = $cat->doloadtmp($catHash);
		$syminfos = $symptoms->doloadtmp($catHash);

		$images = $cat->doloadpicstmp($catHash);
		$pictures = [];
		foreach($images as $image)
		{
			array_push($pictures,['url' => site_url('cat/tmpcatpic/'.$catHash.'/'.$image)]);
		}

		$images = $cat->doloadeyestmp($catHash);
		$eyes = [];
		foreach($images as $image)
		{
			array_push($eyes,['url' => site_url('cat/tmpeyespic/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$images = $cat->doloadxraystmp($catHash);
		$xrays = [];
		foreach($images as $image)
		{
			array_push($xrays,['file' => $image, 'url' => site_url('cat/tmpxray/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$images = $cat->doloadechographytmp($catHash);
		$echographies = [];
		foreach($images as $image)
		{
			array_push($echographies,['file' => $image, 'url' => site_url('cat/tmpechography/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$xrayDate = $cat->dogetxraydate($catHash);

		if($xrayDate===FALSE)
			$xrayDate= date("m/d/Y");

		$echoDate = $cat->dogetechodate($catHash);

		if($echoDate===FALSE)
			$echoDate= date("m/d/Y");

		echo view('cat_review2',['catHash' => $catHash, 'symptoms' => $syminfos, 'inputs' => $catData , 'pictures' => $pictures, 'eyes' => $eyes, 'xrays' => $xrays, 'echographies' => $echographies,'xrayDate' => $xrayDate,'echoDate' => $echoDate, 'error'=>urldecode($error)]);
	}

	public function tmpblood($catHash,$pic)
	{
		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/tmp/blood_'.$catHash.'/'.urldecode($pic));
	}

	public function del_tmp_blood($catHash,$pic)
	{
		$model = new TmpCatModel();
		$model->deltmpblood($catHash,$pic);
		return redirect()->to(site_url('cat/review_step4/'.$catHash));
	}
	
	public function add_tmp_blood($catHash)
	{
		helper('form');

		if(!$this->validate(['cat-blood' => 'is_image[cat-blood]']))
			return redirect()->to(site_url('cat/review_step4/'.$catHash.'/upload+a+valid+image'));

		$model = new BloodModel();
		$file = $this->request->getFile('cat-blood');
		$date = $this->request->getPost('blood-date');

		if(!$this->checkDate($date))
			return redirect()->to(site_url('cat/review_step4/'.$catHash.'/invalid+picture+date'));
	
		$result = $model->dosavebloodtmp($catHash, $file, $date, $error);
			
		if($result === FALSE)
			return redirect()->to(site_url('cat/review_step4/'.$catHash.'/'.$error));
		else
			return redirect()->to(site_url('cat/review_step4/'.$catHash));
	}


	public function review_step4($catHash,$error = NULL)
	{
		$cat = new TmpCatModel();
		$blood = new BloodModel();
		$symptoms = new SymptomsModel();

		$catData = $cat->doloadtmp($catHash);
		$syminfos = $symptoms->doloadtmp($catHash);

		$images = $cat->doloadpicstmp($catHash);
		$pictures = [];
		foreach($images as $image)
		{
			array_push($pictures,['url' => site_url('cat/tmpcatpic/'.$catHash.'/'.$image)]);
		}

		$images = $cat->doloadeyestmp($catHash);
		$eyes = [];
		foreach($images as $image)
		{
			array_push($eyes,['url' => site_url('cat/tmpeyespic/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$images = $cat->doloadxraystmp($catHash);
		$xrays = [];
		foreach($images as $image)
		{
			array_push($xrays,['url' => site_url('cat/tmpxray/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$images = $cat->doloadechographytmp($catHash);
		$echographies = [];
		foreach($images as $image)
		{
			array_push($echographies,['url' => site_url('cat/tmpechography/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$images = $blood->doloadbloodtmp($catHash);
		$blood = [];
		foreach($images as $image)
		{
			array_push($blood,['file' => $image, 'url' => site_url('cat/tmpblood/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$bloodDate = $cat->dogetblooddate($catHash);

		if($bloodDate === FALSE)
			$bloodDate = date("m/d/Y");

		$echoDate = $cat->dogetechodate($catHash);

		return view('cat_review3',['catHash' => $catHash, 'symptoms' => $syminfos, 'bloodDate' => $bloodDate, 'blood' => $blood, 'inputs' => $catData, 'pictures' => $pictures, 'eyes' => $eyes, 'xrays' => $xrays, 'echographies' => $echographies, 'error' => urldecode($error)]);
	}


	public function review_step5($catHash)
	{
		$cat = new TmpCatModel();
		$blood = new BloodModel();
		$symptoms = new SymptomsModel();

		if(!$cat->hastmpBlood($catHash)){
			return redirect()->to(site_url('cat/review_step6/'.$catHash));
		}

		$catData = $cat->doloadtmp($catHash);
		$syminfos = $symptoms->doloadtmp($catHash);

		$images = $blood->doloadbloodtmp($catHash);
		$bloods = [];
		foreach($images as $image)
		{
			array_push($bloods,['url' => site_url('cat/tmpblood/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$blood_vals = $blood->doloadtmp($catHash);

		return view('cat_review4',['catHash' => $catHash, 'inputs' => $catData , 'symptoms' => $syminfos, 'blood' => $bloods, 'blood_vals' => $blood_vals, 'errors'=>[]]);
	}

	public function check_step5($catHash)
	{
		helper('form');
		$cat = new TmpCatModel();
		$blood = new BloodModel();
		$symptoms = new SymptomsModel();

		$images = $blood->doloadbloodtmp($catHash);
		$bloods = [];
		foreach($images as $image)
		{
			$bloodDate = str_replace("_","/",substr($image,41));

			array_push($bloods, ['url' => site_url('cat/tmpblood/'.$catHash.'/'.$image), 'date' => $bloodDate]);
		}

		if (! $this->validate([	'cat-red-cells' => "greater_than_equal_to[0]",
								'cat-hematocrit' => "greater_than_equal_to[0]",
								'cat-hemaglobin' => "greater_than_equal_to[0]",
								'cat-white-cells' => "greater_than_equal_to[0]",
								'cat-lymphocytes' => "greater_than_equal_to[0]",
								'cat-neutrophils' => "greater_than_equal_to[0]",
								'cat-total-protein' =>"greater_than_equal_to[0]",
								'cat-albumin' => "greater_than_equal_to[0]",
								'cat-globulin' => "greater_than_equal_to[0]",
								'cat-ag-ratio' => "greater_than_equal_to[0]",
								'cat-total-bilirubin' => "greater_than_equal_to[0]"]))
		{

			$catData = $cat->doloadtmp($catHash);
			$syminfos = $symptoms->doloadtmp($catHash);

			$blood_vals = $this->request->getPost();
			$errors = $this->validator->getErrors();

			foreach($blood_vals as $key => $input)
			{
				if(array_key_exists($key, $errors))
					$blood_vals[$key]=0;
			}

			return view('cat_review4', ['catHash' => $catHash, 'inputs' => $catData, 'symptoms' => $syminfos, 'blood' => $bloods, 'blood_vals' => $blood_vals, 'errors' => $errors]);
		}
		else
		{
			$blood->dosavetmp([ 'cat_hash' => $catHash,
								'cat_blood_date' => $bloodDate,
								'cat_red_cells' => $this->request->getPost('cat-red-cells'),
								'cat_hematocrit' => $this->request->getPost('cat-hematocrit'),
								'cat_hemaglobin' => $this->request->getPost('cat-hemaglobin'),
								'cat_white_cells' => $this->request->getPost('cat-white-cells'),
								'cat_lymphocytes' => $this->request->getPost('cat-lymphocytes'),
								'cat_neutrophils' => $this->request->getPost('cat-neutrophils'),
								'cat_total_protein' => $this->request->getPost('cat-total-protein'),
								'cat_albumin' => $this->request->getPost('cat-albumin'),
								'cat_globulin' => $this->request->getPost('cat-globulin'),
								'cat_ag_ratio' => $this->request->getPost('cat-ag-ratio'),
								'cat_total_bilirubin' => $this->request->getPost('cat-total-bilirubin')]);

			return redirect()->to(site_url('cat/review_step6/'.$catHash));
		}
	}


	public function review_step6($catHash)
	{
		$cat = new TmpCatModel();
		$blood = new BloodModel();
		$symptoms = new SymptomsModel();

		$catData = $cat->doloadtmp($catHash);
		$syminfos = $symptoms->doloadtmp($catHash);

		$images = $cat->doloadpicstmp($catHash);
		$pictures=[];
		foreach($images as $image)
		{
			array_push($pictures, ['url' => site_url('cat/tmpcatpic/'.$catHash.'/'.$image)]);
		}

		$images = $cat->doloadeyestmp($catHash);
		$eyes=[];
		foreach($images as $image)
		{
			array_push($eyes, ['url' => site_url('cat/tmpeyespic/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$images = $cat->doloadxraystmp($catHash);
		$xrays=[];
		foreach($images as $image)
		{
			array_push($xrays, ['url' => site_url('cat/tmpxray/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		$images = $cat->doloadechographytmp($catHash);
		$echographies=[];
		foreach($images as $image)
		{
			array_push($echographies, ['url' => site_url('cat/tmpechography/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
		}

		if($cat->hastmpBlood($catHash))
		{
			$images = $blood->doloadbloodtmp($catHash);
			$bloods=[];
			foreach($images as $image)
			{
				array_push($bloods, ['url' => site_url('cat/tmpblood/'.$catHash.'/'.$image), 'date' => str_replace("_","/",substr($image,41))]);
			}
			$blood_vals = $blood->doloadtmp($catHash);
			$has_blood = TRUE;
		}
		else
		{
			$bloods = [];
			$blood_vals = [];
			$has_blood = FALSE;
		}

		return view('cat_review5',['catHash' => $catHash, 'symptoms' => $syminfos, 'inputs' => $catData, 'pictures' => $pictures, 'eyes' => $eyes, 'xrays' => $xrays, 'echographies' => $echographies, 'has_blood' => $has_blood, 'blood' => $bloods, 'blood_vals' => $blood_vals, 'errors' => []]);
	}


	public function register($catHash)
	{
		$cat = new TmpCatModel();
		$symptoms = new SymptomsModel();

		$session = \Config\Services::session();
		$userHash = $session->get('user-hash');

		if($userHash)
		{
			$blood = new BloodModel();

			$newCatHash = $cat->validate_tmp_cat ($catHash, $userHash);
			$blood->validate_tmp_cat			 ($catHash, $newCatHash, $userHash);
			$symptoms->validate_tmp_cat			 ($catHash, $newCatHash, $userHash);

			return redirect()->to(site_url('MyCat/index'));
		}
		
		$catData = $cat->doloadtmp($catHash);
		$syminfos = $symptoms->doloadtmp($catHash);

		$infos = ['user-email' => "", 'user-pw' => "", 'user-pw2' => "", 'user-weight-unit' => 'kg', 'user-temp-unit' => 'celsius'];

		return view('cat_register', ['catHash' => $catHash, 'symptoms' => $syminfos, 'infos' => $infos, 'inputs' => $catData, 'errors' => []]);
	}

	public function do_register($catHash)
	{
		helper('form');
		$cat = new TmpCatModel();
		$symptoms = new SymptomsModel();
		
		$catData = $cat->doloadtmp($catHash);
		$syminfos = $symptoms->doloadtmp($catHash);


		if (! $this->validate([	'user-email' => "required|trim|valid_email",
								'user-pw' => "required|min_length[6]|max_length[32]",
								'user-weight-unit' => 'in_list[kg,pnd]',
								'user-temp-unit' => 'in_list[celsius,fahrenheit]',
								'user-timezone' => 'timezone',
								'user-pw2' => "matches[user-pw]"]))
		{
			return view('cat_register', ['catHash' => $catHash, 'symptoms' => $syminfos, 'infos' => $this->request->getPost(), 'inputs' => $catData, 'errors' => $this->validator->getErrors()]);
		}
		else
		{
			$user = new UserModel();

			$infos = $user->checkId(['email' => $this->request->getPost('user-email'), 'pw' => $this->request->getPost('user-pw')]);

			if($infos !== FALSE)
			{
				$blood = new BloodModel();

				$newCatHash = $cat->validate_tmp_cat($catHash, $infos['user-hash']);
				$blood->validate_tmp_cat			($catHash ,$newCatHash, $infos['user-hash']);
				$symptoms->validate_tmp_cat			($catHash, $newCatHash, $infos['user-hash']);

				return redirect()->to(site_url('MyCat/index'));
			}
			else
			{	
				if($user->findbymail($this->request->getPost('user-email')))
				{
					$errors['user-email'] = 'email already used';
					$errors['user-pw'] = 'wrong password';
					return view('cat_register', ['catHash' => $catHash, 'inputs'  => $catData, 'symptoms' => $syminfos, 'infos' => $this->request->getPost(), 'errors' => $errors]);
				}
				else
				{
					$valid = new ValidationModel();
					$validationCode = $valid->create_code($catHash, $this->request->getPost('user-email'), $this->request->getPost('user-pw'), $this->request->getPost('user-weight-unit'), $this->request->getPost('user-temp-unit'), $this->request->getPost('user-timezone'));
					return redirect()->to(site_url('cat/prevalidate_cat/'.$validationCode));
				}
			}
		}
	}


	public function prevalidate_cat($validationCode)
	{
		return view('prevalidate',['valCode' => $validationCode]);
	}

	public function validate_cat($validationCode)
	{
		$valid= new ValidationModel();
		$cat = new TmpCatModel();
		$blood = new BloodModel();
		$symptoms = new SymptomsModel();
		$user = new UserModel();

		$infos = $valid->getvalidation($validationCode);

		if($infos  !== FALSE)
		{
			$result = $user->dosave(['email' => $infos['user-email'],
									 'pwhash' => $infos['user-pw-hash'],
									 'weight_unit' => $infos['user-weight-unit'],
									 'temp_unit' => $infos['user-temp-unit'],
									 'timezone' => $infos['user-timezone'],
									 'creation_time'=>$infos['user-creation-time']]);

			if($result !== FALSE)
			{
				$newCatHash = $cat->validate_tmp_cat($infos['cat-hash'], $result);

				$blood->validate_tmp_cat			($infos['cat-hash'], $newCatHash, $result);
				$symptoms->validate_tmp_cat			($infos['cat-hash'], $newCatHash, $result);

				return redirect()->to(site_url('MyCat/signin'));
			}
		}
		else
		{
			echo 'validation code invalid';
		}
	}
	
	public function signin()
	{
		return redirect()->to(site_url('MyCat/signin'));
	}

}
