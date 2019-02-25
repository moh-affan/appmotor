<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 06/03/2018
 * Time: 20.51
 */
class M_vw_log_pengunjung extends MY_Model
{
	public function __construct()
	{
		$this->table = 'vw_log_pengunjung';
		$this->primary_key = 'id_log';
		$this->fillable = ['metode', 'nilai', 'urutan', 'merek', 'tipe', 'pengguna'];
		$this->protected = [$this->primary_key];
		parent::__construct();
	}
}
