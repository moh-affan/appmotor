<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 06/03/2018
 * Time: 20.51
 */
class M_log_rek extends MY_Model
{
	public function __construct()
	{
		$this->table = 'log_rek';
		$this->primary_key = 'id_log';
		$this->fillable = ['motor_id', 'metode', 'nilai', 'urutan', 'created_by', 'updated_by', 'nilai'];
		$this->protected = [$this->primary_key];
		parent::__construct();
	}
}
