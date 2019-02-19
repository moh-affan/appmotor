<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengunjung extends Authenticated_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->title('Pengunjung')->menu_active('pengunjung')->layout('cloudui')->view('admin/pengunjung')->render();
	}
}
