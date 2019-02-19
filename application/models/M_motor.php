<?php

/**
 * Created by PhpStorm.
 * User: Affan
 * Date: 06/03/2018
 * Time: 20.51
 */
class M_motor extends MY_Model
{
	public function __construct()
	{
		$this->table = 'motor';
		$this->primary_key = 'id_motor';
		$this->fillable = ['merek', 'tipe', 'harga', 'tangki', 'kecepatan', 'tipetransmisi', 'transmisi', 'bagasi', 'berat', 'warna', 'created_by', 'updated_by'];
		$this->protected = [$this->primary_key];
		parent::__construct();
	}
}
