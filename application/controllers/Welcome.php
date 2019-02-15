<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Member_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->title('Beranda')->menu_active('dashboard')->layout('cloudui')->view('cloudui/beranda')->render();
	}
}
