<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 06/03/2018
 * Time: 20.51
 */
class M_vw_pengunjung extends MY_Model
{
	public function __construct()
	{
		$this->table = 'vw_pengunjung';
		$this->primary_key = 'id_log';
		$this->fillable = ['metode', 'nilai', 'urutan', 'pengguna', 'exec_time', 'sesi'];
		$this->protected = [$this->primary_key];
		parent::__construct();
	}
}
