<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Authenticated_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->title('Dashboard')->menu_active('dashboard')->layout('cloudui')->view('admin/beranda')->render();
	}
}
