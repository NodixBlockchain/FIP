<?php namespace App\Controllers;


use App\Models\TmpCatModel;
use App\Models\CatModel;
use App\Models\SymptomsModel;
use App\Models\BloodModel;
use App\Models\ValidationModel;
use App\Models\UserModel;
use App\Models\AdminModel;



class Admin extends BaseController
{
	public function index()
	{
		$session = \Config\Services::session();
		$admHash = $session->get('adm-hash');

		if(($admHash === FALSE)||($admHash === NULL))
			return redirect()->to(site_url('Admin/signin'));

		$admin = new AdminModel();
		$admInfos = $admin->doget($admHash);

		if($admInfos === FALSE)
		{
			$session->destroy();
			return redirect()->to(site_url('Admin/signin'));
		}
		return view("Admin/panel",['infos'=>$admInfos]);
	}

	public function catpic($userHash,$catHash,$pic)
	{
		$session = \Config\Services::session();
		$admHash = $session->get('adm-hash');

		if(($admHash === FALSE)||($admHash === NULL))
			return redirect()->to(site_url('Admin/signin'));

		$this->response->setHeader('content-type',"image/jpg");
		$this->response->setHeader('cache-control',"public, max-age=3600");
		readfile(WRITEPATH.'/data/users/'.$userHash.'/'.$catHash.'/pics/'.urldecode($pic));
	}

	public function cats()
	{
		$session = \Config\Services::session();
		$admHash = $session->get('adm-hash');

		if(($admHash === FALSE)||($admHash === NULL))
			return redirect()->to(site_url('Admin/signin'));

		$admin = new AdminModel();

		$admInfos = $admin->doget($admHash);
		if($admInfos === FALSE)
		{
			$session->destroy();
			return redirect()->to(site_url('Admin/signin'));
		}

		$cat = new CatModel();
		$symptoms = new SymptomsModel();

		$cats = $cat->dogetAll();

		foreach($cats as &$theCat)
		{
			$pics = $cat->dogetpics($theCat['user-hash'], $theCat['cat-hash']);

			$symDates = $symptoms->doloaddates($theCat['user-hash'], $theCat['cat-hash']);
			$theCat['symptoms'] = [];

			foreach($symDates as $symDate)
			{
				$values = $symptoms->doloaddate($theCat['user-hash'], $theCat['cat-hash'],$symDate);
				array_push($theCat['symptoms'], ['symptoms-date' => $symDate, 'symptoms' => $values]);
			}

			if(($pics !== FALSE)&&(count($pics)>0))
			{
				$theCat['picture'] = site_url('Admin/catpic/'.$theCat['user-hash'].'/'.$theCat['cat-hash'].'/'.$pics[0]);
			}
			else
			{
				$theCat['picture'] = base_url().'assets/img/cat_default.png';
			}
		}

		return view("Admin/adm_cats", ['infos' => $admInfos, 'cats' => $cats]);


	}

	public function signin()
	{
		$infos = ['adm-username' => '', 'adm-pw' => ''];
	
		return view("Admin/adm_login", ['infos' => $infos, 'loginError' => FALSE, 'errors' => []]);
	}

	public function do_login()
	{
		$session = \Config\Services::session();
		$admin = new AdminModel();

		$username = $this->request->getPost('adm-username');
		$pw	= $this->request->getPost('adm-pw');

		$newAdmHash = $admin->create_first_admin(['username' => $username, 'pw' => $pw, 'creation-time' => time()]);

		if($newAdmHash !== FALSE)
		{
			$session->start();
			$session->set(['adm-hash' => $newAdmHash]);

			return redirect()->to(site_url('Admin/index'));
		}

		$admInfos = $admin->checkId(['username' => $username, 'pw' => $pw]);

		if($admInfos === FALSE)
		{
			return view('Admin/adm_login', [ 'infos' => ['adm-username' => $username, 'adm-pw' => ''], 'loginError' => TRUE, 'errors' => []]);
		}
		else
		{
			$session = \Config\Services::session();
			$session->start();
			$session->set(['adm-hash' => $admInfos['adm-hash']]);

			return redirect()->to(site_url('Admin/index'));
		}
	}



}