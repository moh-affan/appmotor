<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 06/03/2018
 * Time: 20.51
 */
class M_rule extends MY_Model
{
	public function __construct()
	{
		$this->table = 'rule';
		$this->primary_key = 'id_rule';
		$this->fillable = ['harga', 'tangki', 'kecepatan', 'bagasi', 'berat', 'created_by', 'updated_by', 'nilai'];
		$this->protected = [$this->primary_key];
		parent::__construct();
	}
}
