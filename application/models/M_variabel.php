<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 06/03/2018
 * Time: 20.51
 */
class M_variabel extends MY_Model
{
	public function __construct()
	{
		$this->table = 'variabel';
		$this->primary_key = 'id_variabel';
		$this->fillable = ['variabel', 'min', 'max', 'tabel', 'field', 'created_by', 'updated_by'];
		$this->protected = [$this->primary_key];
		parent::__construct();
	}
}
