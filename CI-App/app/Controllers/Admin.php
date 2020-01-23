<?php namespace App\Controllers;


use App\Models\TmpCatModel;
use App\Models\CatModel;
use App\Models\SymptomsModel;
use App\Models\BloodModel;
use App\Models\ValidationModel;
use App\Models\UserModel;



class Admin extends BaseController
{
	public function index()
	{
		$infos = ['user-email' => '', 'user-pw' => ''];
	
		return view("Admin/adm_login",['infos' => $infos, 'loginError' => FALSE, 'errors' => []])
	}

}